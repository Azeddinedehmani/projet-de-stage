<?php
// resources/views/pharmacist/dashboard.blade.php - Sans section alertes stock
?>
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
                <p class="mb-0 opacity-90">Vous êtes connecté en tant que Pharmacien. Vous avez accès aux fonctionnalités de vente et de gestion des clients.</p>
            </div>
        </div>
    </div>

@php
    use App\Models\Sale;
    use App\Models\Client;
    use App\Models\Product;
    use App\Models\Prescription;
    
    // Real data calculations
    $today = now();
    $salesToday = Sale::whereDate('sale_date', $today)->sum('total_amount') ?? 0;
    $salesCountToday = Sale::whereDate('sale_date', $today)->count();
    $clientsToday = Sale::whereDate('sale_date', $today)->distinct('client_id')->count('client_id');
    $prescriptionsToday = Prescription::whereDate('created_at', $today)->count();
    
    // Recent sales for table - FIXED: Only load sales with existing products
    $recentSales = Sale::with(['client', 'user', 'saleItems' => function($query) {
                        $query->whereHas('product'); // Only load items that have existing products
                    }, 'saleItems.product'])
                      ->latest('sale_date')
                      ->take(5)
                      ->get();
    
    // Pending prescriptions
    $pendingPrescriptions = Prescription::where('status', 'pending')->count();
    $expiringPrescriptions = Prescription::where('expiry_date', '<=', now()->addDays(7))
                                        ->where('expiry_date', '>', now())
                                        ->count();
