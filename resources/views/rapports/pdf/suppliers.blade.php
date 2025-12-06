@extends('rapports.pdf.base')

@section('title', 'Rapport des Fournisseurs')
@section('report-type', 'Rapport des Fournisseurs')
@section('subtitle', 'Analyse complète des partenaires et commandes')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="value">{{ $totalSuppliers }}</div>
            <div class="label">Total fournisseurs</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $activeSuppliers }}</div>
            <div class="label">Fournisseurs actifs</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $suppliersWithProducts }}</div>
            <div class="label">Avec produits</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $suppliersWithoutProducts }}</div>
            <div class="label">Sans produits</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Top fournisseurs par valeur de stock</h2>
        @if($suppliersByStockValue->count() > 0)
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Fournisseur</th>
                        <th>Contact</th>
                        <th class="text-center">Nb produits</th>
                        <th class="text-center">Stock total</th>
                        <th class="text-right">Valeur stock</th>
                        <th class="text-center">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliersByStockValue as $index => $supplier)
                        <tr>
                            <td class="text-center">
                                <span class="rank {{ $index < 3 ? 'top-3' : '' }}">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <strong>{{ $supplier->name }}</strong>
                                @if($supplier->phone_number)
                                    <br><small>{{ $supplier->phone_number }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $supplier->contact_person ?? 'N/A' }}
                                @if($supplier->email)
                                    <br><small>{{ $supplier->email }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $supplier->products_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ number_format($supplier->total_stock_quantity) }}</span>
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($supplier->total_stock_value, 2) }} €</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $supplier->active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $supplier->active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td colspan="4">TOTAL</td>
                        <td class="text-center">{{ number_format($suppliersByStockValue->sum('total_stock_quantity')) }}</td>
                        <td class="text-right">{{ number_format($suppliersByStockValue->sum('total_stock_value'), 2) }} €</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">Aucun fournisseur avec du stock</div>
        @endif
    </div>

    @if($purchasesBySupplier->count() > 0)
        <div class="section">
            <h2 class="section-title">Commandes par fournisseur (période sélectionnée)</h2>
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Fournisseur</th>
                        <th>Contact</th>
                        <th class="text-center">Nb commandes</th>
                        <th class="text-right">Total commandes</th>
                        <th class="text-right">Commande moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchasesBySupplier as $supplier)
                        <tr>
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $supplier->orders_count }}</span>
                            </td>
                            <td class="text-right">
                                <span class="amount">{{ number_format($supplier->total_amount, 2) }} €</span>
                            </td>
                            <td class="text-right">{{ number_format($supplier->average_amount, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8f9fa; font-weight: bold;">
                    <tr>
                        <td colspan="2">TOTAL</td>
                        <td class="text-center">{{ $purchasesBySupplier->sum('orders_count') }}</td>
                        <td class="text-right">{{ number_format($purchasesBySupplier->sum('total_amount'), 2) }} €</td>
                        <td class="text-right">
                            {{ $purchasesBySupplier->sum('orders_count') > 0 ? number_format($purchasesBySupplier->sum('total_amount') / $purchasesBySupplier->sum('orders_count'), 2) : '0.00' }} €
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
                            <td><strong>Fournisseurs actifs</strong></td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $activeSuppliers }}</span>
                            </td>
                            <td class="text-right">
                                @php $activePercentage = $totalSuppliers > 0 ? ($activeSuppliers / $totalSuppliers) * 100 : 0; @endphp
                                <strong>{{ number_format($activePercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Avec produits en stock</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $suppliersWithProducts }}</span>
                            </td>
                            <td class="text-right">
                                @php $withProductsPercentage = $totalSuppliers > 0 ? ($suppliersWithProducts / $totalSuppliers) * 100 : 0; @endphp
                                <strong>{{ number_format($withProductsPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Sans produits</strong></td>
                            <td class="text-center">
                                <span class="badge badge-warning">{{ $suppliersWithoutProducts }}</span>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format(100 - $withProductsPercentage, 1) }}%</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <div class="summary-box">
                    <h3>Points clés</h3>
                    <ul style="margin: 0; padding-left: 20px;">
                        <li><strong>Taux d'activité :</strong> {{ number_format($activePercentage, 1) }}% des fournisseurs sont actifs</li>
                        <li><strong>Couverture produits :</strong> {{ number_format($withProductsPercentage, 1) }}% ont des produits référencés</li>
                        @if($suppliersByStockValue->count() > 0)
                            <li><strong>Principal fournisseur :</strong> {{ $suppliersByStockValue->first()->name }}</li>
                            <li><strong>Valeur stock totale :</strong> {{ number_format($suppliersByStockValue->sum('total_stock_value'), 2) }} €</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="summary-box">
        <h3>Résumé exécutif</h3>
        <p><strong>Réseau fournisseurs :</strong> {{ $totalSuppliers }} fournisseurs au total, dont {{ $activeSuppliers }} actifs ({{ number_format($activePercentage, 1) }}%).</p>
        
        <p><strong>Couverture produits :</strong> {{ $suppliersWithProducts }} fournisseurs ({{ number_format($withProductsPercentage, 1) }}%) 
           disposent de produits référencés dans le système.</p>
        
        @if($suppliersByStockValue->count() > 0)
            <p><strong>Performance du leader :</strong> {{ $suppliersByStockValue->first()->name }} 
               représente {{ number_format(($suppliersByStockValue->first()->total_stock_value / $suppliersByStockValue->sum('total_stock_value')) * 100, 1) }}% 
               de la valeur totale du stock fournisseur.</p>
        @endif
        
        @if($purchasesBySupplier->count() > 0)
            <p><strong>Activité commandes :</strong> {{ $purchasesBySupplier->sum('orders_count') }} commandes 
               pour un montant total de {{ number_format($purchasesBySupplier->sum('total_amount'), 2) }} € 
               sur la période analysée.</p>
        @endif
        
        @if($suppliersWithoutProducts > 0)
            <div class="highlight warning">
                <strong>Attention :</strong> {{ $suppliersWithoutProducts }} fournisseur(s) sans produits référencés pourraient nécessiter une mise à jour.
            </div>
        @endif
    </div>
@endsection