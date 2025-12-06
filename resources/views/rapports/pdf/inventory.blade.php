@extends('rapports.pdf.base')
@section('title', 'Rapport d\'Inventaire')
@section('report-type', 'Rapport d\'Inventaire')
@section('subtitle', 'Analyse complète du stock et des produits')

@section('content')
    <!-- Statistiques générales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ number_format($totalProducts) }}</div>
            <div class="label">Total produits</div>
        </div>
        <div class="stat-card">
            <div class="value amount">{{ number_format($totalStockValue, 0) }} €</div>
            <div class="label">Valeur du stock</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ number_format($averageStockLevel, 1) }}</div>
            <div class="label">Stock moyen</div>
        </div>
    </div>

    <!-- Produits avec stock faible -->
    <div class="section">
        <h2 class="section-title">Produits avec stock faible ({{ $lowStockProducts->count() }})</h2>
        @if($lowStockProducts->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Fournisseur</th>
                        <th class="text-center">Stock actuel</th>
                        <th class="text-center">Seuil</th>
                        <th class="text-center">Criticité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                        <tr class="{{ $product->stock_quantity == 0 ? 'critical' : 'warning' }}">
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->dosage)
                                    <br><small>{{ $product->dosage }}</small>
                                @endif
                            </td>
                            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                            <td>{{ $product->supplier ? $product->supplier->name : 'N/A' }}</td>
                            <td class="text-center">
                                @if($product->stock_quantity == 0)
                                    <span class="badge badge-danger">0</span>
                                @else
                                    <span class="badge badge-warning">{{ $product->stock_quantity }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{ $product->stock_threshold }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $criticityLevel = $product->stock_quantity == 0 ? 'URGENT' : 
                                                    ($product->stock_quantity <= $product->stock_threshold * 0.5 ? 'ÉLEVÉ' : 'MOYEN');
                                    $criticityClass = $product->stock_quantity == 0 ? 'badge-danger' : 
                                                    ($product->stock_quantity <= $product->stock_threshold * 0.5 ? 'badge-warning' : 'badge-info');
                                @endphp
                                <span class="badge {{ $criticityClass }}">{{ $criticityLevel }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data success">
                Excellent ! Tous les produits ont un niveau de stock suffisant.
            </div>
        @endif
    </div>

    <!-- Produits qui expirent bientôt -->
    <div class="section">
        <h2 class="section-title">Produits expirant dans 30 jours ({{ $expiringProducts->count() }})</h2>
        @if($expiringProducts->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th class="text-center">Stock</th>
                        <th>Date d'expiration</th>
                        <th class="text-center">Jours restants</th>
                        <th class="text-right">Valeur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expiringProducts as $product)
                        @php
                            $daysLeft = $product->expiry_date->diffInDays(now());
                            $urgencyClass = $daysLeft <= 7 ? 'critical' : ($daysLeft <= 15 ? 'warning' : '');
                        @endphp
                        <tr class="{{ $urgencyClass }}">
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->dosage)
                                    <br><small>{{ $product->dosage }}</small>
                                @endif
                            </td>
                            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $product->stock_quantity }}</span>
                            </td>
                            <td>{{ $product->expiry_date->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($daysLeft <= 7)
                                    <span class="badge badge-danger">{{ $daysLeft }} jour(s)</span>
                                @elseif($daysLeft <= 15)
                                    <span class="badge badge-warning">{{ $daysLeft }} jours</span>
                                @else
                                    <span class="badge badge-info">{{ $daysLeft }} jours</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($product->stock_quantity * $product->purchase_price, 2) }} €</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data success">
                Parfait ! Aucun produit n'expire dans les 30 prochains jours.
            </div>
        @endif
    </div>

    <!-- Valeur par catégorie -->
    @if($categoriesValue->count() > 0)
        <div class="section page-break">
            <h2 class="section-title">Répartition du stock par catégorie</h2>
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th class="text-center">Quantité totale</th>
                        <th class="text-right">Valeur totale</th>
                        <th class="text-right">% du stock total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categoriesValue as $category)
                        <tr>
                            <td><strong>{{ $category->category_name }}</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ number_format($category->total_quantity) }}</span>
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($category->total_value, 2) }} €</span>
                            </td>
                            <td class="text-right">
                                @php
                                    $percentage = $totalStockValue > 0 ? ($category->total_value / $totalStockValue) * 100 : 0;
                                @endphp
                                <span class="badge badge-info">{{ number_format($percentage, 1) }}%</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-center">{{ number_format($categoriesValue->sum('total_quantity')) }}</td>
                        <td class="text-right">{{ number_format($totalStockValue, 2) }} €</td>
                        <td class="text-right">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <!-- Alertes et recommandations -->
    <div class="summary-box">
        <h3>Alertes et recommandations</h3>
        
        @if($lowStockProducts->where('stock_quantity', 0)->count() > 0)
            <div class="highlight critical">
                <strong>⚠️ URGENT :</strong> {{ $lowStockProducts->where('stock_quantity', 0)->count() }} produit(s) en rupture de stock totale.
            </div>
        @endif
        
        @if($lowStockProducts->where('stock_quantity', '>', 0)->count() > 0)
            <div class="highlight warning">
                <strong>⚡ ATTENTION :</strong> {{ $lowStockProducts->where('stock_quantity', '>', 0)->count() }} produit(s) avec stock faible nécessitent un réapprovisionnement.
            </div>
        @endif
        
        @if($expiringProducts->where('expiry_date', '<=', now()->addDays(7))->count() > 0)
            <div class="highlight critical">
                <strong>📅 URGENT :</strong> {{ $expiringProducts->where('expiry_date', '<=', now()->addDays(7))->count() }} produit(s) expirent dans les 7 prochains jours.
            </div>
        @endif
        
        @if($lowStockProducts->count() == 0 && $expiringProducts->count() == 0)
            <div class="highlight success">
                <strong>✅ EXCELLENT :</strong> Aucune alerte d'inventaire. Tous les stocks sont à un niveau optimal.
            </div>
        @endif
        
        <p><strong>Valeur totale du stock :</strong> {{ number_format($totalStockValue, 2) }} € répartie sur {{ $totalProducts }} produits différents.</p>
        
        @if($categoriesValue->count() > 0)
            <p><strong>Catégorie principale :</strong> {{ $categoriesValue->first()->category_name }} représente {{ number_format(($categoriesValue->first()->total_value / $totalStockValue) * 100, 1) }}% de la valeur totale du stock.</p>
        @endif
    </div>
@endsection