@endphp

    <!-- Cartes statistiques principales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Ventes du jour</h6>
                        <h3 class="mb-0">{{ number_format($salesToday, 2) }} €</h3>
                        <small class="opacity-75">{{ $salesCountToday }} vente(s)</small>
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
                        <h3 class="mb-0">{{ $clientsToday }}</h3>
                        <small class="opacity-75">Clients servis</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Ordonnances</h6>
                        <h3 class="mb-0">{{ $pendingPrescriptions }}</h3>
                        <small class="opacity-75">En attente</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-prescription fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title opacity-75">Ordonnances du jour</h6>
                        <h3 class="mb-0">{{ $prescriptionsToday }}</h3>
                        <small class="opacity-75">Traitées</small>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section accès rapide élargie -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-tachometer-alt me-2" style="color: #336699;"></i>
                        Accès rapide
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('sales.create') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-cash-register fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Nouvelle vente</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('prescriptions.create') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-file-prescription fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Nouvelle ordonnance</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('clients.create') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-user-plus fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Nouveau client</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('inventory.index') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-search fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Recherche produit</span>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('sales.index') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-chart-line fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Historique ventes</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('prescriptions.index') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-list-alt fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Gestion ordonnances</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('clients.index') }}" class="btn w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%); border: none; border-radius: 12px; transition: all 0.3s ease; min-height: 140px;">
                                <i class="fas fa-address-book fa-3x mb-3"></i>
                                <span class="fw-medium fs-6">Liste clients</span>
                            </a>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section ventes récentes -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2" style="color: #336699;"></i>
                        Ventes récentes
                    </h5>
                    <span class="badge bg-primary rounded-pill">{{ $salesCountToday }} aujourd'hui</span>
                </div>
                <div class="card-body p-0">
                    @if($recentSales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">N° Vente</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Client</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Produits</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Ordonnance</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Montant</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Date</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSales as $sale)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <span class="fw-bold text-primary">{{ $sale->sale_number }}</span>
                                        </td>
                                        <td class="border-0">
                                            @if($sale->client)
                                                {{ $sale->client->full_name }}
                                            @elseif($sale->client_display_name)
                                                {{ $sale->client_display_name }}
                                            @else
                                                <span class="text-muted">Client anonyme</span>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            @php
                                                // Filter out sale items with null products
                                                $validSaleItems = $sale->saleItems->filter(function($item) {
                                                    return $item->product !== null;
                                                });
                                                $totalItems = $sale->saleItems->count();
                                                $validItemsCount = $validSaleItems->count();
                                                $deletedItemsCount = $totalItems - $validItemsCount;
                                            @endphp
                                            
                                            <span class="badge bg-light text-dark rounded-pill">
                                                {{ $totalItems }} produit(s)
                                            </span>
                                            
                                            @if($validSaleItems->isNotEmpty())
                                                <br><small class="text-muted fw-medium">
                                                    {{ $validSaleItems->first()->product->name }}{{ $totalItems > 1 ? '...' : '' }}
                                                </small>
                                            @endif
                                            
                                            @if($deletedItemsCount > 0)
                                                <br><small class="text-danger fw-medium">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    {{ $deletedItemsCount }} produit(s) supprimé(s)
                                                </small>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            @if($sale->has_prescription)
                                                <span class="badge bg-success rounded-pill">Oui</span>
                                                @if($sale->prescription_number)
                                                    <br><small class="text-muted">{{ $sale->prescription_number }}</small>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary rounded-pill">Non</span>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            <span class="fw-bold text-success">{{ number_format($sale->total_amount, 2) }} €</span>
                                            <br><small class="text-muted fw-medium">{{ ucfirst($sale->payment_method_label) }}</small>
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
                                            <br><small class="text-muted">{{ $sale->sale_date->diffForHumans() }}</small>
                                        </td>
                                        <td class="border-0">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 8px 0 0 8px;" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 8px 8px 0;" title="Imprimer">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <p class="mb-0 fw-medium">Aucune vente récente</p>
                            <a href="{{ route('sales.create') }}" class="btn btn-sm mt-2 text-white" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px;">
                                <i class="fas fa-plus me-1"></i>Créer une vente
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                    <a href="{{ route('sales.index') }}" class="btn btn-sm text-white" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px;">Voir toutes les ventes</a>
                </div>
            </div>
        </div>
    </div>

    @if($expiringPrescriptions > 0)
    <!-- Alertes d'expiration des ordonnances uniquement -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert border-0" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 15px; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                <h5 class="alert-heading fw-bold" style="color: #856404;">
                    <i class="fas fa-exclamation-triangle me-2"></i>Alertes d'expiration
                </h5>
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-2 fw-medium" style="color: #856404;">
                            <strong>{{ $expiringPrescriptions }}</strong> ordonnance(s) expire(nt) dans les 7 prochains jours.
                        </p>
                        <a href="{{ route('prescriptions.index') }}" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 8px;">
                            <i class="fas fa-file-prescription me-1"></i>Voir les ordonnances
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Debug info for development (remove in production) --}}
    @if(config('app.debug'))
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-left: 4px solid #ffc107;">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 15px 15px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color: #856404;">
                        <i class="fas fa-bug me-2"></i>Informations de débogage (mode développement)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold" style="color: #336699;">Données chargées :</h6>
                            <ul class="list-unstyled">
                                <li><strong>Ventes récentes :</strong> {{ $recentSales->count() }}</li>
                                <li><strong>Ventes aujourd'hui :</strong> {{ $salesCountToday }}</li>
                                <li><strong>Montant total :</strong> {{ number_format($salesToday, 2) }} €</li>
                                <li><strong>Ordonnances en attente :</strong> {{ $pendingPrescriptions }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold" style="color: #336699;">Vérifications :</h6>
                            <ul class="list-unstyled">
                                @foreach($recentSales as $sale)
                                    @php
                                        $validItems = $sale->saleItems->filter(fn($item) => $item->product !== null)->count();
                                        $totalItems = $sale->saleItems->count();
                                    @endphp
                                    <li><small>Vente #{{ $sale->sale_number }}: {{ $validItems }}/{{ $totalItems }} produits valides</small></li>
                                @endforeach
                            </ul>
                        </div>
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
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .table-hover tbody tr:hover {
        background: linear-gradient(135deg, rgba(51, 102, 153, 0.05) 0%, rgba(74, 144, 226, 0.05) 100%);
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
    
    /* Animation pour les boutons d'accès rapide */
    .btn.py-4:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }
    
    /* Animation d'entrée */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .btn.py-4 {
            padding: 2rem 1rem !important;
            min-height: 120px !important;
        }
        
        h3 {
            font-size: 1.5rem;
        }
        
        .card-body .row .col-lg-3 {
            margin-bottom: 1rem;
        }
    }
    
