@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-users text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport clients</h2>
                <small class="text-muted">Analyse détaillée de la clientèle</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.clients.pdf', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
            </a>
        </div>
    </div>
</div>

    <!-- Filtres de période -->
    <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-calendar-alt me-2" style="color: #336699;"></i>
                Période d'analyse
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.clients') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="date_from" class="form-label fw-semibold">Date de début</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $dateFrom }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-4">
                    <label for="date_to" class="form-label fw-semibold">Date de fin</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $dateTo }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search me-1"></i> Analyser
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total clients</h6>
                            <h4 class="mb-0">{{ $totalClients }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Clients actifs</h6>
                            <h4 class="mb-0">{{ $activeClients }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-check fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Avec achats</h6>
                            <h4 class="mb-0">{{ $clientsWithPurchases }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-cart fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Avec allergies</h6>
                            <h4 class="mb-0">{{ $clientsWithAllergies }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle fa-2x" style="color: #212529;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Top clients -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-trophy me-2" style="color: #336699;"></i>
                        Top 20 clients par montant dépensé
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($topClients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Rang</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Client</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Email</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Nb achats</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">Total dépensé</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">Panier moyen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topClients as $index => $client)
                                        <tr class="border-0">
                                            <td class="border-0">
                                                <span class="badge {{ $index < 3 ? 'bg-warning' : 'bg-secondary' }} rounded-pill">
                                                    #{{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td class="border-0">
                                                <div>
                                                    <strong>{{ $client->full_name }}</strong>
                                                    @if($client->phone)
                                                        <br><small class="text-muted">{{ $client->phone }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-0">{{ $client->email ?? 'N/A' }}</td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-primary rounded-pill">{{ $client->total_purchases }}</span>
                                            </td>
                                            <td class="text-end border-0">
                                                <strong style="color: #28a745;">{{ number_format($client->total_spent, 2) }} €</strong>
                                            </td>
                                            <td class="text-end border-0">
                                                {{ $client->total_purchases > 0 ? number_format($client->total_spent / $client->total_purchases, 2) : '0' }} €
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background-color: #f8f9fa;">
                                    <tr>
                                        <th colspan="3" class="border-0 fw-bold">Total</th>
                                        <th class="text-center border-0 fw-bold">{{ $topClients->sum('total_purchases') }}</th>
                                        <th class="text-end border-0 fw-bold">{{ number_format($topClients->sum('total_spent'), 2) }} €</th>
                                        <th class="text-end border-0 fw-bold">
                                            {{ $topClients->sum('total_purchases') > 0 ? number_format($topClients->sum('total_spent') / $topClients->sum('total_purchases'), 2) : '0' }} €
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-users fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucun achat client</h5>
                            <p class="text-muted">Aucun achat client pour cette période</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Évolution nouveaux clients -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                        Évolution des nouveaux clients (12 derniers mois)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="newClientsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Analyse des clients -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Analyse des clients
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                @php
                                    $activePercentage = $totalClients > 0 ? ($activeClients / $totalClients) * 100 : 0;
                                @endphp
                                <h4 class="text-success fw-bold">{{ number_format($activePercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">Clients actifs</small>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                @php
                                    $withPurchasesPercentage = $totalClients > 0 ? ($clientsWithPurchases / $totalClients) * 100 : 0;
                                @endphp
                                <h4 class="fw-bold" style="color: #336699;">{{ number_format($withPurchasesPercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">Ont effectué des achats</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                @php
                                    $allergiesPercentage = $totalClients > 0 ? ($clientsWithAllergies / $totalClients) * 100 : 0;
                                @endphp
                                <h4 class="text-warning fw-bold">{{ number_format($allergiesPercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">Avec allergies déclarées</small>
                            </div>
                        </div>
                    </div>
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
                        <a href="{{ route('clients.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-users me-2"></i>
                            Voir tous les clients
                        </a>
                        
                        <a href="{{ route('clients.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-plus me-2"></i>
                            Ajouter un client
                        </a>
                        
                        <a href="{{ route('clients.index', ['status' => 'active']) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-user-check me-2"></i>
                            Clients actifs uniquement
                        </a>
                        
                        <a href="{{ route('sales.create') }}" class="btn text-dark fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Nouvelle vente
                        </a>
                    </div>
                </div>
                <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                    <small class="text-muted fw-medium">
                        <i class="fas fa-info-circle me-1"></i>
                        Période analysée : {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}
                    </small>
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
    
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique d'évolution des nouveaux clients
    const newClientsCtx = document.getElementById('newClientsChart').getContext('2d');
    const newClientsData = @json($newClientsByMonth);
    
    new Chart(newClientsCtx, {
        type: 'bar',
        data: {
            labels: newClientsData.map(item => {
                const [year, month] = item.month.split('-');
                return new Date(year, month - 1).toLocaleDateString('fr-FR', { 
                    year: 'numeric', 
                    month: 'short' 
                });
            }),
            datasets: [{
                label: 'Nouveaux clients',
                data: newClientsData.map(item => item.count),
                backgroundColor: 'linear-gradient(180deg, #336699 0%, #4a90e2 100%)',
                borderColor: '#336699',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Nouveaux clients par mois',
                    font: {
                        family: 'Poppins',
                        size: 14,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            family: 'Rubik'
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Rubik'
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection