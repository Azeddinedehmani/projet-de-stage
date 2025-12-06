@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
   <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-shopping-cart text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport des ventes</h2>
                <small class="text-muted">Analyse complète des performances commerciales</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.sales.pdf', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
            </a>
        </div>
    </div>
</div>

    <!-- Filtres -->
    <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-filter me-2" style="color: #336699;"></i>
                Filtres de période
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.sales') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="date_from" class="form-label fw-semibold">Date de début</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $dateFrom }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label fw-semibold">Date de fin</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $dateTo }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-3">
                    <label for="group_by" class="form-label fw-semibold">Grouper par</label>
                    <select class="form-select" id="group_by" name="group_by" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="day" {{ $groupBy == 'day' ? 'selected' : '' }}>Jour</option>
                        <option value="week" {{ $groupBy == 'week' ? 'selected' : '' }}>Semaine</option>
                        <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Mois</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search me-1"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Chiffre d'affaires</h6>
                            <h4 class="mb-0">{{ number_format($totalSales, 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-euro-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Nombre de ventes</h6>
                            <h4 class="mb-0">{{ $totalTransactions }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-cart fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Panier moyen</h6>
                            <h4 class="mb-0">{{ number_format($averageTransaction, 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Graphique des ventes par période -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                        Évolution des ventes
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>

            <!-- Top produits vendus -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-trophy me-2" style="color: #336699;"></i>
                        Top 10 des produits vendus
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Rang</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité vendue</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Chiffre d'affaires</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $index => $product)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <span class="badge {{ $index < 3 ? 'bg-warning' : 'bg-secondary' }} rounded-pill">
                                                #{{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td class="border-0">
                                            <strong>{{ $product->name }}</strong>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-primary rounded-pill">{{ $product->total_quantity }}</span>
                                        </td>
                                        <td class="text-end border-0">
                                            <strong style="color: #28a745;">{{ number_format($product->total_revenue, 2) }} €</strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 border-0">
                                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                                <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted mb-2">Aucune vente</h5>
                                            <p class="text-muted">Aucune vente pour cette période</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Ventes par utilisateur -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-users me-2" style="color: #336699;"></i>
                        Ventes par vendeur
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Vendeur</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">CA</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Nb</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesByUser as $userSale)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%);">
                                                    {{ substr($userSale->name, 0, 1) }}
                                                </div>
                                                <span class="fw-medium">{{ Str::limit($userSale->name, 12) }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end border-0">
                                            <strong style="color: #28a745;">{{ number_format($userSale->total_sales, 0) }} €</strong>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-info rounded-pill">{{ $userSale->total_transactions }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Répartition par mode de paiement -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-credit-card me-2" style="color: #336699;"></i>
                        Modes de paiement
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentChart" height="200"></canvas>
                </div>
                <div class="card-footer border-0 p-0" style="background: transparent;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @foreach($salesByPaymentMethod as $payment)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            @switch($payment->payment_method)
                                                @case('cash')
                                                    <i class="fas fa-money-bill text-success me-2"></i>Espèces
                                                    @break
                                                @case('card')
                                                    <i class="fas fa-credit-card me-2" style="color: #336699;"></i>Carte
                                                    @break
                                                @case('insurance')
                                                    <i class="fas fa-shield-alt text-info me-2"></i>Assurance
                                                    @break
                                                @default
                                                    <i class="fas fa-question text-muted me-2"></i>{{ ucfirst($payment->payment_method) }}
                                            @endswitch
                                        </td>
                                        <td class="text-end border-0">
                                            <strong style="color: #28a745;">{{ number_format($payment->total, 2) }} €</strong>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-secondary rounded-pill">{{ $payment->count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    /* Effet glassmorphism pour les cartes */
    .card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Animation pour les top produits */
    .table tbody tr:nth-child(-n+3) {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(253, 126, 20, 0.1) 100%);
    }
    
    /* Styles responsive */
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
    // Graphique des ventes par période
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesByPeriod);
    
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesData.map(item => {
                const date = new Date(item.period);
                return date.toLocaleDateString('fr-FR');
            }),
            datasets: [{
                label: 'Chiffre d\'affaires (€)',
                data: salesData.map(item => item.total),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }, {
                label: 'Nombre de ventes',
                data: salesData.map(item => item.count),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                yAxisID: 'y1',
                borderWidth: 3,
                pointBackgroundColor: 'rgb(255, 99, 132)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Évolution des ventes',
                    font: {
                        family: 'Poppins',
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#2c3e50'
                },
                legend: {
                    labels: {
                        font: {
                            family: 'Rubik',
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#2c3e50',
                    bodyColor: '#2c3e50',
                    borderColor: '#336699',
                    borderWidth: 2,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Chiffre d\'affaires (€)',
                        font: {
                            family: 'Rubik',
                            weight: '500'
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Nombre de ventes',
                        font: {
                            family: 'Rubik',
                            weight: '500'
                        }
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
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
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Graphique des modes de paiement (doughnut)
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    const paymentData = @json($salesByPaymentMethod);
    
    const colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];
    
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: paymentData.map(item => {
                switch(item.payment_method) {
                    case 'cash': return 'Espèces';
                    case 'card': return 'Carte';
                    case 'insurance': return 'Assurance';
                    default: return item.payment_method.charAt(0).toUpperCase() + item.payment_method.slice(1);
                }
            }),
            datasets: [{
                data: paymentData.map(item => item.total),
                backgroundColor: colors.slice(0, paymentData.length),
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
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed.toLocaleString('fr-FR', {
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
                    cornerRadius: 8
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500,
                easing: 'easeInOutQuart'
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
    
    // Effet de compteur pour les statistiques
    const statNumbers = document.querySelectorAll('.card h4');
    statNumbers.forEach(number => {
        const text = number.textContent;
        const finalValue = parseFloat(text.replace(/[^\d.,]/g, '').replace(',', '.'));
        
        if (finalValue && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 50;
            const hasEuro = text.includes('€');
            const hasDecimals = text.includes(',') || text.includes('.');
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    current = finalValue;
                    clearInterval(timer);
                }
                
            if (hasDecimals) {
                    number.textContent = current.toLocaleString('fr-FR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + (hasEuro ? ' €' : '');
                } else {
                    number.textContent = Math.floor(current).toLocaleString('fr-FR') + (hasEuro ? ' €' : '');
                }
            }, 30);
        }
    });
    
    // Animation pour les badges de rang
    const rankBadges = document.querySelectorAll('.badge.bg-warning');
    rankBadges.forEach(badge => {
        badge.style.animation = 'shine 3s infinite';
    });
    
    // Ajout de l'animation CSS pour l'effet brillant
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shine {
            0% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
            50% { box-shadow: 0 0 20px rgba(255, 193, 7, 0.8), 0 0 30px rgba(255, 193, 7, 0.6); }
            100% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
        }
        
        @keyframes glow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    `;
    document.head.appendChild(style);
    
    // Interaction avec les lignes du top produits
    const topProductRows = document.querySelectorAll('.table tbody tr');
    topProductRows.forEach((row, index) => {
        if (index < 3) { // Top 3
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.boxShadow = '0 4px 15px rgba(255, 193, 7, 0.3)';
                this.style.borderLeft = '4px solid #ffc107';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
                this.style.borderLeft = 'none';
            });
        }
    });
    
    // Animation pour les avatars des vendeurs
    const userAvatars = document.querySelectorAll('.rounded-circle');
    userAvatars.forEach(avatar => {
        avatar.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2) rotate(5deg)';
            this.style.boxShadow = '0 4px 15px rgba(51, 102, 153, 0.4)';
        });
        
        avatar.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Effet de pulsation pour les chiffres d'affaires élevés
    const revenueElements = document.querySelectorAll('[style*="color: #28a745"]');
    revenueElements.forEach(element => {
        const value = parseFloat(element.textContent.replace(/[^\d.,]/g, '').replace(',', '.'));
        if (value > 1000) { // Si le CA est supérieur à 1000€
            element.style.animation = 'glow 2s infinite';
        }
    });
    
    // Interaction avec les icônes de mode de paiement
    const paymentIcons = document.querySelectorAll('.fa-money-bill, .fa-credit-card, .fa-shield-alt');
    paymentIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.3)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Animation des éléments au défilement
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    // Observer tous les éléments avec animation
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'all 0.6s ease';
        observer.observe(row);
    });
});
</script>
@endsection