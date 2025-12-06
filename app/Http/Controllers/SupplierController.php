<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Plus besoin de middleware admin ici car déjà appliqué dans les routes
    }

    /**
     * Display a listing of the suppliers.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('contact_person', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('notes', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('active', false);
            }
        }

        // Order by name and paginate
        $suppliers = $query->withCount('products')
                          ->orderBy('name', 'asc')
                          ->paginate(15)
                          ->appends($request->query());

        // Calculer les statistiques
        $totalSuppliers = Supplier::count();
        $activeSuppliers = Supplier::where('active', true)->count();
        $inactiveSuppliers = Supplier::where('active', false)->count();
        $suppliersWithProducts = Supplier::has('products')->count();

        return view('suppliers.index', compact(
            'suppliers',
            'totalSuppliers', 
            'activeSuppliers', 
            'inactiveSuppliers',
            'suppliersWithProducts'
        ));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact_person' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
            'address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Le nom du fournisseur est obligatoire.',
            'name.unique' => 'Ce nom de fournisseur existe déjà.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $supplier = new Supplier();
            $supplier->fill($request->all());
            $supplier->active = $request->has('active') ? true : false;
            $supplier->save();

            return redirect()->route('suppliers.index')
                ->with('success', 'Fournisseur ajouté avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de l\'ajout du fournisseur.'])
                ->withInput();
        }
    }

    /**
     * Display the specified supplier.
     */
    public function show($id)
    {
        try {
            $supplier = Supplier::with(['products' => function($query) {
                $query->latest()->take(10);
            }])->findOrFail($id);
            
            $recentProducts = $supplier->products;
            $totalProducts = $supplier->products()->count();
            $lowStockProducts = $supplier->products()
                ->whereColumn('stock_quantity', '<=', 'stock_threshold')
                ->count();
            
            return view('suppliers.show', compact('supplier', 'recentProducts', 'totalProducts', 'lowStockProducts'));
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')
                ->withErrors(['error' => 'Fournisseur introuvable.']);
        }
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            return view('suppliers.edit', compact('supplier'));
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')
                ->withErrors(['error' => 'Fournisseur introuvable.']);
        }
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name,'.$id,
            'contact_person' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:suppliers,email,'.$id,
            'address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Le nom du fournisseur est obligatoire.',
            'name.unique' => 'Ce nom de fournisseur existe déjà.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->fill($request->all());
            $supplier->active = $request->has('active') ? true : false;
            $supplier->save();

            return redirect()->route('suppliers.show', $supplier->id)
                ->with('success', 'Fournisseur mis à jour avec succès!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la mise à jour du fournisseur.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            
            // Check if supplier has products
            if ($supplier->products()->count() > 0) {
                return redirect()->route('suppliers.index')
                    ->withErrors(['error' => 'Impossible de supprimer ce fournisseur car il a des produits associés.']);
            }
            
            $supplierName = $supplier->name;
            $supplier->delete();

            return redirect()->route('suppliers.index')
                ->with('success', "Fournisseur '{$supplierName}' supprimé avec succès!");
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')
                ->withErrors(['error' => 'Erreur lors de la suppression du fournisseur.']);
        }
    }

    /**
     * Search suppliers via AJAX
     */
    public function search(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Supplier::query();
        
        if ($request->filled('term')) {
            $term = trim($request->term);
            $query->where(function($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                  ->orWhere('contact_person', 'LIKE', "%{$term}%")
                  ->orWhere('email', 'LIKE', "%{$term}%")
                  ->orWhere('phone_number', 'LIKE', "%{$term}%");
            });
        }

        $suppliers = $query->select(['id', 'name', 'contact_person', 'email', 'phone_number', 'active'])
                          ->withCount('products')
                          ->orderBy('name', 'asc')
                          ->limit(20)
                          ->get();

        return response()->json($suppliers);
    }
}