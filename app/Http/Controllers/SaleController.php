<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Client;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\SystemSetting;

class SaleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the sales.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['client', 'user', 'saleItems.product']);

        // Search functionality - CORRIGÉ
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('sale_number', 'LIKE', "%{$search}%")
                  ->orWhere('prescription_number', 'LIKE', "%{$search}%")
                  ->orWhere('notes', 'LIKE', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('first_name', 'LIKE', "%{$search}%")
                                 ->orWhere('last_name', 'LIKE', "%{$search}%")
                                 ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$search}%")
                                 ->orWhere('email', 'LIKE', "%{$search}%")
                                 ->orWhere('phone', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('saleItems.product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'LIKE', "%{$search}%")
                                  ->orWhere('barcode', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by payment status - CORRIGÉ
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range - CORRIGÉ
        if ($request->filled('date_from')) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        // Filter by prescription - CORRIGÉ
        if ($request->filled('has_prescription')) {
            $query->where('has_prescription', $request->has_prescription === 'yes');
        }

        // Filter by payment method - NOUVEAU FILTRE
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Paginer les résultats filtrés
        $sales = $query->latest('sale_date')->paginate(15);
        
        // Calculate summary statistics sur toutes les ventes (pas seulement les filtrées)
        $allSales = Sale::all();
        $totalSales = $allSales->sum('total_amount');
        $salesCount = $allSales->count();
        $averageSale = $salesCount > 0 ? $totalSales / $salesCount : 0;
        $todaySales = Sale::whereDate('sale_date', today())->count();
        
        return view('sales.index', compact('sales', 'totalSales', 'salesCount', 'averageSale', 'todaySales'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create(Request $request)
    {
        $clients = Client::active()->orderBy('first_name')->get();
        $products = Product::where('stock_quantity', '>', 0)->orderBy('name')->get();
        
        // Pre-select client if passed in URL
        $selectedClientId = $request->get('client_id');
        
        // Get current tax rate from system settings
        $taxRate = SystemSetting::get('default_tax_rate', 20);
        
        return view('sales.create', compact('clients', 'products', 'selectedClientId', 'taxRate'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Sale creation attempt', [
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            $validator = Validator::make($request->all(), [
                'client_id' => 'nullable|exists:clients,id',
                'payment_method' => 'required|in:cash,card,insurance,other',
                'has_prescription' => 'boolean',
                'prescription_number' => 'nullable|string|max:255',
                'discount_amount' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ], [
                'products.required' => 'Veuillez ajouter au moins un produit à la vente.',
                'products.*.id.required' => 'ID produit manquant.',
                'products.*.id.exists' => 'Un des produits sélectionnés n\'existe pas.',
                'products.*.quantity.required' => 'Quantité manquante pour un produit.',
                'products.*.quantity.min' => 'La quantité doit être d\'au moins 1.',
            ]);

            if ($validator->fails()) {
                Log::warning('Sale creation validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'request_data' => $request->all()
                ]);
                
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Validate stock availability and prepare product data
            $productData = [];
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                if (!$product) {
                    Log::error('Product not found', ['product_id' => $item['id']]);
                    return redirect()->back()
                        ->withErrors(['products' => "Produit avec l'ID {$item['id']} introuvable."])
                        ->withInput();
                }
                
                $quantity = (int) $item['quantity'];
                if ($product->stock_quantity < $quantity) {
                    Log::warning('Insufficient stock', [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'available_stock' => $product->stock_quantity,
                        'requested_quantity' => $quantity
                    ]);
                    return redirect()->back()
                        ->withErrors(['products' => "Stock insuffisant pour {$product->name}. Stock disponible: {$product->stock_quantity}, demandé: {$quantity}"])
                        ->withInput();
                }
                
                $productData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }

            DB::beginTransaction();
            
            try {
                // Get current tax rate from system settings
                $taxRate = SystemSetting::get('default_tax_rate', 20) / 100;
                
                // Create sale
                $sale = new Sale();
                $sale->client_id = $request->client_id;
                $sale->user_id = auth()->id();
                $sale->payment_method = $request->payment_method;
                $sale->payment_status = 'paid';
                $sale->has_prescription = $request->has('has_prescription');
                $sale->prescription_number = $request->prescription_number;
                $sale->discount_amount = $request->discount_amount ?? 0;
                $sale->notes = $request->notes;
                $sale->sale_date = now();
                
                // Calculate totals before saving
                $subtotal = 0;
                foreach ($productData as $item) {
                    $subtotal += $item['product']->selling_price * $item['quantity'];
                }
                
                $sale->subtotal = $subtotal;
                $sale->tax_amount = $subtotal * $taxRate; // Use dynamic tax rate
                $sale->total_amount = $subtotal + $sale->tax_amount - $sale->discount_amount;
                
                $sale->save();

                Log::info('Sale created successfully', [
                    'sale_id' => $sale->id,
                    'sale_number' => $sale->sale_number,
                    'total_amount' => $sale->total_amount,
                    'tax_rate_used' => $taxRate * 100 . '%'
                ]);

                // Create sale items and update stock
                foreach ($productData as $item) {
                    $saleItem = new SaleItem();
                    $saleItem->sale_id = $sale->id;
                    $saleItem->product_id = $item['product']->id;
                    $saleItem->quantity = $item['quantity'];
                    $saleItem->unit_price = $item['product']->selling_price;
                    $saleItem->total_price = $item['product']->selling_price * $item['quantity'];
                    $saleItem->save();

                    // Update product stock
                    $oldStock = $item['product']->stock_quantity;
                    $item['product']->decrement('stock_quantity', $item['quantity']);
                    $newStock = $item['product']->fresh()->stock_quantity;
                    
                    Log::info('Product stock updated', [
                        'product_id' => $item['product']->id,
                        'product_name' => $item['product']->name,
                        'quantity_sold' => $item['quantity'],
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock
                    ]);

                    // Log stock change - only if ActivityLog class exists and has the method
                    try {
                        if (class_exists('App\Models\ActivityLog') && method_exists(ActivityLog::class, 'logStockChange')) {
                            ActivityLog::logStockChange(
                                $item['product'], 
                                $oldStock, 
                                $newStock, 
                                "Vente #{$sale->sale_number}"
                            );
                        }
                    } catch (\Exception $e) {
                        Log::warning('Could not log stock change', ['error' => $e->getMessage()]);
                    }
                }

                // Log sale creation - only if ActivityLog class exists and has the method
                try {
                    if (class_exists('App\Models\ActivityLog') && method_exists(ActivityLog::class, 'logTransaction')) {
                        $clientName = $sale->client ? $sale->client->full_name : 'Client anonyme';
                        ActivityLog::logTransaction('sale', $sale, 'create', [
                            'client_name' => $clientName,
                            'total_amount' => $sale->total_amount,
                            'payment_method' => $sale->payment_method,
                            'products_count' => count($productData),
                            'tax_rate_used' => $taxRate * 100 . '%'
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Could not log sale transaction', ['error' => $e->getMessage()]);
                }

                DB::commit();

                return redirect()->route('sales.show', $sale->id)
                    ->with('success', 'Vente enregistrée avec succès!');
                    
            } catch (\Exception $e) {
                DB::rollback();
                
                Log::error('Sale creation database error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'request_data' => $request->all()
                ]);
                
                return redirect()->back()
                    ->withErrors(['error' => 'Erreur lors de l\'enregistrement de la vente: ' . $e->getMessage()])
                    ->withInput();
            }
                
        } catch (\Exception $e) {
            Log::error('Sale creation general error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Erreur inattendue: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified sale.
     */
    public function show($id)
    {
        $sale = Sale::with(['client', 'user', 'saleItems.product'])->findOrFail($id);
        
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit($id)
    {
        $sale = Sale::with(['saleItems.product'])->findOrFail($id);
        $clients = Client::active()->orderBy('first_name')->get();
        
        return view('sales.edit', compact('sale', 'clients'));
    }

    /**
     * Update the specified sale in storage.
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $oldValues = $sale->toArray();

        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:paid,pending,failed',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $sale->payment_status = $request->payment_status;
        $sale->notes = $request->notes;
        $sale->save();

        // Log the update - only if ActivityLog exists
        try {
            if (class_exists('App\Models\ActivityLog') && method_exists(ActivityLog::class, 'logTransaction')) {
                ActivityLog::logTransaction('sale', $sale, 'update', [
                    'changes' => [
                        'payment_status' => ['old' => $oldValues['payment_status'], 'new' => $sale->payment_status],
                        'notes' => ['old' => $oldValues['notes'], 'new' => $sale->notes]
                    ]
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Could not log sale update', ['error' => $e->getMessage()]);
        }

        return redirect()->route('sales.show', $sale->id)
            ->with('success', 'Vente mise à jour avec succès!');
    }

    /**
     * Remove the specified sale from storage.
     */
    public function destroy($id)
    {
        $sale = Sale::with(['saleItems.product'])->findOrFail($id);
        
        // Vérifier si la vente peut être supprimée
        if ($sale->sale_date < now()->subDays(7)) {
            return redirect()->route('sales.index')
                ->withErrors(['error' => 'Impossible de supprimer une vente de plus de 7 jours.']);
        }

        DB::beginTransaction();
        
        try {
            $saleData = $sale->toArray();
            $restoredProducts = [];
            
            // Restaurer le stock des produits
            foreach ($sale->saleItems as $item) {
                if ($item->product) { // Vérifier que le produit existe encore
                    $oldStock = $item->product->stock_quantity;
                    $item->product->increment('stock_quantity', $item->quantity);
                    $newStock = $item->product->fresh()->stock_quantity;
                    
                    $restoredProducts[] = [
                        'name' => $item->product->name,
                        'quantity' => $item->quantity
                    ];
                    
                    Log::info('Stock restored for product', [
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'quantity_restored' => $item->quantity,
                        'new_stock' => $newStock
                    ]);
                    
                    // Log stock change
                    try {
                        if (class_exists('App\Models\ActivityLog') && method_exists(ActivityLog::class, 'logStockChange')) {
                            ActivityLog::logStockChange(
                                $item->product,
                                $oldStock,
                                $newStock,
                                "Restauration suite à suppression vente #{$sale->sale_number}"
                            );
                        }
                    } catch (\Exception $e) {
                        Log::warning('Could not log stock restoration', ['error' => $e->getMessage()]);
                    }
                }
            }
            
            // Supprimer les items de vente
            $sale->saleItems()->delete();
            
            // Supprimer la vente
            $sale->delete();
            
            // Log deletion
            try {
                if (class_exists('App\Models\ActivityLog') && method_exists(ActivityLog::class, 'logActivity')) {
                    ActivityLog::logActivity(
                        'delete',
                        "Vente supprimée: {$sale->sale_number} | Montant: {$sale->total_amount}€ | Produits restaurés: " . count($restoredProducts),
                        null,
                        $saleData,
                        [
                            'deleted_by' => auth()->user()->name,
                            'restored_products' => $restoredProducts,
                            'sale_data' => $saleData
                        ]
                    );
                }
            } catch (\Exception $e) {
                Log::warning('Could not log sale deletion', ['error' => $e->getMessage()]);
            }
            
            DB::commit();
            
            Log::info('Sale deleted successfully', [
                'sale_id' => $id,
                'sale_number' => $saleData['sale_number'],
                'deleted_by' => auth()->id(),
                'restored_products_count' => count($restoredProducts)
            ]);

            return redirect()->route('sales.index')
                ->with('success', 'Vente supprimée avec succès! Le stock a été restauré pour ' . count($restoredProducts) . ' produit(s).');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Sale deletion failed', [
                'sale_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('sales.index')
                ->withErrors(['error' => 'Erreur lors de la suppression de la vente. Veuillez réessayer.']);
        }
    }

    /**
     * Get product details for AJAX requests.
     */
    public function getProduct($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['error' => 'Produit non trouvé'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->selling_price,
            'stock' => $product->stock_quantity,
            'prescription_required' => $product->prescription_required,
        ]);
    }

    /**
     * Print sale receipt.
     */
    public function print($id)
    {
        $sale = Sale::with(['client', 'user', 'saleItems.product'])->findOrFail($id);
        
        return view('sales.print', compact('sale'));
    }

    /**
     * Get current tax rate from system settings for AJAX requests.
     */
    public function getTaxRate()
    {
        $taxRate = SystemSetting::get('default_tax_rate', 20);
        
        return response()->json([
            'tax_rate' => $taxRate,
            'tax_rate_decimal' => $taxRate / 100
        ]);
    }

    /**
     * Export sales to CSV
     */
    public function export(Request $request)
    {
        $query = Sale::with(['client', 'user', 'saleItems.product']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('sale_number', 'LIKE', "%{$search}%")
                  ->orWhere('prescription_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('first_name', 'LIKE', "%{$search}%")
                                 ->orWhere('last_name', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        if ($request->filled('has_prescription')) {
            $query->where('has_prescription', $request->has_prescription === 'yes');
        }

        $sales = $query->latest('sale_date')->get();

        // Log export activity
        try {
            if (class_exists('App\Models\ActivityLog') && method_exists(ActivityLog::class, 'logActivity')) {
                ActivityLog::logActivity(
                    'export',
                    'Export de la liste des ventes (' . $sales->count() . ' ventes)',
                    null,
                    null,
                    [
                        'export_count' => $sales->count(),
                        'exported_by' => auth()->user()->name,
                        'filters_applied' => $request->only(['search', 'payment_status', 'date_from', 'date_to', 'has_prescription'])
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::warning('Could not log export activity', ['error' => $e->getMessage()]);
        }

        $filename = 'ventes_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($sales) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // CSV headers
            fputcsv($file, [
                'N° Vente',
                'Date',
                'Client',
                'Vendeur',
                'Produits',
                'Montant HT',
                'TVA',
                'Remise',
                'Montant TTC',
                'Méthode paiement',
                'Statut paiement',
                'Ordonnance',
                'N° Ordonnance',
                'Notes'
            ], ';');

            foreach ($sales as $sale) {
                $products = $sale->saleItems->map(function($item) {
                    return ($item->product ? $item->product->name : 'Produit supprimé') . ' (x' . $item->quantity . ')';
                })->implode(', ');

                fputcsv($file, [
                    $sale->sale_number,
                    $sale->sale_date ? $sale->sale_date->format('d/m/Y H:i') : 'N/A',
                    $sale->client ? $sale->client->full_name : 'Client anonyme',
                    $sale->user ? $sale->user->name : 'Utilisateur supprimé',
                    $products,
                    number_format($sale->subtotal, 2, ',', ' '),
                    number_format($sale->tax_amount, 2, ',', ' '),
                    number_format($sale->discount_amount, 2, ',', ' '),
                    number_format($sale->total_amount, 2, ',', ' '),
                    ucfirst($sale->payment_method),
                    ucfirst($sale->payment_status),
                    $sale->has_prescription ? 'Oui' : 'Non',
                    $sale->prescription_number ?: 'N/A',
                    $sale->notes ?: 'Aucune'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get sales statistics for dashboard/reports
     */
    public function getStatistics(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        
        $statistics = [
            'total_sales' => Sale::whereBetween('sale_date', [$startDate, $endDate])->sum('total_amount'),
            'sales_count' => Sale::whereBetween('sale_date', [$startDate, $endDate])->count(),
            'average_sale' => Sale::whereBetween('sale_date', [$startDate, $endDate])->avg('total_amount'),
            'today_sales' => Sale::whereDate('sale_date', today())->sum('total_amount'),
            'today_count' => Sale::whereDate('sale_date', today())->count(),
            'payment_methods' => Sale::whereBetween('sale_date', [$startDate, $endDate])
                ->groupBy('payment_method')
                ->selectRaw('payment_method, count(*) as count, sum(total_amount) as total')
                ->get(),
            'top_products' => SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->whereBetween('sales.sale_date', [$startDate, $endDate])
                ->groupBy('products.id', 'products.name')
                ->selectRaw('products.name, sum(sale_items.quantity) as total_quantity, sum(sale_items.total_price) as total_revenue')
                ->orderBy('total_quantity', 'desc')
                ->take(10)
                ->get(),
        ];
        
        return response()->json($statistics);
    }
    
}