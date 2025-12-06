@extends('rapports.pdf.base')
@section('title', 'Rapport Financier')
@section('report-type', 'Rapport Financier')
@section('subtitle', 'Analyse complète des performances financières')
@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value amount">{{ number_format($revenue, 2) }} €</div>
            <div class="label">Revenus</div>
        </div>
        <div class="stat-card">
            <div class="value amount negative">{{ number_format($expenses, 2) }} €</div>
            <div class="label">Dépenses</div>
        </div>
        <div class="stat-card">
            <div class="value amount {{ $profit >= 0 ? '' : 'negative' }}">{{ number_format(abs($profit), 2) }} €</div>
            <div class="label">{{ $profit >= 0 ? 'Bénéfice' : 'Perte' }}</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Top 20 - Marges par produit</h2>
        @if($productMargins->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-center">Qté vendue</th>
                        <th class="text-right">CA</th>
                        <th class="text-right">Coût</th>
                        <th class="text-right">Marge</th>
                        <th class="text-center">% Marge</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productMargins as $product)
                        @php
                            $marginPercent = $product->total_cost > 0 ? (($product->total_margin / $product->total_cost) * 100) : 0;
                        @endphp
                        <tr>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $product->total_sold }}</span>
                            </td>
                            <td class="text-right">{{ number_format($product->total_revenue, 2) }} €</td>
                            <td class="text-right">{{ number_format($product->total_cost, 2) }} €</td>
                            <td class="text-right">
                                <span class="amount {{ $product->total_margin >= 0 ? '' : 'negative' }}">
                                    {{ number_format($product->total_margin, 2) }} €
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $marginPercent >= 50 ? 'badge-success' : ($marginPercent >= 25 ? 'badge-warning' : 'badge-danger') }}">
                                    {{ number_format($marginPercent, 1) }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-center">{{ $productMargins->sum('total_sold') }}</td>
                        <td class="text-right">{{ number_format($productMargins->sum('total_revenue'), 2) }} €</td>
                        <td class="text-right">{{ number_format($productMargins->sum('total_cost'), 2) }} €</td>
                        <td class="text-right">{{ number_format($productMargins->sum('total_margin'), 2) }} €</td>
                        <td class="text-center">
                            @php
                                $totalMarginPercent = $productMargins->sum('total_cost') > 0 ? 
                                    (($productMargins->sum('total_margin') / $productMargins->sum('total_cost')) * 100) : 0;
                            @endphp
                            {{ number_format($totalMarginPercent, 1) }}%
                        </td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">Aucune donnée de marge pour cette période</div>
        @endif
    </div>

    <!-- Indicateurs de performance -->
    <div class="section">
        <h2 class="section-title">Indicateurs clés de performance</h2>
        <div class="two-column">
            <div>
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>Indicateur</th>
                            <th class="text-right">Valeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Marge nette</strong></td>
                            <td class="text-right">
                                @php $profitMargin = $revenue > 0 ? ($profit / $revenue) * 100 : 0; @endphp
                                <span class="badge {{ $profitMargin >= 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ number_format($profitMargin, 1) }}%
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>ROI (Retour sur investissement)</strong></td>
                            <td class="text-right">
                                @php $roi = $expenses > 0 ? ($profit / $expenses) * 100 : 0; @endphp
                                <span class="badge {{ $roi >= 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ number_format($roi, 1) }}%
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ $profit >= 0 ? 'Bénéfice' : 'Perte' }} par jour</strong></td>
                            <td class="text-right">
                                @php
                                    $profitPerDay = $profit / max(1, \Carbon\Carbon::parse($dateFrom)->diffInDays(\Carbon\Carbon::parse($dateTo)) + 1);
                                @endphp
                                <span class="amount {{ $profitPerDay >= 0 ? '' : 'negative' }}">
                                    {{ number_format($profitPerDay, 0) }} €
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <div class="summary-box">
                    <h3>Analyse des marges</h3>
                    @if($productMargins->count() > 0)
                        @php
                            $highMarginProducts = $productMargins->filter(function($product) {
                                return $product->total_cost > 0 && (($product->total_margin / $product->total_cost) * 100) >= 50;
                            })->count();
                            $lowMarginProducts = $productMargins->filter(function($product) {
                                return $product->total_cost > 0 && (($product->total_margin / $product->total_cost) * 100) < 25;
                            })->count();
                        @endphp
                        <ul style="margin: 0; padding-left: 20px;">
                            <li><strong>Marge élevée (≥50%) :</strong> {{ $highMarginProducts }} produit(s)</li>
                            <li><strong>Marge moyenne (25-50%) :</strong> {{ $productMargins->count() - $highMarginProducts - $lowMarginProducts }} produit(s)</li>
                            <li><strong>Marge faible (<25%) :</strong> {{ $lowMarginProducts }} produit(s)</li>
                        </ul>
                    @else
                        <p><em>Pas de données de marge disponibles</em></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recommandations -->
    <div class="summary-box">
        <h3>Résumé exécutif et recommandations</h3>
        <p><strong>Performance globale :</strong> 
            Revenus de {{ number_format($revenue, 2) }} € pour des dépenses de {{ number_format($expenses, 2) }} €, 
            générant un {{ $profit >= 0 ? 'bénéfice' : 'déficit' }} de {{ number_format(abs($profit), 2) }} €.
        </p>
        
        @if($profit < 0)
            <div class="highlight critical">
                <strong>⚠️ ALERTE :</strong> Période déficitaire de {{ number_format(abs($profit), 2) }} €. 
                Analyse urgente des coûts recommandée.
            </div>
        @endif
        
        @if($profitMargin < 10 && $profit >= 0)
            <div class="highlight warning">
                <strong>⚡ ATTENTION :</strong> Marge nette faible ({{ number_format($profitMargin, 1) }}%). 
                Optimisation des prix de vente recommandée.
            </div>
        @endif
        
        @if($productMargins->where('total_margin', '<', 0)->count() > 0)
            <div class="highlight warning">
                <strong>📊 VIGILANCE :</strong> {{ $productMargins->where('total_margin', '<', 0)->count() }} produit(s) 
                à marge négative nécessitent une révision tarifaire.
            </div>
        @endif
        
        @if($profit >= 0 && $profitMargin >= 15)
            <div class="highlight success">
                <strong>✅ EXCELLENT :</strong> Performance financière optimale avec une marge nette de {{ number_format($profitMargin, 1) }}%.
            </div>
        @endif
        
        @if($productMargins->count() > 0)
            <p><strong>Produit le plus rentable :</strong> 
                {{ $productMargins->sortByDesc('total_margin')->first()->name }} 
                (marge : {{ number_format($productMargins->sortByDesc('total_margin')->first()->total_margin, 2) }} €)
            </p>
        @endif
    </div>
@endsection