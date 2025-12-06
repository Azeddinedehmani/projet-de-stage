@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Message de bienvenue -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert border-0 text-white" style="background: linear-gradient(135deg, #336699 0%, #4a90e2 100%); border-radius: 15px; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <h4 class="alert-heading fw-bold">
                    <i class="fas fa-user-circle me-2"></i>Bienvenue, {{ Auth::user()->name }}!
                </h4>
                <p class="mb-0 opacity-90">Vous êtes connecté en tant que Responsable. Vous avez un accès complet à toutes les fonctionnalités du système.</p>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques principales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Ventes du jour</h6>
                        <h3 class="mb-0" id="sales-today">{{ number_format($stats['sales_today'], 2) }} €</h3>
                        <small class="opacity-75">{{ $stats['sales_count_today'] }} vente(s)</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Clients aujourd'hui</h6>
                        <h3 class="mb-0">{{ $stats['clients_today'] }}</h3>
                        <small class="opacity-75">{{ $stats['total_clients'] }} au total</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Stock critique</h6>
                        <h3 class="mb-0">{{ $stats['products_low_stock'] }}</h3>
                        <small class="opacity-75">Produit(s) à commander</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: #212529;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Expiration proche</h6>
                        <h3 class="mb-0">{{ $stats['products_expiring'] }}</h3>
                        <small class="opacity-75">Dans les 30 jours</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section principale avec graphique et alertes -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                        Ventes des 7 derniers jours
                        <!-- Indicateur de mise à jour -->
                        <span id="chart-update-indicator" class="badge bg-success ms-2" style="display: none;">
                            <i class="fas fa-sync-alt fa-spin"></i> Mise à jour...
                        </span>
                    </h5>
                    <div class="d-flex align-items-center">
                        <small id="chart-total" class="text-muted fw-medium me-3">{{ number_format($salesChart->sum('total'), 2) }} € total</small>
                        <small id="last-update" class="text-muted" style="font-size: 0.75rem;">
                            Dernière mise à jour : {{ now()->format('H:i:s') }}
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="120"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #ffc107;"></i>
                        Alertes Stock
                    </h5>
                    <a href="{{ route('inventory.index', ['stock_status' => 'low']) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px;">
                        Voir tout
                    </a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStockProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                                <div>
                                    <h6 class="mb-0 fw-medium">{{ $product->name }}</h6>
                                    <small class="{{ $product->stock_quantity <= 0 ? 'text-danger' : 'text-warning' }} fw-medium">
                                        Stock: {{ $product->stock_quantity }} 
                                        {{ $product->stock_quantity <= 1 ? 'unité' : 'unités' }}
                                    </small>
                                </div>
                                <span class="badge {{ $product->stock_quantity <= 0 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill">
                                    {{ $product->stock_quantity <= 0 ? 'Rupture' : 'Critique' }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-success border-0 py-4">
                                <i class="fas fa-check-circle me-2"></i>
                                Aucune alerte stock
                            </li>
                        @endforelse
                    </ul>
                </div>
                @if($lowStockProducts->count() > 0)
                    <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                        <a href="{{ route('inventory.index', ['stock_status' => 'low']) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px;">
                            Voir toutes les alertes ({{ $stats['products_low_stock'] }})
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Section ventes récentes et produits à commander -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2" style="color: #336699;"></i>
                        Ventes récentes
                    </h5>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px;">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Client</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Produits</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Montant</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSales as $sale)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            {{ $sale->client ? $sale->client->full_name : 'Client anonyme' }}
                                        </td>
                                        <td class="border-0">
                                            @if($sale->saleItems->count() > 0)
                                                {{ $sale->saleItems->first()->product->name ?? 'Produit supprimé' }}
                                                @if($sale->saleItems->count() > 1)
                                                    <small class="text-muted">
                                                        +{{ $sale->saleItems->count() - 1 }} autre(s)
                                                    </small>
                                                @endif
                                            @else
                                                <span class="text-muted">Aucun produit</span>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            <strong style="color: #28a745;">{{ number_format($sale->total_amount, 2) }} €</strong>
                                            @if($sale->has_prescription)
                                                <br><small class="text-info">
                                                    <i class="fas fa-file-prescription"></i> Ordonnance
                                                </small>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            <small class="fw-medium">
                                                @if($sale->sale_date->isToday())
                                                    {{ $sale->sale_date->format('H:i') }}
                                                @elseif($sale->sale_date->isYesterday())
                                                    Hier
                                                @else
                                                    {{ $sale->sale_date->format('d/m') }}
                                                @endif
                                            </small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3 border-0">
                                            Aucune vente récente
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($recentSales->count() > 0)
                    <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px;">Voir toutes les ventes</a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-truck me-2" style="color: #336699;"></i>
                        Produits à commander
                    </h5>
                    <a href="{{ route('purchases.create') }}" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px;">
                        <i class="fas fa-plus"></i> Nouvelle commande
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Stock actuel</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productsToOrder as $product)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <strong>{{ $product->name }}</strong>
                                            @if($product->dosage)
                                                <br><small class="text-muted">{{ $product->dosage }}</small>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            {{ $product->supplier ? $product->supplier->name : 'Aucun fournisseur' }}
                                        </td>
                                        <td class="border-0">
                                            <span class="badge {{ $product->stock_quantity <= 0 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill">
                                                {{ $product->stock_quantity }} unités
                                            </span>
                                            <br><small class="text-muted">Seuil: {{ $product->stock_threshold }}</small>
                                        </td>
                                        <td class="border-0">
                                            @if($product->supplier)
                                                <a href="{{ route('purchases.create', ['supplier_id' => $product->supplier->id]) }}" 
                                                   class="btn btn-sm text-white" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 8px;">
                                                    Commander
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary" disabled style="border-radius: 8px;">
                                                    Pas de fournisseur
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-success py-3 border-0">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Tous les stocks sont corrects
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($productsToOrder->count() > 0)
                    <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                        <a href="{{ route('inventory.index', ['stock_status' => 'low']) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px;">
                            Voir tous les produits à commander
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Résumé de la journée -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2" style="color: #336699;"></i>
                        Résumé de la journée
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-2">
                            <div class="p-3 rounded" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <h4 class="fw-bold" style="color: #336699;">{{ $stats['prescriptions_pending'] }}</h4>
                                <small class="text-muted fw-medium">Ordonnances en attente</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 rounded" style="background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);">
                                <h4 class="text-warning fw-bold">{{ $stats['purchases_pending'] }}</h4>
                                <small class="text-muted fw-medium">Commandes en attente</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 rounded" style="background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);">
                                <h4 class="text-info fw-bold">{{ $stats['total_users'] }}</h4>
                                <small class="text-muted fw-medium">Utilisateurs total</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 rounded" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%);">
                                <h4 class="text-success fw-bold">{{ $stats['active_users'] }}</h4>
                                <small class="text-muted fw-medium">Utilisateurs actifs</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 rounded" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);">
                                <h4 class="text-secondary fw-bold">{{ $userActivityChart->sum('count') }}</h4>
                                <small class="text-muted fw-medium">Activités du mois</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 rounded" style="background: linear-gradient(135deg, #f5f5f5 0%, #e9ecef 100%);">
                                <h4 class="text-dark fw-bold">{{ $stats['products_total'] ?? \App\Models\Product::count() }}</h4>
                                <small class="text-muted fw-medium">Produits en inventaire</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
        font-family: 'Rubik', sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(51, 102, 153, 0.05);
        transform: scale(1.002);
        transition: all 0.2s ease;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .card {
        transition: transform 0.3s ease;
        border: none !important;
    }
    
    .text-primary {
        color: #336699 !important;
    }
    
    .bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
    
    .fw-semibold {
        font-weight: 600;
    }
    
    .fw-bold {
        font-weight: 700;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    /* Effet glassmorphism pour les cartes */
    .card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Amélioration des badges */
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    /* Animation pour les alertes critiques */
    .badge.bg-danger {
        animation: pulse-danger 2s infinite;
    }
    
    @keyframes pulse-danger {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    /* Amélioration des list-group-item */
    .list-group-item {
        background: transparent !important;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background: linear-gradient(135deg, rgba(51, 102, 153, 0.05) 0%, rgba(74, 144, 226, 0.05) 100%) !important;
        transform: translateX(5px);
    }
    
    .list-group-item:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* Animation de mise à jour */
    .update-indicator {
        animation: pulse-update 1.5s infinite;
    }
    
    @keyframes pulse-update {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .row .col-md-2 {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// *** GRAPHIQUE AVEC MISE À JOUR AUTOMATIQUE ***
let salesChart;
let chartUpdateInterval;

// Initialisation du graphique avec les données du backend
function initializeSalesChart() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChart->pluck('formatted_date')),
            datasets: [{
                label: 'Ventes (€)',
                data: @json($salesChart->pluck('total')),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#2c3e50',
                    bodyColor: '#2c3e50',
                    borderColor: '#336699',
                    borderWidth: 2,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                        return 'Ventes: ' + new Intl.NumberFormat('fr-FR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(context.parsed.y) + ' €';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' €';
                        },
                        font: {
                            family: 'Rubik'
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            family: 'Rubik'
                        }
                    }
                }
            },
            elements: {
                point: {
                    radius: 5,
                    hoverRadius: 8
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
}

// *** FONCTION DE MISE À JOUR AUTOMATIQUE DU GRAPHIQUE ***
function refreshSalesChart() {
    // Afficher l'indicateur de mise à jour
    const updateIndicator = document.getElementById('chart-update-indicator');
    if (updateIndicator) {
        updateIndicator.style.display = 'inline-block';
    }

    // Faire la requête AJAX pour obtenir les nouvelles données
    fetch('{{ route("admin.refresh-sales-chart") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour les données du graphique
        salesChart.data.labels = data.labels;
        salesChart.data.datasets[0].data = data.data;
        salesChart.update();
        
        // Mettre à jour le total affiché
        const totalElement = document.getElementById('chart-total');
        if (totalElement) {
            totalElement.textContent = new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(data.total) + ' € total';
        }
        
        // Mettre à jour l'heure de dernière mise à jour
        const lastUpdateElement = document.getElementById('last-update');
        if (lastUpdateElement) {
            lastUpdateElement.textContent = 'Dernière mise à jour : ' + data.last_updated;
        }
        
        // Masquer l'indicateur de mise à jour
        if (updateIndicator) {
            setTimeout(() => {
                updateIndicator.style.display = 'none';
            }, 1000);
        }
        
        console.log('Graphique des ventes mis à jour automatiquement à', data.last_updated);
    })
    .catch(error => {
        console.error('Erreur lors de la mise à jour du graphique:', error);
        
        // Masquer l'indicateur de mise à jour en cas d'erreur
        if (updateIndicator) {
            updateIndicator.style.display = 'none';
        }
    });
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le graphique
    initializeSalesChart();
    
    // *** MISE À JOUR AUTOMATIQUE TOUTES LES 5 MINUTES ***
    chartUpdateInterval = setInterval(refreshSalesChart, 300000); // 300000ms = 5 minutes
    
    // Animation d'entrée pour les cartes
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Effet de compteur pour les statistiques
    const statNumbers = document.querySelectorAll('.card h3, .card h4');
    statNumbers.forEach(number => {
        const text = number.textContent;
        const finalValue = parseFloat(text.replace(/[^\d.,]/g, '').replace(',', '.'));
        
        if (finalValue && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 30;
            const hasEuro = text.includes('€');
            const hasDecimals = text.includes(',') || text.includes('.');
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    current = finalValue;
                    clearInterval(timer);
                }
                
                if (hasDecimals && hasEuro) {
                    number.textContent = current.toLocaleString('fr-FR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' €';
                } else if (hasEuro) {
                    number.textContent = Math.floor(current).toLocaleString('fr-FR') + ' €';
                } else {
                    number.textContent = Math.floor(current);
                }
            }, 50);
        }
    });
    
    // Animation pour les badges critiques
    const criticalBadges = document.querySelectorAll('.badge.bg-danger, .badge.bg-warning');
    criticalBadges.forEach(badge => {
        if (badge.textContent.includes('Rupture') || badge.textContent.includes('Critique')) {
            badge.style.animation = 'pulse 2s infinite';
        }
    });
    
    // Ajout de l'animation CSS pour le pulse
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
    `;
    document.head.appendChild(style);
    
    // Interaction avec les lignes de tableau
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.borderLeft = '4px solid #336699';
            this.style.paddingLeft = '1rem';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.borderLeft = 'none';
            this.style.paddingLeft = '0.75rem';
        });
    });
    
    // Animation pour les alertes de stock
    const stockAlerts = document.querySelectorAll('.list-group-item');
    stockAlerts.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.4s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 500 + (index * 100));
    });
    
    // Effet de pulsation pour les cartes avec des valeurs critiques
    const warningCard = document.querySelector('.card[style*="ffc107"]');
    const dangerCard = document.querySelector('.card[style*="dc3545"]');
    
    if (warningCard) {
        const stockValue = parseInt(warningCard.querySelector('h3').textContent);
        if (stockValue > 0) {
            warningCard.style.animation = 'glow-warning 3s infinite';
        }
    }
    
    if (dangerCard) {
        const expiringValue = parseInt(dangerCard.querySelector('h3').textContent);
        if (expiringValue > 0) {
            dangerCard.style.animation = 'glow-danger 3s infinite';
        }
    }
    
    // Ajout des animations de lueur
    const glowStyle = document.createElement('style');
    glowStyle.textContent = `
        @keyframes glow-warning {
            0%, 100% { box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3); }
            50% { box-shadow: 0 12px 35px rgba(255, 193, 7, 0.6); }
        }
        
        @keyframes glow-danger {
            0%, 100% { box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3); }
            50% { box-shadow: 0 12px 35px rgba(220, 53, 69, 0.6); }
        }
    `;
    document.head.appendChild(glowStyle);
    
    // Animation des éléments du résumé de la journée
    const summaryStats = document.querySelectorAll('.row.text-center .col-md-2');
    summaryStats.forEach((stat, index) => {
        stat.style.opacity = '0';
        stat.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            stat.style.transition = 'all 0.5s ease';
            stat.style.opacity = '1';
            stat.style.transform = 'scale(1)';
        }, 1000 + (index * 150));
    });
    
    // Interaction avec les boutons d'action
    const actionButtons = document.querySelectorAll('.btn');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.2)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-1px) scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';
        });
    });
    
    // Animation du graphique au chargement
    setTimeout(() => {
        salesChart.update('show');
    }, 1000);
    
    // Gestion responsive pour les animations
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    
    function handleResponsive(e) {
        if (e.matches) {
            // Désactiver certaines animations sur mobile
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.style.transition = 'none';
            });
        } else {
            // Réactiver les animations sur desktop
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.style.transition = 'all 0.3s ease';
            });
        }
    }
    
    mediaQuery.addListener(handleResponsive);
    handleResponsive(mediaQuery);
    
    // Animation d'arrivée pour l'alerte de bienvenue
    const welcomeAlert = document.querySelector('.alert');
    if (welcomeAlert) {
        welcomeAlert.style.opacity = '0';
        welcomeAlert.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            welcomeAlert.style.transition = 'all 0.8s ease';
            welcomeAlert.style.opacity = '1';
            welcomeAlert.style.transform = 'translateY(0)';
        }, 200);
    }
    
    // Effet de parallax léger pour l'arrière-plan
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.1;
        
        document.body.style.backgroundPosition = `center ${parallax}px`;
    });
    
    // Interaction avec les icônes
    const icons = document.querySelectorAll('.fas');
    icons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2) rotate(5deg)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });
    
    // Console log pour vérification
    console.log('=== DASHBOARD AVEC MISE À JOUR AUTOMATIQUE ===');
    console.log('Graphique initialisé avec les données réelles du backend');
    console.log('Mise à jour automatique configurée toutes les 5 minutes');
    console.log('Route de mise à jour:', '{{ route("admin.refresh-sales-chart") }}');
    console.log('=============================================');
});

// *** BOUTON DE MISE À JOUR MANUELLE (optionnel) ***
function manualRefresh() {
    refreshSalesChart();
}

// Export des fonctions pour débogage
window.dashboardFunctions = {
    refreshChart: refreshSalesChart,
    chart: salesChart,
    manualRefresh: manualRefresh
};

// Nettoyage lors de la fermeture de la page
window.addEventListener('beforeunload', function() {
    if (chartUpdateInterval) {
        clearInterval(chartUpdateInterval);
    }
});

console.log('Dashboard avec mise à jour automatique chargé avec succès');
</script>
@endsection