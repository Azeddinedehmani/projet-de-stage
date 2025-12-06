@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-prescription-bottle text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport des ordonnances</h2>
                <small class="text-muted">Analyse complète des prescriptions médicales</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.prescriptions.pdf', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
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
            <form action="{{ route('reports.prescriptions') }}" method="GET" class="row g-3">
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
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total ordonnances</h6>
                            <h4 class="mb-0">{{ $totalPrescriptions }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-prescription-bottle fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Complètement délivrées</h6>
                            <h4 class="mb-0">{{ $completedPrescriptions }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Taux de délivrance</h6>
                            <h4 class="mb-0">{{ number_format($completionRate, 1) }}%</h4>
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
            <!-- Répartition par statut -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Répartition des ordonnances par statut
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="statusChart" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th class="border-0 fw-semibold" style="color: #336699;">Statut</th>
                                            <th class="border-0 fw-semibold text-center" style="color: #336699;">Nombre</th>
                                            <th class="border-0 fw-semibold text-end" style="color: #336699;">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prescriptionsByStatus as $status)
                                            <tr class="border-0">
                                                <td class="border-0">
                                                    @switch($status->status)
                                                        @case('pending')
                                                            <span class="badge bg-warning text-dark rounded-pill">En attente</span>
                                                            @break
                                                        @case('partially_delivered')
                                                            <span class="badge bg-info rounded-pill">Partiellement délivrée</span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-success rounded-pill">Complètement délivrée</span>
                                                            @break
                                                        @case('expired')
                                                            <span class="badge bg-danger rounded-pill">Expirée</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary rounded-pill">{{ ucfirst($status->status) }}</span>
                                                    @endswitch
                                                </td>
                                                <td class="text-center border-0">
                                                    <span class="fw-bold">{{ $status->count }}</span>
                                                </td>
                                                <td class="text-end border-0">
                                                    <span class="fw-bold">{{ $totalPrescriptions > 0 ? number_format(($status->count / $totalPrescriptions) * 100, 1) : 0 }}%</span>
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

            <!-- Top médicaments prescrits -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-trophy me-2" style="color: #336699;"></i>
                        Top 15 des médicaments prescrits
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($topPrescribedMedications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Rang</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Médicament</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Qté prescrite</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Qté délivrée</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Nb ordonnances</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Taux délivrance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topPrescribedMedications as $index => $medication)
                                        @php
                                            $deliveryRate = $medication->total_prescribed > 0 ? 
                                                ($medication->total_delivered / $medication->total_prescribed) * 100 : 0;
                                        @endphp
                                        <tr class="border-0">
                                            <td class="border-0">
                                                <span class="badge {{ $index < 3 ? 'bg-warning' : 'bg-secondary' }} rounded-pill">
                                                    #{{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td class="border-0"><strong>{{ $medication->name }}</strong></td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-primary rounded-pill">{{ $medication->total_prescribed }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-success rounded-pill">{{ $medication->total_delivered }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-info rounded-pill">{{ $medication->prescription_count }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge {{ $deliveryRate >= 80 ? 'bg-success' : ($deliveryRate >= 50 ? 'bg-warning text-dark' :'bg-danger') }} rounded-pill">
                                                    {{ number_format($deliveryRate, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-prescription-bottle fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucune prescription</h5>
                            <p class="text-muted">Aucune prescription pour cette période</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Ordonnances expirées -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar-times me-2"></i>
                        Ordonnances expirées ({{ $expiredPrescriptions->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($expiredPrescriptions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($expiredPrescriptions->take(10) as $prescription)
                                <div class="list-group-item border-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 fw-bold">{{ $prescription->prescription_number }}</h6>
                                        <small class="text-danger fw-medium">
                                            {{ $prescription->expiry_date->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <strong>{{ $prescription->client->full_name }}</strong>
                                    </p>
                                    <small class="text-muted">
                                        Dr. {{ $prescription->doctor_name }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                        @if($expiredPrescriptions->count() > 10)
                            <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                                <small class="text-muted fw-medium">
                                    Et {{ $expiredPrescriptions->count() - 10 }} autres...
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <p class="mb-0 fw-medium text-success">Aucune ordonnance expirée</p>
                        </div>
                    @endif
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
                        <a href="{{ route('prescriptions.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-prescription-bottle me-2"></i>
                            Voir toutes les ordonnances
                        </a>
                        
                        <a href="{{ route('prescriptions.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-plus me-2"></i>
                            Nouvelle ordonnance
                        </a>
                        
                        <a href="{{ route('prescriptions.index', ['status' => 'pending']) }}" class="btn text-dark fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-clock me-2"></i>
                            Ordonnances en attente
                        </a>
                        
                        <a href="{{ route('prescriptions.index', ['expiry_filter' => 'expired']) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-calendar-times me-2"></i>
                            Ordonnances expirées
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
    
    /* Animation pour les cartes expirées */
    .card .list-group-item {
        position: relative;
        overflow: hidden;
    }
    
    .card .list-group-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .card .list-group-item:hover::before {
        transform: scaleY(1);
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .row .col-md-6 {
            margin-bottom: 1rem;
        }
    }
    
    /* Effet glassmorphism pour les cartes */
    .card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Animation pour les badges de performance */
    .badge.bg-success {
        animation: pulse-success 3s infinite;
    }
    
    .badge.bg-danger {
        animation: pulse-danger 3s infinite;
    }
    
    @keyframes pulse-success {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    @keyframes pulse-danger {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); box-shadow: 0 0 10px rgba(220, 53, 69, 0.5); }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique en secteurs pour les statuts
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($prescriptionsByStatus);
    
    const statusLabels = statusData.map(item => {
        switch(item.status) {
            case 'pending': return 'En attente';
            case 'partially_delivered': return 'Partiellement délivrée';
            case 'completed': return 'Complètement délivrée';
            case 'expired': return 'Expirée';
            default: return item.status;
        }
    });
    
    const statusColors = [
        '#FFC107', // Jaune pour en attente
        '#17A2B8', // Bleu pour partiellement délivrée
        '#28A745', // Vert pour complètement délivrée
        '#DC3545', // Rouge pour expirée
        '#6C757D'  // Gris pour autres
    ];
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData.map(item => item.count),
                backgroundColor: statusColors.slice(0, statusData.length),
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
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
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
    
    // Animation pour les badges de statut avec des couleurs faibles
    const badgesWarning = document.querySelectorAll('.badge.bg-warning');
    const badgesDanger = document.querySelectorAll('.badge.bg-danger');
    
    badgesWarning.forEach(badge => {
        if (parseInt(badge.textContent) > 0) {
            badge.style.animation = 'pulse-warning 2s infinite';
        }
    });
    
    badgesDanger.forEach(badge => {
        if (parseInt(badge.textContent) > 0) {
            badge.style.animation = 'pulse-danger 2s infinite';
        }
    });
    
    // Ajout des animations CSS supplémentaires
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse-warning {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); box-shadow: 0 0 15px rgba(255, 193, 7, 0.4); }
            100% { transform: scale(1); }
        }
        
        @keyframes pulse-danger {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); box-shadow: 0 0 15px rgba(220, 53, 69, 0.4); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
    
    // Effet de compteur pour les statistiques
    const statNumbers = document.querySelectorAll('.card h4');
    statNumbers.forEach(number => {
        const text = number.textContent;
        const finalValue = parseInt(text.replace(/[^\d]/g, ''));
        
        if (finalValue && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 50;
            const isPercentage = text.includes('%');
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    current = finalValue;
                    clearInterval(timer);
                }
                number.textContent = Math.floor(current) + (isPercentage ? '%' : '');
            }, 30);
        }
    });
    
    // Interaction avec les éléments de la liste d'ordonnances expirées
    const expiredItems = document.querySelectorAll('.list-group-item');
    expiredItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.borderLeft = '4px solid #dc3545';
            this.style.paddingLeft = '1.5rem';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.borderLeft = 'none';
            this.style.paddingLeft = '1rem';
        });
    });
    
    // Tooltip pour les badges de performance
    const performanceBadges = document.querySelectorAll('table .badge');
    performanceBadges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.15)';
            this.style.zIndex = '10';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.zIndex = 'auto';
        });
    });
});
</script>
@endsection