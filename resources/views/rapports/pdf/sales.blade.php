@extends('rapports.pdf.base')
@section('title', 'Rapport des Ventes')
@section('report-type', 'Rapport des Ventes')
@section('subtitle', 'Analyse complète des performances commerciales')
@section('content')
    <!-- Statistiques générales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value amount">{{ number_format($totalSales, 2) }} €</div>
            <div class="label">Chiffre d'affaires</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ number_format($totalTransactions) }}</div>
            <div class="label">Nombre de ventes</div>
        </div>
        <div class="stat-card">
            <div class="value amount">{{ number_format($averageTransaction, 2) }} €</div>
            <div class="label">Panier moyen</div>
        </div>
    </div>

    <!-- Top produits vendus -->
    <div class="section">
        <h2 class="section-title">Top 10 des produits vendus</h2>
        @if($topProducts->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Produit</th>
                        <th class="text-center">Quantité vendue</th>
                        <th class="text-right">Chiffre d'affaires</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $index => $product)
                        <tr>
                            <td class="text-center">
                                <span class="rank {{ $index < 3 ? 'top-3' : '' }}">{{ $index + 1 }}</span>
                            </td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $product->total_quantity }}</span>
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($product->total_revenue, 2) }} €</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                Aucune vente enregistrée pour cette période
            </div>
        @endif
    </div>

    <!-- Ventes par utilisateur -->
    <div class="section">
        <h2 class="section-title">Performance des vendeurs</h2>
        @if($salesByUser->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Vendeur</th>
                        <th class="text-right">Chiffre d'affaires</th>
                        <th class="text-center">Nombre de ventes</th>
                        <th class="text-right">Panier moyen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesByUser as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($user->total_sales, 2) }} €</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $user->total_transactions }}</span>
                            </td>
                            <td class="text-right">
                                {{ number_format($user->total_transactions > 0 ? $user->total_sales / $user->total_transactions : 0, 2) }} €
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-right">{{ number_format($salesByUser->sum('total_sales'), 2) }} €</td>
                        <td class="text-center">{{ $salesByUser->sum('total_transactions') }}</td>
                        <td class="text-right">
                            {{ $salesByUser->sum('total_transactions') > 0 ? number_format($salesByUser->sum('total_sales') / $salesByUser->sum('total_transactions'), 2) : '0.00' }} €
                        </td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">
                Aucune donnée de vente par utilisateur
            </div>
        @endif
    </div>

    <!-- Modes de paiement -->
    <div class="section">
        <h2 class="section-title">Répartition par mode de paiement</h2>
        @if($salesByPaymentMethod->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Mode de paiement</th>
                        <th class="text-right">Montant total</th>
                        <th class="text-center">Nombre de transactions</th>
                        <th class="text-right">Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAmount = $salesByPaymentMethod->sum('total'); @endphp
                    @foreach($salesByPaymentMethod as $payment)
                        <tr>
                            <td>
                                @switch($payment->payment_method)
                                    @case('cash')
                                        <span class="badge badge-success">Espèces</span>
                                        @break
                                    @case('card')
                                        <span class="badge badge-primary">Carte</span>
                                        @break
                                    @case('insurance')
                                        <span class="badge badge-info">Assurance</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ ucfirst($payment->payment_method) }}</span>
                                @endswitch
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($payment->total, 2) }} €</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{ $payment->count }}</span>
                            </td>
                            <td class="text-right">
                                <strong>{{ $totalAmount > 0 ? number_format(($payment->total / $totalAmount) * 100, 1) : 0 }}%</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-right">{{ number_format($totalAmount, 2) }} €</td>
                        <td class="text-center">{{ $salesByPaymentMethod->sum('count') }}</td>
                        <td class="text-right">100%</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">
                Aucune donnée de paiement disponible
            </div>
        @endif
    </div>

    <!-- Résumé exécutif -->
    <div class="summary-box">
        <h3>Résumé exécutif</h3>
        <p><strong>Performance globale :</strong> 
            @if($totalSales > 0)
                Le chiffre d'affaires s'élève à {{ number_format($totalSales, 2) }} € 
                réalisé sur {{ $totalTransactions }} transactions, 
                soit un panier moyen de {{ number_format($averageTransaction, 2) }} €.
            @else
                Aucune vente enregistrée pour cette période.
            @endif
        </p>
        
        @if($topProducts->count() > 0)
            <p><strong>Produit phare :</strong> 
                {{ $topProducts->first()->name }} avec {{ $topProducts->first()->total_quantity }} unités vendues 
                pour un CA de {{ number_format($topProducts->first()->total_revenue, 2) }} €.
            </p>
        @endif
        
        @if($salesByUser->count() > 0)
            <p><strong>Meilleur vendeur :</strong> 
                {{ $salesByUser->first()->name }} avec {{ number_format($salesByUser->first()->total_sales, 2) }} € 
                de chiffre d'affaires sur {{ $salesByUser->first()->total_transactions }} vente(s).
            </p>
        @endif
    </div>
@endsection