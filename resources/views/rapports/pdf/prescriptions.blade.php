@extends('rapports.pdf.base')
@section('title', 'Rapport des Ordonnances')
@section('report-type', 'Rapport des Ordonnances')
@section('subtitle', 'Analyse complète des prescriptions médicales')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $totalPrescriptions }}</div>
            <div class="label">Total ordonnances</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $completedPrescriptions }}</div>
            <div class="label">Complètement délivrées</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ number_format($completionRate, 1) }}%</div>
            <div class="label">Taux de délivrance</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Répartition par statut</h2>
        <table class="main-table">
            <thead>
                <tr>
                    <th>Statut</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-right">Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescriptionsByStatus as $status)
                    <tr>
                        <td>
                            @switch($status->status)
                                @case('pending')
                                    <span class="badge badge-warning">En attente</span>
                                    @break
                                @case('partially_delivered')
                                    <span class="badge badge-info">Partiellement délivrée</span>
                                    @break
                                @case('completed')
                                    <span class="badge badge-success">Complètement délivrée</span>
                                    @break
                                @case('expired')
                                    <span class="badge badge-danger">Expirée</span>
                                    @break
                                @default
                                    <span class="badge badge-secondary">{{ ucfirst($status->status) }}</span>
                            @endswitch
                        </td>
                        <td class="text-center">{{ $status->count }}</td>
                        <td class="text-right">
                            {{ $totalPrescriptions > 0 ? number_format(($status->count / $totalPrescriptions) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2 class="section-title">Top 15 médicaments prescrits</h2>
        @if($topPrescribedMedications->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Médicament</th>
                        <th class="text-center">Qté prescrite</th>
                        <th class="text-center">Qté délivrée</th>
                        <th class="text-center">Nb ordonnances</th>
                        <th class="text-center">Taux délivrance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topPrescribedMedications as $index => $medication)
                        @php
                            $deliveryRate = $medication->total_prescribed > 0 ? 
                                ($medication->total_delivered / $medication->total_prescribed) * 100 : 0;
                        @endphp
                        <tr>
                            <td class="text-center">
                                <span class="rank {{ $index < 3 ? 'top-3' : '' }}">{{ $index + 1 }}</span>
                            </td>
                            <td><strong>{{ $medication->name }}</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $medication->total_prescribed }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $medication->total_delivered }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $medication->prescription_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $deliveryRate >= 80 ? 'badge-success' : ($deliveryRate >= 50 ? 'badge-warning' : 'badge-danger') }}">
                                    {{ number_format($deliveryRate, 1) }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Aucune prescription pour cette période</div>
        @endif
    </div>

    @if($expiredPrescriptions->count() > 0)
        <div class="section">
            <h2 class="section-title">Ordonnances expirées ({{ $expiredPrescriptions->count() }})</h2>
            <table class="main-table">
                <thead>
                    <tr>
                        <th>N° Ordonnance</th>
                        <th>Client</th>
                        <th>Médecin</th>
                        <th>Date d'expiration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expiredPrescriptions->take(20) as $prescription)
                        <tr class="critical">
                            <td><strong>{{ $prescription->prescription_number }}</strong></td>
                            <td>{{ $prescription->client->full_name }}</td>
                            <td>Dr. {{ $prescription->doctor_name }}</td>
                            <td>{{ $prescription->expiry_date->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($expiredPrescriptions->count() > 20)
                <p class="text-center"><em>Et {{ $expiredPrescriptions->count() - 20 }} autres ordonnances expirées...</em></p>
            @endif
        </div>
    @endif

    <div class="summary-box">
        <h3>Résumé exécutif</h3>
        <p><strong>Activité :</strong> {{ $totalPrescriptions }} ordonnances traitées avec un taux de délivrance complète de {{ number_format($completionRate, 1) }}%.</p>
        @if($topPrescribedMedications->count() > 0)
            <p><strong>Médicament le plus prescrit :</strong> {{ $topPrescribedMedications->first()->name }} ({{ $topPrescribedMedications->first()->total_prescribed }} unités).</p>
        @endif
        @if($expiredPrescriptions->count() > 0)
            <div class="highlight critical">
                <strong>Attention :</strong> {{ $expiredPrescriptions->count() }} ordonnance(s) expirée(s) nécessitent un suivi.
            </div>
        @endif
    </div>
@endsection