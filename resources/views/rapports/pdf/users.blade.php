@extends('rapports.pdf.base')
@section('title', 'Rapport des Utilisateurs')
@section('report-type', 'Rapport des Utilisateurs')
@section('subtitle', 'Analyse de l\'activité et des performances des utilisateurs')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $totalUsers }}</div>
            <div class="label">Total utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $activeUsers }}</div>
            <div class="label">Utilisateurs actifs</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $adminUsers }}</div>
            <div class="label">Administrateurs</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $pharmacistUsers }}</div>
            <div class="label">Pharmaciens</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Top utilisateurs par activité sur la période</h2>
        @if($topUsersByActivity->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th class="text-center">Actions</th>
                        <th class="text-center">Jours actifs</th>
                        <th class="text-center">Dernière connexion</th>
                        <th class="text-center">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsersByActivity as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                <br><small>{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $user->role === 'responsable' ? 'badge-danger' : 'badge-primary' }}">
                                    {{ $user->role === 'responsable' ? 'Admin' : 'Pharmacien' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $user->activity_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $user->active_days }}</span>
                            </td>
                            <td class="text-center">
                                @if($user->last_login_at)
                                    <small>{{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}</small>
                                @else
                                    <small>Jamais</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Aucune activité utilisateur pour cette période</div>
        @endif
    </div>

    @if($salesPerformance->count() > 0)
        <div class="section">
            <h2 class="section-title">Performance des ventes par utilisateur</h2>
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th class="text-center">Nb ventes</th>
                        <th class="text-right">CA total</th>
                        <th class="text-right">Panier moyen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesPerformance as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                <br><small>{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $user->role === 'responsable' ? 'badge-danger' : 'badge-primary' }}">
                                    {{ $user->role === 'responsable' ? 'Admin' : 'Pharmacien' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $user->sales_count }}</span>
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($user->total_sales_amount, 2) }} €</span>
                            </td>
                            <td class="text-right">{{ number_format($user->average_sale_amount, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td colspan="2">TOTAL</td>
                        <td class="text-center">{{ $salesPerformance->sum('sales_count') }}</td>
                        <td class="text-right">{{ number_format($salesPerformance->sum('total_sales_amount'), 2) }} €</td>
                        <td class="text-right">
                            {{ $salesPerformance->sum('sales_count') > 0 ? number_format($salesPerformance->sum('total_sales_amount') / $salesPerformance->sum('sales_count'), 2) : '0.00' }} €
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

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
                            <td><strong>Administrateurs</strong></td>
                            <td class="text-center">
                                <span class="badge badge-danger">{{ $adminUsers }}</span>
                            </td>
                            <td class="text-right">
                                @php $adminPercentage = $totalUsers > 0 ? ($adminUsers / $totalUsers) * 100 : 0; @endphp
                                <strong>{{ number_format($adminPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Pharmaciens</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $pharmacistUsers }}</span>
                            </td>
                            <td class="text-right">
                                @php $pharmacistPercentage = $totalUsers > 0 ? ($pharmacistUsers / $totalUsers) * 100 : 0; @endphp
                                <strong>{{ number_format($pharmacistPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Utilisateurs actifs</strong></td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $activeUsers }}</span>
                            </td>
                            <td class="text-right">
                                @php $activePercentage = $totalUsers > 0 ? ($activeUsers / $totalUsers) * 100 : 0; @endphp
                                <strong>{{ number_format($activePercentage, 1) }}%</strong>
                            </td>
                        </tr>
                         <tr>
                            <td><strong>MDP à changer</strong></td>
                            <td class="text-center">
                                <span class="badge badge-warning">{{ $usersNeedingPasswordChange }}</span>
                            </td>
                            <td class="text-right">
                                @php $passwordPercentage = $totalUsers > 0 ? ($usersNeedingPasswordChange / $totalUsers) * 100 : 0; @endphp
                                <strong>{{ number_format($passwordPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <div class="summary-box">
                    <h3>Points clés</h3>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li><strong>Taux d'activité :</strong> {{ number_format($activePercentage, 1) }}% des utilisateurs sont actifs</li>
                        <li><strong>Répartition rôles :</strong> {{ number_format($adminPercentage, 1) }}% admin, {{ number_format($pharmacistPercentage, 1) }}% pharmaciens</li>
                        @if($usersNeedingPasswordChange > 0)
                            <li><strong>Sécurité :</strong> {{ $usersNeedingPasswordChange }} utilisateur(s) doivent changer leur mot de passe</li>
                        @endif
                        @if($topUsersByActivity->count() > 0)
                            <li><strong>Utilisateur le plus actif :</strong> {{ $topUsersByActivity->first()->name }} ({{ $topUsersByActivity->first()->activity_count }} actions)</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="summary-box">
        <h3>Résumé exécutif</h3>
        <p><strong>Équipe :</strong> {{ $totalUsers }} utilisateurs au total, avec {{ $activeUsers }} actifs ({{ number_format($activePercentage, 1) }}%).</p>
        
        <p><strong>Composition :</strong> {{ $adminUsers }} administrateur(s) et {{ $pharmacistUsers }} pharmacien(s) 
           assurent le fonctionnement du système.</p>
        
        @if($salesPerformance->count() > 0)
            <p><strong>Performance commerciale :</strong> {{ $salesPerformance->sum('sales_count') }} ventes réalisées 
               pour un chiffre d'affaires total de {{ number_format($salesPerformance->sum('total_sales_amount'), 2) }} € 
               sur la période analysée.</p>
            
            @if($salesPerformance->first()->sales_count > 0)
                <p><strong>Meilleur vendeur :</strong> {{ $salesPerformance->first()->name }} 
                   ({{ number_format($salesPerformance->first()->total_sales_amount, 2) }} € de CA).</p>
            @endif
        @endif
        
        @if($usersNeedingPasswordChange > 0)
            <div class="highlight critical">
                <strong>🔐 SÉCURITÉ :</strong> {{ $usersNeedingPasswordChange }} utilisateur(s) doivent impérativement changer leur mot de passe.
            </div>
        @endif
        
        @if($totalUsers - $activeUsers > 0)
            <div class="highlight warning">
                <strong>⚠️ ATTENTION :</strong> {{ $totalUsers - $activeUsers }} utilisateur(s) inactif(s) pourraient nécessiter une réactivation ou suppression.
            </div>
        @endif
        
        @if($activePercentage >= 80)
            <div class="highlight success">
                <strong>✅ EXCELLENT :</strong> Très bon taux d'activité de l'équipe ({{ number_format($activePercentage, 1) }}%).
            </div>
        @endif
    </div>
@endsection