@media (max-width: 576px) {
        .col-md-3 {
            margin-bottom: 1rem;
        }
        
        .btn.py-4 {
            min-height: 100px !important;
            padding: 1.5rem 0.5rem !important;
        }
        
        .btn.py-4 i {
            font-size: 1.5rem !important;
        }
        
        .btn.py-4 span {
            font-size: 0.85rem;
        }
    }
    
    /* Amélioration de l'apparence des tableaux */
    .table thead th {
        border-bottom: 2px solid rgba(51, 102, 153, 0.1);
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    
    .table tbody td {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    /* Styles pour les boutons d'action */
    .btn-group .btn {
        border: none;
        margin: 0 1px;
    }
    
    .btn-group .btn:first-child {
        margin-left: 0;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    /* Animation pour les icônes */
    .fas {
        transition: transform 0.3s ease;
    }
    
    .fas:hover {
        transform: scale(1.2) rotate(5deg);
    }
    
    /* Amélioration de l'alerte d'expiration */
    .alert {
        border: none;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Styles pour le mode debug */
    .card[style*="border-left"] {
        position: relative;
        overflow: hidden;
    }
    
    .card[style*="border-left"]::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        border-radius: 0 2px 2px 0;
    }
    
    /* Effet de survol pour les cartes principales */
    .row.mb-4 .card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    /* Amélioration des badges de statut */
    .badge.rounded-pill {
        padding: 0.5em 1em;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    /* Styles pour les montants */
    .text-success {
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(40, 167, 69, 0.3);
    }
    
    /* Animation de chargement pour les statistiques */
    .card h3, .card h4 {
        transition: all 0.3s ease;
    }
    
    /* Amélioration du contraste pour l'accessibilité */
    .opacity-75 {
        opacity: 0.85 !important;
    }
    
    .opacity-90 {
        opacity: 0.95 !important;
    }
    
    /* Styles pour les liens de navigation */
    .card-footer a {
        font-weight: 600;
        text-decoration: none;
        letter-spacing: 0.5px;
    }
    
    .card-footer a:hover {
        text-decoration: none;
        transform: translateY(-1px);
    }
    
    /* Amélioration de l'apparence des badges de comptage */
    .badge.bg-primary {
        background: linear-gradient(135deg, #336699 0%, #4a90e2 100%) !important;
        box-shadow: 0 2px 8px rgba(51, 102, 153, 0.3);
    }
    
    /* Animation pour les éléments interactifs */
    .clickable {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .clickable:hover {
        transform: scale(1.02);
    }
    
    /* Styles pour les états de chargement */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #336699;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    /* Animation de pulsation pour mise à jour */
    @keyframes pulse-update {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); color: #28a745; }
        100% { transform: scale(1); }
    }
    
    /* Animation d'attention */
    @keyframes attention {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Interaction avec les lignes de tableau
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.borderLeft = '4px solid #336699';
            this.style.paddingLeft = '1rem';
            this.style.transition = 'all 0.3s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.borderLeft = 'none';
            this.style.paddingLeft = '0.75rem';
        });
    });
    
    // Animation des boutons d'accès rapide
    const quickAccessButtons = document.querySelectorAll('.btn.py-4');
    quickAccessButtons.forEach((button, index) => {
        button.style.opacity = '0';
        button.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            button.style.transition = 'all 0.5s ease';
            button.style.opacity = '1';
            button.style.transform = 'scale(1)';
        }, 800 + (index * 150));
        
        // Effet de survol amélioré
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) translateY(-3px)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.3)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) translateY(0)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.2)';
        });
    });
    
    // Animation pour l'alerte de bienvenue
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
    
    // Interaction avec les boutons d'action
    const actionButtons = document.querySelectorAll('.btn:not(.py-4)');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.2)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Animation des badges de statut
    const statusBadges = document.querySelectorAll('.badge');
    statusBadges.forEach((badge, index) => {
        badge.style.opacity = '0';
        badge.style.transform = 'scale(0.5)';
        
        setTimeout(() => {
            badge.style.transition = 'all 0.4s ease';
            badge.style.opacity = '1';
            badge.style.transform = 'scale(1)';
        }, 1200 + (index * 50));
    });
    
    // Effet de parallax léger pour l'arrière-plan
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.1;
        
        document.body.style.backgroundPosition = `center ${parallax}px`;
    });
    
    // Auto-refresh data every 5 minutes
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            // Animation de mise à jour des statistiques
            const statCards = document.querySelectorAll('.row.mb-4 .card h3');
            statCards.forEach(stat => {
                stat.style.animation = 'pulse-update 1s ease';
            });
            
            // Animation subtile pour indiquer la mise à jour
            const mainCards = document.querySelectorAll('.row.mb-4 .card');
            mainCards.forEach(card => {
                card.style.opacity = '0.7';
                setTimeout(() => {
                    card.style.opacity = '1';
                }, 200);
            });
            
            console.log('Données du tableau de bord mises à jour automatiquement...');
        }
    }, 300000); // 5 minutes
    
    // Gestion responsive pour les animations
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    
    function handleResponsive(e) {
        if (e.matches) {
            // Désactiver certaines animations sur mobile
            cards.forEach(card => {
                card.style.transition = 'opacity 0.3s ease';
            });
            
            // Réduire les effets de survol sur mobile
            quickAccessButtons.forEach(button => {
                button.style.transform = 'scale(1)';
                button.style.transition = 'opacity 0.3s ease';
            });
        } else {
            // Réactiver les animations sur desktop
            cards.forEach(card => {
                card.style.transition = 'all 0.3s ease';
            });
        }
    }
    
    mediaQuery.addListener(handleResponsive);
    handleResponsive(mediaQuery);
    
    // Gestion de l'état de chargement pour les liens
    const navLinks = document.querySelectorAll('a[href*="route"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            this.classList.add('loading');
            
            // Retirer l'état de chargement après 3 secondes (au cas où)
            setTimeout(() => {
                this.classList.remove('loading');
            }, 3000);
        });
    });
    
    // Animation d'entrée échelonnée pour les éléments du tableau
    const tableElements = document.querySelectorAll('.table tbody tr td');
    tableElements.forEach((cell, index) => {
        cell.style.opacity = '0';
        cell.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            cell.style.transition = 'all 0.3s ease';
            cell.style.opacity = '1';
            cell.style.transform = 'translateY(0)';
        }, 1500 + (index * 20));
    });
    
    // Effet de focus amélioré pour l'accessibilité
    const focusableElements = document.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '3px solid rgba(51, 102, 153, 0.5)';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
    
    // Initialisation des tooltips Bootstrap si disponible
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    console.log('Tableau de bord pharmacien initialisé avec succès');
});

// Fonction utilitaire pour formater les nombres
function formatNumber(number, decimals = 2) {
    return number.toLocaleString('fr-FR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}

// Fonction pour animer un compteur
function animateCounter(element, target, duration = 1000) {
    const start = 0;
    const startTime = performance.now();
    
    function updateCounter(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        
        const current = Math.floor(progress * target);
        element.textContent = current;
        
        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        }
    }
    
    requestAnimationFrame(updateCounter);
}

// Gestion des erreurs JavaScript
window.addEventListener('error', function(e) {
    console.warn('Erreur JavaScript dans le tableau de bord:', e.message);
});
</script>

@endsection