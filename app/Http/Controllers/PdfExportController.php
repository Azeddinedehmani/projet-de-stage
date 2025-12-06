<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Client;
use App\Models\Prescription;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PdfExportController extends Controller
{
    public function exportSalesReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));
        $groupBy = $request->get('group_by', 'day');

        // Get sales data
        $totalSales = Sale::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount');
        $totalTransactions = Sale::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        // Top products
        $topProducts = Product::select('products.*')
            ->selectRaw('SUM(sale_items.quantity) as total_quantity')
            ->selectRaw('SUM(sale_items.quantity * sale_items.unit_price) as total_revenue')
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.created_at', [$dateFrom, $dateTo])
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        // Sales by user
        $salesByUser = User::select('users.name')
            ->selectRaw('SUM(sales.total_amount) as total_sales')
            ->selectRaw('COUNT(sales.id) as total_transactions')
            ->join('sales', 'users.id', '=', 'sales.user_id')
            ->whereBetween('sales.created_at', [$dateFrom, $dateTo])
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_sales')
            ->get();

        // Sales by payment method
        $salesByPaymentMethod = Sale::select('payment_method')
            ->selectRaw('SUM(total_amount) as total')
            ->selectRaw('COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('payment_method')
            ->get();

        $data = compact(
            'dateFrom', 'dateTo', 'totalSales', 'totalTransactions', 
            'averageTransaction', 'topProducts', 'salesByUser', 'salesByPaymentMethod'
        );

        $pdf = PDF::loadView('rapports.pdf.sales', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'rapport_ventes_' . Carbon::parse($dateFrom)->format('Y-m-d') . '_' . Carbon::parse($dateTo)->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportInventoryReport()
    {
        $totalProducts = Product::count();
        $totalStockValue = Product::sum(DB::raw('stock_quantity * purchase_price'));
        $averageStockLevel = Product::avg('stock_quantity');

        $lowStockProducts = Product::whereRaw('stock_quantity <= stock_threshold')
            ->with(['category', 'supplier'])
            ->orderBy('stock_quantity')
            ->get();

        $expiringProducts = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->with(['category'])
            ->orderBy('expiry_date')
            ->get();

        $categoriesValue = Product::select('categories.name as category_name')
            ->selectRaw('SUM(products.stock_quantity) as total_quantity')
            ->selectRaw('SUM(products.stock_quantity * products.purchase_price) as total_value')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_value')
            ->get();

        $data = compact(
            'totalProducts', 'totalStockValue', 'averageStockLevel',
            'lowStockProducts', 'expiringProducts', 'categoriesValue'
        );

        $pdf = PDF::loadView('rapports.pdf.inventory', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('rapport_inventaire_' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportClientsReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $totalClients = Client::count();
        $activeClients = Client::where('is_active', true)->count();
        $clientsWithPurchases = Client::whereHas('sales', function($query) use ($dateFrom, $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        })->count();
        $clientsWithAllergies = Client::whereNotNull('allergies')->where('allergies', '!=', '')->count();

        $topClients = Client::select('clients.*')
            ->selectRaw('COUNT(sales.id) as total_purchases')
            ->selectRaw('SUM(sales.total_amount) as total_spent')
            ->leftJoin('sales', 'clients.id', '=', 'sales.client_id')
            ->whereBetween('sales.created_at', [$dateFrom, $dateTo])
            ->groupBy('clients.id')
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();

        $data = compact(
            'dateFrom', 'dateTo', 'totalClients', 'activeClients',
            'clientsWithPurchases', 'clientsWithAllergies', 'topClients'
        );

        $pdf = PDF::loadView('rapports.pdf.clients', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'rapport_clients_' . Carbon::parse($dateFrom)->format('Y-m-d') . '_' . Carbon::parse($dateTo)->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportPrescriptionsReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $totalPrescriptions = Prescription::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $completedPrescriptions = Prescription::where('status', 'completed')
            ->whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $completionRate = $totalPrescriptions > 0 ? ($completedPrescriptions / $totalPrescriptions) * 100 : 0;

        $prescriptionsByStatus = Prescription::select('status')
            ->selectRaw('COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->get();

        $topPrescribedMedications = Product::select('products.name')
            ->selectRaw('SUM(prescription_items.quantity_prescribed) as total_prescribed')
            ->selectRaw('SUM(prescription_items.quantity_delivered) as total_delivered')
            ->selectRaw('COUNT(DISTINCT prescription_items.prescription_id) as prescription_count')
            ->join('prescription_items', 'products.id', '=', 'prescription_items.product_id')
            ->join('prescriptions', 'prescription_items.prescription_id', '=', 'prescriptions.id')
            ->whereBetween('prescriptions.created_at', [$dateFrom, $dateTo])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_prescribed')
            ->limit(15)
            ->get();

        $expiredPrescriptions = Prescription::where('expiry_date', '<', now())
            ->with('client')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->orderByDesc('expiry_date')
            ->get();

        $data = compact(
            'dateFrom', 'dateTo', 'totalPrescriptions', 'completedPrescriptions',
            'completionRate', 'prescriptionsByStatus', 'topPrescribedMedications',
            'expiredPrescriptions'
        );

        $pdf = PDF::loadView('rapports.pdf.prescriptions', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'rapport_ordonnances_' . Carbon::parse($dateFrom)->format('Y-m-d') . '_' . Carbon::parse($dateTo)->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportFinancialReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $revenue = Sale::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount');
        $expenses = Purchase::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount');
        $profit = $revenue - $expenses;

        $productMargins = Product::select('products.name')
            ->selectRaw('SUM(sale_items.quantity) as total_sold')
            ->selectRaw('SUM(sale_items.quantity * sale_items.unit_price) as total_revenue')
            ->selectRaw('SUM(sale_items.quantity * products.purchase_price) as total_cost')
            ->selectRaw('SUM(sale_items.quantity * (sale_items.unit_price - products.purchase_price)) as total_margin')
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.created_at', [$dateFrom, $dateTo])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_margin')
            ->limit(20)
            ->get();

        $data = compact(
            'dateFrom', 'dateTo', 'revenue', 'expenses', 'profit', 'productMargins'
        );

        $pdf = PDF::loadView('rapports.pdf.financial', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'rapport_financier_' . Carbon::parse($dateFrom)->format('Y-m-d') . '_' . Carbon::parse($dateTo)->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportSuppliersReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $totalSuppliers = Supplier::count();
        $activeSuppliers = Supplier::where('active', true)->count();
        $suppliersWithProducts = Supplier::has('products')->count();
        $suppliersWithoutProducts = $totalSuppliers - $suppliersWithProducts;

        $suppliersByStockValue = Supplier::select('suppliers.*')
            ->selectRaw('COUNT(products.id) as products_count')
            ->selectRaw('SUM(products.stock_quantity) as total_stock_quantity')
            ->selectRaw('SUM(products.stock_quantity * products.purchase_price) as total_stock_value')
            ->leftJoin('products', 'suppliers.id', '=', 'products.supplier_id')
            ->groupBy('suppliers.id')
            ->orderByDesc('total_stock_value')
            ->get();

        $purchasesBySupplier = Supplier::select('suppliers.name', 'suppliers.contact_person')
            ->selectRaw('COUNT(purchases.id) as orders_count')
            ->selectRaw('SUM(purchases.total_amount) as total_amount')
            ->selectRaw('AVG(purchases.total_amount) as average_amount')
            ->join('purchases', 'suppliers.id', '=', 'purchases.supplier_id')
            ->whereBetween('purchases.created_at', [$dateFrom, $dateTo])
            ->groupBy('suppliers.id', 'suppliers.name', 'suppliers.contact_person')
            ->orderByDesc('total_amount')
            ->get();

        $data = compact(
            'dateFrom', 'dateTo', 'totalSuppliers', 'activeSuppliers',
            'suppliersWithProducts', 'suppliersWithoutProducts',
            'suppliersByStockValue', 'purchasesBySupplier'
        );

        $pdf = PDF::loadView('rapports.pdf.suppliers', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'rapport_fournisseurs_' . Carbon::parse($dateFrom)->format('Y-m-d') . '_' . Carbon::parse($dateTo)->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportUsersReport(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $adminUsers = User::where('role', 'responsable')->count();
        $pharmacistUsers = User::where('role', 'pharmacien')->count();
        
        // CORRECTION: Gestion robuste de la colonne de changement de mot de passe
        if (Schema::hasColumn('users', 'force_password_change')) {
            $usersNeedingPasswordChange = User::where('force_password_change', true)->count();
        } elseif (Schema::hasColumn('users', 'must_change_password')) {
            $usersNeedingPasswordChange = User::where('must_change_password', true)->count();
        } else {
            $usersNeedingPasswordChange = 0;
        }

        $topUsersByActivity = User::select('users.*')
            ->selectRaw('COUNT(activity_logs.id) as activity_count')
            ->selectRaw('COUNT(DISTINCT DATE(activity_logs.created_at)) as active_days')
            ->leftJoin('activity_logs', 'users.id', '=', 'activity_logs.user_id')
            ->whereBetween('activity_logs.created_at', [$dateFrom, $dateTo])
            ->groupBy('users.id')
            ->orderByDesc('activity_count')
            ->get();

        $salesPerformance = User::select('users.*')
            ->selectRaw('COUNT(sales.id) as sales_count')
            ->selectRaw('SUM(sales.total_amount) as total_sales_amount')
            ->selectRaw('AVG(sales.total_amount) as average_sale_amount')
            ->leftJoin('sales', 'users.id', '=', 'sales.user_id')
            ->whereBetween('sales.created_at', [$dateFrom, $dateTo])
            ->groupBy('users.id')
            ->orderByDesc('total_sales_amount')
            ->get();

        $data = compact(
            'dateFrom', 'dateTo', 'totalUsers', 'activeUsers', 'adminUsers',
            'pharmacistUsers', 'usersNeedingPasswordChange', 'topUsersByActivity',
            'salesPerformance'
        );

        $pdf = PDF::loadView('rapports.pdf.users', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'rapport_utilisateurs_' . Carbon::parse($dateFrom)->format('Y-m-d') . '_' . Carbon::parse($dateTo)->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}