@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
   <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-boxes text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport d'inventaire</h2>
                <small class="text-muted">Analyse complète du stock et des produits</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.inventory.pdf') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
            </a>
        </div>
    </div>
</div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total produits</h6>
                            <h4 class="mb-0">{{ $totalProducts }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Valeur du stock</h6>
                            <h4 class="mb-0">{{ number_format($totalStockValue, 0) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-euro-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Stock moyen</h6>
                            <h4 class="mb-0">{{ number_format($averageStockLevel, 1) }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Produits avec stock faible -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Produits avec stock faible ({{ $lowStockProducts->count() }})
                        </span>
                        @if($lowStockProducts->count() > 0)
                            <span class="badge bg-dark">Action requise</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($lowStockProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Catégorie</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Stock actuel</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Seuil</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Criticité</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                        <tr class="border-0 {{ $product->stock_quantity == 0 ? 'table-danger' : 'table-warning' }}">
                                            <td class="border-0">
                                                <div>
                                                    <strong>{{ $product->name }}</strong>
                                                    @if($product->dosage)
                                                        <br><small class="text-muted">{{ $product->dosage }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-0">{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                            <td class="border-0">{{ $product->supplier ? $product->supplier->name : 'N/A' }}</td>
                                            <td class="text-center border-0">
                                                @if($product->stock_quantity == 0)
                                                    <span class="badge bg-danger rounded-pill">0</span>
                                                @else
                                                    <span class="badge bg-warning text-dark rounded-pill">{{ $product->stock_quantity }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-secondary rounded-pill">{{ $product->stock_threshold }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                @php
                                                    $criticityLevel = $product->stock_quantity == 0 ? 'URGENT' : 
                                                                    ($product->stock_quantity <= $product->stock_threshold * 0.5 ? 'ÉLEVÉ' : 'MOYEN');
                                                    $criticityClass = $product->stock_quantity == 0 ? 'bg-danger' : 
                                                                    ($product->stock_quantity <= $product->stock_threshold * 0.5 ? 'bg-warning text-dark' : 'bg-info');
                                                @endphp
                                                <span class="badge {{ $criticityClass }} rounded-pill">{{ $criticityLevel }}</span>
                                            </td>
                                            <td class="border-0">
                                                <div class="btn-group">
                                                    <a href="{{ route('inventory.show', $product->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; border-radius: 8px;">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(Auth::user()->isAdmin())
                                                        <a href="{{ route('purchases.create', ['supplier_id' => $product->supplier_id]) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 8px; margin-left: 3px;">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <h5 class="text-success mb-2">Excellent !</h5>
                            <p class="text-muted">Tous les produits ont un niveau de stock suffisant.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Produits qui expirent bientôt -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-calendar-times me-2"></i>
                            Produits expirant dans 30 jours ({{ $expiringProducts->count() }})
                        </span>
                        @if($expiringProducts->count() > 0)
                            <span class="badge bg-warning text-dark">À surveiller</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($expiringProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Catégorie</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Stock</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Date d'expiration</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Jours restants</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Valeur</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringProducts as $product)
                                        @php
                                            $daysLeft = $product->expiry_date->diffInDays(now());
                                            $urgencyClass = $daysLeft <= 7 ? 'table-danger' : ($daysLeft <= 15 ? 'table-warning' : '');
                                        @endphp
                                        <tr class="border-0 {{ $urgencyClass }}">
                                            <td class="border-0">
                                                <div>
                                                    <strong>{{ $product->name }}</strong>
                                                    @if($product->dosage)
                                                        <br><small class="text-muted">{{ $product->dosage }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-0">{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-primary rounded-pill">{{ $product->stock_quantity }}</span>
                                            </td>
                                            <td class="border-0">{{ $product->expiry_date->format('d/m/Y') }}</td>
                                            <td class="text-center border-0">
                                                @if($daysLeft <= 7)
                                                    <span class="badge bg-danger rounded-pill">{{ $daysLeft }} jour(s)</span>
                                                @elseif($daysLeft <= 15)
                                                    <span class="badge bg-warning text-dark rounded-pill">{{ $daysLeft }} jours</span>
                                                @else
                                                    <span class="badge bg-info rounded-pill">{{ $daysLeft }} jours</span>
                                                @endif
                                            </td>
                                            <td class="text-end border-0">
                                                {{ number_format($product->stock_quantity * $product->purchase_price, 2) }} €
                                            </td>
                                            <td class="border-0">
                                                <a href="{{ route('inventory.show', $product->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; border-radius: 8px;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <h5 class="text-success mb-2">Parfait !</h5>
                            <p class="text-muted">Aucun produit n'expire dans les 30 prochains jours.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Valeur par catégorie -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Valeur par catégorie
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="categoriesChart" height="300"></canvas>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('inventory.index', ['stock_status' => 'low']) }}" class="btn text-dark fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Voir tous les stocks faibles
                        </a>
                        
                        <a href="{{ route('inventory.index', ['stock_status' => 'out']) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-times-circle me-2"></i>
                            Voir les ruptures de stock
                        </a>
                        
                        <a href="{{ route('inventory.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-plus me-2"></i>
                            Ajouter un produit
                        </a>
                        
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('purchases.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Nouvelle commande
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Résumé par catégorie -->
    @if($categoriesValue->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2" style="color: #336699;"></i>
                        Résumé par catégorie
                    </h5>
                </div>
               <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Catégorie</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité totale</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Valeur totale</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">% du stock total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoriesValue as $category)
                                    <tr class="border-0">
                                        <td class="border-0"><strong>{{ $category->category_name }}</strong></td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-primary rounded-pill">{{ number_format($category->total_quantity) }}</span>
                                        </td>
                                        <td class="text-end border-0">{{ number_format($category->total_value, 2) }} €</td>
                                        <td class="text-end border-0">
                                            @php
                                                $percentage = $totalStockValue > 0 ? ($category->total_value / $totalStockValue) * 100 : 0;
                                            @endphp
                                            <span class="badge bg-info rounded-pill">{{ number_format($percentage, 1) }}%</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-bold">Total</th>
                                    <th class="text-center border-0 fw-bold">{{ number_format($categoriesValue->sum('total_quantity')) }}</th>
                                    <th class="text-end border-0 fw-bold">{{ number_format($totalStockValue, 2) }} €</th>
                                    <th class="text-end border-0 fw-bold">100%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
    
    .form-control:focus,
    .form-select:focus {
        border-color: #336699;
        box-shadow: 0 0 0 0.2rem rgba(51, 102, 153, 0.25);
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
    
    .form-control, .form-select {
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .form-control:hover, .form-select:hover {
        border-color: #336699;
        box-shadow: 0 2px 8px rgba(51, 102, 153, 0.1);
    }
    
    .form-label {
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    /* Amélioration des badges */
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    /* Animation pour les cartes de criticité */
    .table-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(200, 35, 51, 0.1) 100%) !important;
        animation: pulse-danger 2s infinite;
    }
    
    .table-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(253, 126, 20, 0.1) 100%) !important;
    }
    
    @keyframes pulse-danger {
        0% { background-color: rgba(220, 53, 69, 0.1); }
        50% { background-color: rgba(220, 53, 69, 0.2); }
        100% { background-color: rgba(220, 53, 69, 0.1); }
    }
    
    /* Amélioration des boutons d'action */
    .btn-group .btn {
        margin-left: 3px;
    }
    
    .btn-group .btn:first-child {
        margin-left: 0;
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-group .btn {
            margin-left: 0;
            width: 100%;
        }
    }
    
    /* Amélioration de la lisibilité des tableaux */
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        vertical-align: middle;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    /* Animation pour les graphiques */
    #categoriesChart {
        transition: all 0.3s ease;
    }
    
    /* Effet glassmorphism pour les cartes */
    .card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique en secteurs pour les catégories
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const categoriesData = @json($categoriesValue);
    
    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
        '#FF9F40', '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'
    ];
    
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: categoriesData.map(item => item.category_name),
            datasets: [{
                data: categoriesData.map(item => parseFloat(item.total_value)),
                backgroundColor: colors.slice(0, categoriesData.length),
                borderWidth: 3,
                borderColor: '#fff',
                hoverBorderWidth: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            family: 'Rubik',
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': ' + value.toLocaleString('fr-FR', {
                                style: 'currency',
                                currency: 'EUR'
                            }) + ' (' + percentage + '%)';
                        }
                    },
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#2c3e50',
                    bodyColor: '#2c3e50',
                    borderColor: '#336699',
                    borderWidth: 2,
                    cornerRadius: 8,
                    displayColors: true,
                    titleFont: {
                        family: 'Poppins',
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Rubik'
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            hover: {
                animationDuration: 300
            }
        }
    });
    
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
    
    // Animation pour les badges critiques
    const criticalBadges = document.querySelectorAll('.badge.bg-danger');
    criticalBadges.forEach(badge => {
        if (badge.textContent.includes('URGENT') || badge.textContent === '0') {
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
    
    // Gestion du hover sur les lignes de tableau critiques
    const criticalRows = document.querySelectorAll('.table-danger, .table-warning');
    criticalRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Effet de compteur pour les statistiques
    const statNumbers = document.querySelectorAll('.card h4');
    statNumbers.forEach(number => {
        const finalValue = parseInt(number.textContent.replace(/[^\d]/g, ''));
        if (finalValue && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 30;
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    current = finalValue;
                    clearInterval(timer);
                }
                number.textContent = Math.floor(current).toLocaleString() + (number.textContent.includes('€') ? ' €' : '');
            }, 50);
        }
    });
    
    // Tooltip pour les boutons d'action
    const actionButtons = document.querySelectorAll('.btn-group .btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.1)';
            this.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.2)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>
@endsection