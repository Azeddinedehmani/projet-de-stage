@extends('rapports.pdf.base')

@section('title', 'Rapport Clients')
@section('report-type', 'Rapport Clients')
@section('subtitle', 'Analyse détaillée de la clientèle')

@section('content')
    <!-- Statistiques générales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $totalClients }}</div>
            <div class="label">Total clients</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $activeClients }}</div>
            <div class="label">Clients actifs</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $clientsWithPurchases }}</div>
            <div class="label">Avec achats</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $clientsWithAllergies }}</div>
            <div class="label">Avec allergies</div>
        </div>
    </div>

    <!-- Top clients -->
    <div class="section">
        <h2 class="section-title">Top 20 clients par montant dépensé</h2>
        @if($topClients->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th class="text-center">Nb achats</th>
                        <th class="text-right">Total dépensé</th>
                        <th class="text-right">Panier moyen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topClients as $index => $client)
                        <tr>
                            <td class="text-center">
                                <span class="rank {{ $index < 3 ? 'top-3' : '' }}">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <strong>{{ $client->full_name }}</strong>
                                @if($client->phone)
                                    <br><small>{{ $client->phone }}</small>
                                @endif
                            </td>
                            <td>{{ $client->email ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $client->total_purchases }}</span>
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($client->total_spent, 2) }} €</span>
                            </td>
                            <td class="text-right">
                                {{ $client->total_purchases > 0 ? number_format($client->total_spent / $client->total_purchases, 2) : '0.00' }} €
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td colspan="3">TOTAL</td>
                        <td class="text-center">{{ $topClients->sum('total_purchases') }}</td>
                        <td class="text-right">{{ number_format($topClients->sum('total_spent'), 2) }} €</td>
                        <td class="text-right">
                            {{ $topClients->sum('total_purchases') > 0 ? number_format($topClients->sum('total_spent') / $topClients->sum('total_purchases'), 2) : '0.00' }} €
                        </td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">
                Aucun achat client pour cette période
            </div>
        @endif
    </div>

    <!-- Analyse des clients -->
    <div class="section">
        <h2 class="section-title">Analyse de la répartition</h2>
        <div class="two-column">
            <div>
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>Indicateur</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-right">Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Clients actifs</strong></td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $activeClients }}</span>
                            </td>
                            <td class="text-right">
                                @php $activePercentage = $totalClients > 0 ? ($activeClients / $totalClients) * 100 : 0; @endphp
                                <strong>{{ number_format($activePercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Ont effectué des achats</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $clientsWithPurchases }}</span>
                            </td>
                            <td class="text-right">
                                @php $withPurchasesPercentage = $totalClients > 0 ? ($clientsWithPurchases / $totalClients) * 100 : 0; @endphp
                                <strong>{{ number_format($withPurchasesPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Avec allergies déclarées</strong></td>
                            <td class="text-center">
                                <span class="badge badge-warning">{{ $clientsWithAllergies }}</span>
                            </td>
                            <td class="text-right">
                                @php $allergiesPercentage = $totalClients > 0 ? ($clientsWithAllergies / $totalClients) * 100 : 0; @endphp
                                <strong>{{ number_format($allergiesPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Clients inactifs</strong></td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{ $totalClients - $activeClients }}</span>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format(100 - $activePercentage, 1) }}%</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <div class="summary-box">
                    <h3>Points clés</h3>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li><strong>Taux d'activité :</strong> {{ number_format($activePercentage, 1) }}% des clients sont actifs</li>
                        <li><strong>Taux de conversion :</strong> {{ number_format($withPurchasesPercentage, 1) }}% ont effectué des achats</li>
                        <li><strong>Vigilance allergies :</strong> {{ number_format($allergiesPercentage, 1) }}% ont des allergies déclarées</li>
                        @if($topClients->count() > 0)
                            <li><strong>Client premium :</strong> {{ $topClients->first()->full_name }} ({{ number_format($topClients->first()->total_spent, 2) }} €)</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Résumé exécutif -->
    <div class="summary-box">
        <h3>Résumé exécutif</h3>
        <p><strong>Base clientèle :</strong> {{ $totalClients }} clients au total, dont {{ $activeClients }} actifs ({{ number_format($activePercentage, 1) }}%).</p>
        
        <p><strong>Activité commerciale :</strong> {{ $clientsWithPurchases }} clients ont effectué des achats sur la période, 
           représentant {{ number_format($withPurchasesPercentage, 1) }}% de la base totale.</p>
        
        @if($clientsWithAllergies > 0)
            <p><strong>Suivi médical :</strong> {{ $clientsWithAllergies }} clients ({{ number_format($allergiesPercentage, 1) }}%) 
               ont des allergies déclarées nécessitant une attention particulière.</p>
        @endif
        
        @if($topClients->count() > 0)
            <p><strong>Performance du top 20 :</strong> 
               Chiffre d'affaires cumulé de {{ number_format($topClients->sum('total_spent'), 2) }} € 
               sur {{ $topClients->sum('total_purchases') }} achats, 
               soit un panier moyen de {{ number_format($topClients->sum('total_purchases') > 0 ? $topClients->sum('total_spent') / $topClients->sum('total_purchases') : 0, 2) }} €.</p>
        @endif
        
        @php
            $inactiveClients = $totalClients - $activeClients;
        @endphp
        @if($inactiveClients > 0)
            <div class="highlight warning">
                <strong>Attention :</strong> {{ $inactiveClients }} client(s) inactif(s) pourraient nécessiter une action de réactivation.
            </div>
        @endif
    </div>
@endsection