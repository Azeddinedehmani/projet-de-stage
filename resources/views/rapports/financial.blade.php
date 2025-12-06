@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-euro-sign text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport financier</h2>
                <small class="text-muted">Analyse complète des performances financières</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.financial.pdf', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
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
            <form action="{{ route('reports.financial') }}" method="GET" class="row g-3">
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

    <!-- Résumé financier -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Revenus</h6>
                            <h4 class="mb-0">{{ number_format($revenue, 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-up fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Dépenses</h6>
                            <h4 class="mb-0">{{ number_format($expenses, 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-down fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, {{ $profit >= 0 ? '#336699 0%, #4a90e2 100%' : '#ffc107 0%, #fd7e14 100%' }}); color: {{ $profit >= 0 ? 'white' : '#212529' }}; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">{{ $profit >= 0 ? 'Bénéfice' : 'Perte' }}</h6>
                            <h4 class="mb-0">{{ number_format(abs($profit), 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: {{ $profit >= 0 ? 'rgba(255, 255, 255, 0.2)' : 'rgba(33, 37, 41, 0.15)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas {{ $profit >= 0 ? 'fa-chart-line' : 'fa-chart-line-down' }} fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Évolution mensuelle -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                        Évolution sur 12 mois
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="financialChart" height="100"></canvas>
                </div>
            </div>

            <!-- Top marges par produit -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-percentage me-2" style="color: #336699;"></i>
                        Top 20 - Marges par produit
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($productMargins->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Qté vendue</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">CA</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">Coût</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">Marge</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">% Marge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productMargins as $product)
                                        @php
                                            $marginPercent = $product->total_cost > 0 ? (($product->total_margin / $product->total_cost) * 100) : 0;
                                        @endphp
                                        <tr class="border-0">
                                            <td class="border-0"><strong>{{ $product->name }}</strong></td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-primary rounded-pill">{{ $product->total_sold }}</span>
                                            </td>
                                            <td class="text-end border-0">{{ number_format($product->total_revenue, 2) }} €</td>
                                            <td class="text-end border-0">{{ number_format($product->total_cost, 2) }} €</td>
                                            <td class="text-end border-0">
                                                <strong class="{{ $product->total_margin >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ number_format($product->total_margin, 2) }} €
                                                </strong>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge {{ $marginPercent >= 50 ? 'bg-success' : ($marginPercent >= 25 ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill">
                                                    {{ number_format($marginPercent, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-bold">Total</th>
                                        <th class="text-center border-0 fw-bold">{{ $productMargins->sum('total_sold') }}</th>
                                        <th class="text-end border-0 fw-bold">{{ number_format($productMargins->sum('total_revenue'), 2) }} €</th>
                                        <th class="text-end border-0 fw-bold">{{ number_format($productMargins->sum('total_cost'), 2) }} €</th>
                                        <th class="text-end border-0 fw-bold">
                                            {{ number_format($productMargins->sum('total_margin'), 2) }} €
                                        </th>
                                        <th class="text-center border-0 fw-bold">
                                            @php
                                                $totalMarginPercent = $productMargins->sum('total_cost') > 0 ? 
                                                    (($productMargins->sum('total_margin') / $productMargins->sum('total_cost')) * 100) : 0;
                                            @endphp
                                            {{ number_format($totalMarginPercent, 1) }}%
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-chart-bar fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucune donnée de marge</h5>
                            <p class="text-muted">Aucune donnée de marge pour cette période</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Indicateurs de performance -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-tachometer-alt me-2" style="color: #336699;"></i>
                        Indicateurs clés
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                @php
                                    $profitMargin = $revenue > 0 ? ($profit / $revenue) * 100 : 0;
                                @endphp
                                <h4 class="{{ $profitMargin >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ number_format($profitMargin, 1) }}%
                                </h4>
                                <small class="text-muted fw-medium">Marge nette</small>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                @php
                                    $roi = $expenses > 0 ? ($profit / $expenses) * 100 : 0;
                                @endphp
                                <h4 class="{{ $roi >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ number_format($roi, 1) }}%
                                </h4>
                                <small class="text-muted fw-medium">ROI</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                @php
                                    $profitPerDay = $profit / max(1, \Carbon\Carbon::parse($dateFrom)->diffInDays(\Carbon\Carbon::parse($dateTo)) + 1);
                                @endphp
                                <h4 class="{{ $profitPerDay >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ number_format($profitPerDay, 0) }} €
                                </h4>
                                <small class="text-muted fw-medium">{{ $profitPerDay >= 0 ? 'Bénéfice' : 'Perte' }} / jour</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse des marges -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Répartition des marges
                    </h5>
                </div>
                <div class="card-body">
                    @if($productMargins->count() > 0)
                        <canvas id="marginChart" height="200"></canvas>
                        <div class="mt-3">
                            @php
                                $highMarginProducts = $productMargins->filter(function($product) {
                                    return $product->total_cost > 0 && (($product->total_margin / $product->total_cost) * 100) >= 50;
                                })->count();
                                $lowMarginProducts = $productMargins->filter(function($product) {
                                    return $product->total_cost > 0 && (($product->total_margin / $product->total_cost) * 100) < 25;
                                })->count();
                            @endphp
                            <small class="text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>Marge élevée (≥50%)</span>
                                    <span class="badge bg-success rounded-pill">{{ $highMarginProducts }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Marge faible (<25%)</span>
                                    <span class="badge bg-danger rounded-pill">{{ $lowMarginProducts }}</span>
                                </div>
                            </small>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <p class="mb-0">Pas de données</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions recommandées -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-lightbulb me-2"></i>
                        Recommandations
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @if($profit < 0)
                            <li class="mb-2">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                <strong>Attention :</strong> Période déficitaire. Analyser les coûts.
                            </li>
                        @endif
                        
                        @if($profitMargin < 10)
                            <li class="mb-2">
                                <i class="fas fa-chart-line text-warning me-2"></i>
                                Marge nette faible. Optimiser les prix de vente.
                            </li>
                        @endif
                        
                        @if($productMargins->where('total_margin', '<', 0)->count() > 0)
                            <li class="mb-2">
                                <i class="fas fa-minus-circle text-danger me-2"></i>
                                {{ $productMargins->where('total_margin', '<', 0)->count() }} produit(s) à marge négative.
                            </li>
                        @endif
                        
                        @if($profit >= 0 && $profitMargin >= 15)
                            <li class="mb-0">
                                <i class="fas fa-thumbs-up text-success me-2"></i>
                                Excellente performance financière !
                            </li>
                        @endif
                    </ul>
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
    // Graphique d'évolution mensuelle
    const financialCtx = document.getElementById('financialChart').getContext('2d');
    const revenueData = @json($revenueByMonth);
    const expenseData = @json($expensesByMonth);
    
    // Fusion des données par mois
    const months = [...new Set([...revenueData.map(r => r.month), ...expenseData.map(e => e.month)])].sort();
    
    const revenueByMonth = months.map(month => {
        const found = revenueData.find(r => r.month === month);
        return found ? parseFloat(found.revenue) : 0;
    });
    
    const expensesByMonth = months.map(month => {
        const found = expenseData.find(e => e.month === month);
        return found ? parseFloat(found.expenses) : 0;
    });
    
    const profitByMonth = months.map((month, index) => revenueByMonth[index] - expensesByMonth[index]);
    
    new Chart(financialCtx, {
        type: 'line',
        data: {
            labels: months.map(month => {
                const [year, monthNum] = month.split('-');
                return new Date(year, monthNum - 1).toLocaleDateString('fr-FR', { 
                    year: 'numeric', 
                    month: 'short' 
                });
            }),
            datasets: [{
                label: 'Revenus',
                data: revenueByMonth,
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.1
            }, {
                label: 'Dépenses',
                data: expensesByMonth,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.1
            }, {
                label: 'Profit/Perte',
                data: profitByMonth,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Évolution financière sur 12 mois',
                    font: {
                        family: 'Poppins',
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-FR', {
                                style: 'currency',
                                currency: 'EUR',
                                minimumFractionDigits: 0
                            });
                        },
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

    // Graphique des marges (si des données existent)
    @if($productMargins->count() > 0)
    const marginCtx = document.getElementById('marginChart').getContext('2d');
    const marginData = @json($productMargins->take(5)); // Top 5 seulement pour la lisibilité
    
    new Chart(marginCtx, {
        type: 'doughnut',
        data: {
            labels: marginData.map(item => item.name),
            datasets: [{
                data: marginData.map(item => parseFloat(item.total_margin)),
                backgroundColor: [
                    '#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 10,
                        font: {
                            family: 'Rubik'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + 
                                   context.parsed.toLocaleString('fr-FR', {
                                       style: 'currency',
                                       currency: 'EUR'
                                   });
                        }
                    }
                }
            }
        }
    });
    @endif
});
</script>
@endsection