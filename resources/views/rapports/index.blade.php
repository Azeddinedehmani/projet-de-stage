@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-chart-bar text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Tableau de bord - Rapports</h2>
                <small class="text-muted">Vue d'ensemble des performances</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <button type="button" class="btn text-white fw-semibold dropdown-toggle" data-bs-toggle="dropdown" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-download me-1"></i> Exporter
            </button>
            <ul class="dropdown-menu" style="border-radius: 10px; border: none; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <li><a class="dropdown-item" href="{{ route('reports.sales.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Ventes PDF</a></li>
                <li><a class="dropdown-item" href="{{ route('reports.inventory.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Inventaire PDF</a></li>
                <li><a class="dropdown-item" href="{{ route('reports.clients.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Clients PDF</a></li>
                <li><a class="dropdown-item" href="{{ route('reports.prescriptions.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Ordonnances PDF</a></li>
                <li><a class="dropdown-item" href="{{ route('reports.financial.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Financier PDF</a></li>
                <li><a class="dropdown-item" href="{{ route('reports.suppliers.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Fournisseurs PDF</a></li>
                @if(Auth::user()->isAdmin())
                    <li><a class="dropdown-item" href="{{ route('reports.users.pdf') }}"><i class="fas fa-file-pdf me-2"></i>Rapport Utilisateurs PDF</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>

    <!-- Navigation des rapports -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Navigation des rapports
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="row text-center g-3">
                        <div class="col-md-2 col-6">
                            <a href="{{ route('reports.sales') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border: 2px solid #336699; border-radius: 12px; color: #336699; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(51, 102, 153, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <span class="fw-semibold">Ventes</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-6">
                            <a href="{{ route('reports.inventory') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%); border: 2px solid #28a745; border-radius: 12px; color: #28a745; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(40, 167, 69, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <span class="fw-semibold">Inventaire</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-6">
                            <a href="{{ route('reports.clients') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%); border: 2px solid #17a2b8; border-radius: 12px; color: #17a2b8; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(23, 162, 184, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span class="fw-semibold">Clients</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-6">
                            <a href="{{ route('reports.prescriptions') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%); border: 2px solid #ffc107; border-radius: 12px; color: #b8860b; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(255, 193, 7, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-prescription-bottle fa-2x mb-2"></i>
                                <span class="fw-semibold">Ordonnances</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-6">
                            <a href="{{ route('reports.financial') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border: 2px solid #dc3545; border-radius: 12px; color: #dc3545; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(220, 53, 69, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-euro-sign fa-2x mb-2"></i>
                                <span class="fw-semibold">Financier</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-6">
                            <a href="{{ route('reports.suppliers') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); border: 2px solid #6c757d; border-radius: 12px; color: #6c757d; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(108, 117, 125, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-truck fa-2x mb-2"></i>
                                <span class="fw-semibold">Fournisseurs</span>
                            </a>
                        </div>
                    </div>
                    @if(Auth::user()->isAdmin())
                    <div class="row text-center mt-3">
                        <div class="col-md-2 offset-md-5">
                            <a href="{{ route('reports.users') }}" class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none" style="background: linear-gradient(135deg, #f5f5f5 0%, #e9ecef 100%); border: 2px solid #343a40; border-radius: 12px; color: #343a40; transition: all 0.3s ease; min-height: 120px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(52, 58, 64, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-users-cog fa-2x mb-2"></i>
                                <span class="fw-semibold">Utilisateurs</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques de vente -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Aujourd'hui</h6>
                            <h4 class="mb-0">{{ number_format($salesStats['today'], 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Cette semaine</h6>
                            <h4 class="mb-0">{{ number_format($salesStats['week'], 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-week fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Ce mois</h6>
                            <h4 class="mb-0">{{ number_format($salesStats['month'], 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Cette année</h6>
                            <h4 class="mb-0">{{ number_format($salesStats['year'], 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line fa-2x" style="color: #212529;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Statistiques inventaire -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-boxes me-2" style="color: #336699;"></i>
                        État de l'inventaire
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <h3 class="fw-bold" style="color: #336699;">{{ $inventoryStats['total_products'] }}</h3>
                                <small class="text-muted fw-medium">Total produits</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);">
                                <h3 class="text-warning fw-bold">{{ $inventoryStats['low_stock'] }}</h3>
                                <small class="text-muted fw-medium">Stock faible</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);">
                                <h3 class="text-danger fw-bold">{{ $inventoryStats['out_of_stock'] }}</h3>
                                <small class="text-muted fw-medium">Rupture</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);">
                                <h3 class="text-info fw-bold">{{ $inventoryStats['expiring_soon'] }}</h3>
                                <small class="text-muted fw-medium">Expire bientôt</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                    <a href="{{ route('reports.inventory') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 8px 16px;">
                        Voir le rapport détaillé
                    </a>
                </div>
            </div>

            <!-- Statistiques clients -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-users me-2" style="color: #336699;"></i>
                        Clients
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%);">
                                <h3 class="text-success fw-bold">{{ $clientStats['total_clients'] }}</h3>
                                <small class="text-muted fw-medium">Total clients</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <h3 class="fw-bold" style="color: #336699;">{{ $clientStats['active_clients'] }}</h3>
                                <small class="text-muted fw-medium">Actifs</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);">
                                <h3 class="text-info fw-bold">{{ $clientStats['new_this_month'] }}</h3>
                                <small class="text-muted fw-medium">Nouveaux ce mois</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);">
                                <h3 class="text-warning fw-bold">{{ $clientStats['with_allergies'] }}</h3>
                                <small class="text-muted fw-medium">Avec allergies</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                    <a href="{{ route('reports.clients') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 8px 16px;">
                        Voir le rapport détaillé
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if(Auth::user()->isAdmin() && isset($purchaseStats))
            <!-- Statistiques achats (Admin seulement) -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2" style="color: #336699;"></i>
                        Achats (Admin)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);">
                                <h3 class="text-warning fw-bold">{{ $purchaseStats['pending_purchases'] }}</h3>
                                <small class="text-muted fw-medium">En attente</small>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%);">
                                <h3 class="text-success fw-bold">{{ number_format($purchaseStats['total_this_month'], 0) }} €</h3>
                                <small class="text-muted fw-medium">Ce mois</small>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);">
                                <h3 class="text-danger fw-bold">{{ $purchaseStats['overdue_purchases'] }}</h3>
                                <small class="text-muted fw-medium">En retard</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                    <a href="{{ route('purchases.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 8px 16px;">
                        Voir les commandes
                    </a>
                </div>
            </div>
            @endif

            <!-- Alertes importantes -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Alertes importantes
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @if($inventoryStats['out_of_stock'] > 0)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <span><i class="fas fa-times-circle text-danger me-2"></i>Produits en rupture de stock</span>
                            <span class="badge bg-danger rounded-pill">{{ $inventoryStats['out_of_stock'] }}</span>
                        </li>
                        @endif
                        
                        @if($inventoryStats['low_stock'] > 0)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <span><i class="fas fa-exclamation-triangle text-warning me-2"></i>Stock faible</span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $inventoryStats['low_stock'] }}</span>
                        </li>
                        @endif
                        
                        @if($inventoryStats['expiring_soon'] > 0)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <span><i class="fas fa-calendar-times text-info me-2"></i>Expire dans 30 jours</span>
                            <span class="badge bg-info rounded-pill">{{ $inventoryStats['expiring_soon'] }}</span>
                        </li>
                        @endif
                        
                        @if(Auth::user()->isAdmin() && isset($purchaseStats) && $purchaseStats['overdue_purchases'] > 0)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <span><i class="fas fa-truck text-danger me-2"></i>Commandes en retard</span>
                            <span class="badge bg-danger rounded-pill">{{ $purchaseStats['overdue_purchases'] }}</span>
                        </li>
                        @endif
                    </ul>
                    
                    @if($inventoryStats['out_of_stock'] == 0 && $inventoryStats['low_stock'] == 0 && $inventoryStats['expiring_soon'] == 0)
                    <div class="text-center text-success py-3">
                        <i class="fas fa-check-circle fa-3x mb-2"></i>
                        <p class="mb-0 fw-medium">Aucune alerte importante pour le moment</p>
                    </div>
                    @endif
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
    
    .dropdown-menu {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .row.text-center .col-6,
        .row.text-center .col-md-2 {
            margin-bottom: 1rem;
        }
        
        .btn-group .dropdown-toggle {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
    
    /* Animation pour les cartes de navigation */
    .card .row .col-md-2 .btn,
    .card .row .col-6 .btn {
        position: relative;
        overflow: hidden;
    }
    
    .card .row .col-md-2 .btn::before,
    .card .row .col-6 .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .card .row .col-md-2 .btn:hover::before,
    .card .row .col-6 .btn:hover::before {
        left: 100%;
    }
    
    /* Amélioration des alertes */
    .list-group-item {
        background: transparent !important;
        padding: 0.75rem 0;
    }
    
    .list-group-item:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* Styles pour les badges */
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
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    // Animation pour les boutons de navigation
    const navButtons = document.querySelectorAll('.card-body .row .btn');
    navButtons.forEach((btn, index) => {
        btn.style.opacity = '0';
        btn.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            btn.style.transition = 'all 0.4s ease';
            btn.style.opacity = '1';
            btn.style.transform = 'scale(1)';
        }, 200 + (index * 50));
    });
    
    // Effet de pulsation pour les alertes critiques
    const criticalAlerts = document.querySelectorAll('.badge.bg-danger');
    criticalAlerts.forEach(badge => {
        if (parseInt(badge.textContent) > 0) {
            badge.style.animation = 'pulse 2s infinite';
        }
    });
    
    // Ajout de l'animation CSS pour le pulse
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
    
    // Gestion du hover sur les cartes statistiques
    const statCards = document.querySelectorAll('.row.mb-4 .card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.boxShadow = '0 12px 30px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Tooltip pour les icônes d'alerte
    const alertIcons = document.querySelectorAll('.list-group-item i');
    alertIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection