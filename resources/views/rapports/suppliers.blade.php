@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
   <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-truck text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport des fournisseurs</h2>
                <small class="text-muted">Analyse complète des partenaires et commandes</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.suppliers.pdf', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
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
            <form action="{{ route('reports.suppliers') }}" method="GET" class="row g-3">
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
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total fournisseurs</h6>
                            <h4 class="mb-0">{{ $totalSuppliers }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Fournisseurs actifs</h6>
                            <h4 class="mb-0">{{ $activeSuppliers }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Avec produits</h6>
                            <h4 class="mb-0">{{ $suppliersWithProducts }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Sans produits</h6>
                            <h4 class="mb-0">{{ $suppliersWithoutProducts }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle fa-2x" style="color: #212529;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Top fournisseurs par valeur de stock -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2" style="color: #336699;"></i>
                        Top fournisseurs par valeur de stock
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($suppliersByStockValue->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Rang</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Contact</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Nb produits</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Stock total</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">Valeur stock</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppliersByStockValue as $index => $supplier)
                                        <tr class="border-0">
                                            <td class="border-0">
                                                <span class="badge {{ $index < 3 ? 'bg-warning' : 'bg-secondary' }} rounded-pill">
                                                    #{{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td class="border-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%);">
                                                        <i class="fas fa-truck"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $supplier->name }}</strong>
                                                        @if($supplier->phone_number)
                                                            <br><small class="text-muted">{{ $supplier->phone_number }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <div>
                                                    {{ $supplier->contact_person ?? 'N/A' }}
                                                    @if($supplier->email)
                                                        <br><small class="text-muted">{{ $supplier->email }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-primary rounded-pill">{{ $supplier->products_count }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-info rounded-pill">{{ number_format($supplier->total_stock_quantity) }}</span>
                                            </td>
                                            <td class="text-end border-0">
                                                <strong style="color: #28a745;">{{ number_format($supplier->total_stock_value, 2) }} €</strong>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge {{ $supplier->active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                                    {{ $supplier->active ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background-color: #f8f9fa;">
                                    <tr>
                                        <th colspan="4" class="border-0 fw-bold">Total</th>
                                        <th class="text-center border-0 fw-bold">{{ number_format($suppliersByStockValue->sum('total_stock_quantity')) }}</th>
                                        <th class="text-end border-0 fw-bold">{{ number_format($suppliersByStockValue->sum('total_stock_value'), 2) }} €</th>
                                        <th class="border-0"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-truck fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucun fournisseur avec du stock</h5>
                            <p class="text-muted">Aucun fournisseur ne dispose actuellement de stock</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Commandes par fournisseur -->
            @if($purchasesBySupplier->count() > 0)
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Commandes par fournisseur (période sélectionnée)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Contact</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Nb commandes</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Total commandes</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Commande moyenne</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchasesBySupplier as $supplier)
                                    <tr class="border-0">
                                        <td class="border-0"><strong>{{ $supplier->name }}</strong></td>
                                        <td class="border-0">{{ $supplier->contact_person ?? 'N/A' }}</td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-primary rounded-pill">{{ $supplier->orders_count }}</span>
                                        </td>
                                        <td class="text-end border-0">
                                            <strong style="color: #28a745;">{{ number_format($supplier->total_amount, 2) }} €</strong>
                                        </td>
                                        <td class="text-end border-0">
                                            {{ number_format($supplier->average_amount, 2) }} €
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Commandes en retard -->
            @if($overduePurchases->count() > 0)
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Commandes en retard ({{ $overduePurchases->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">N° Commande</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Date commande</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Date prévue</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Montant</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Retard</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($overduePurchases as $purchase)
                                    <tr class="border-0 table-danger">
                                        <td class="border-0">
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('purchases.show', $purchase->id) }}" class="text-decoration-none fw-bold">
                                                    {{ $purchase->purchase_number }}
                                                </a>
                                            @else
                                                <strong>{{ $purchase->purchase_number }}</strong>
                                            @endif
                                        </td>
                                        <td class="border-0">{{ $purchase->supplier->name }}</td>
                                        <td class="border-0">{{ $purchase->order_date->format('d/m/Y') }}</td>
                                        <td class="border-0">{{ $purchase->expected_date->format('d/m/Y') }}</td>
                                        <td class="text-end border-0">{{ number_format($purchase->total_amount, 2) }} €</td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-danger rounded-pill">
                                                {{ $purchase->expected_date->diffInDays(now()) }} jour(s)
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Top par nombre de produits -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2" style="color: #336699;"></i>
                        Top par nombre de produits
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Produits</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSuppliersByProducts->take(10) as $supplier)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <div>
                                                <strong>{{ Str::limit($supplier->name, 20) }}</strong>
                                                <br><small class="text-muted">{{ $supplier->contact_person ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-primary rounded-pill">{{ $supplier->products_count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Performance des fournisseurs -->
            @if($supplierPerformance->count() > 0)
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2"></i>
                        Performance livraisons
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
<th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">À temps</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Retard moy.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplierPerformance->take(8) as $performance)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <div>
                                                <strong>{{ Str::limit($performance->supplier_name, 15) }}</strong>
                                                <br><small class="text-muted">{{ $performance->total_orders }} commande(s)</small>
                                            </div>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge {{ $performance->on_time_percentage >= 80 ? 'bg-success' : ($performance->on_time_percentage >= 60 ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill">
                                                {{ number_format($performance->on_time_percentage, 1) }}%
                                            </span>
                                        </td>
                                        <td class="text-center border-0">
                                            @if($performance->average_delay > 0)
                                                <span class="badge bg-warning text-dark rounded-pill">
                                                    {{ $performance->average_delay }} j
                                                </span>
                                            @else
                                                <span class="badge bg-success rounded-pill">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Fournisseurs avec stock faible -->
            @if($suppliersWithLowStock->count() > 0)
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Stock faible
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($suppliersWithLowStock->take(5) as $supplier)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(253, 126, 20, 0.1) 100%);">
                            <div>
                                <strong>{{ Str::limit($supplier->name, 18) }}</strong>
                                <br><small class="text-muted">{{ $supplier->contact_person ?? 'N/A' }}</small>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill">
                                {{ $supplier->low_stock_products_count }} produit(s)
                            </span>
                        </div>
                        @if(!$loop->last)<hr class="my-2">@endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Commandes en cours -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-clock me-2"></i>
                        Commandes en cours
                    </h5>
                </div>
                <div class="card-body">
                    @if($pendingPurchases->count() > 0)
                        @foreach($pendingPurchases->take(5) as $supplierName => $purchases)
                            <div class="mb-3 p-3 rounded" style="background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(19, 132, 150, 0.1) 100%);">
                                <h6 class="mb-2 fw-bold">{{ Str::limit($supplierName, 20) }}</h6>
                                @foreach($purchases as $purchase)
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-medium">{{ $purchase->purchase_number }}</small>
                                        <span class="badge bg-info rounded-pill">{{ number_format($purchase->total_amount, 0) }} €</span>
                                    </div>
                                @endforeach
                            </div>
                            @if(!$loop->last)<hr>@endif
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <div class="mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <p class="mb-0 fw-medium text-success">Aucune commande en cours</p>
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
                        <a href="{{ route('suppliers.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-truck me-2"></i>
                            Voir tous les fournisseurs
                        </a>
                        
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('suppliers.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-plus me-2"></i>
                                Ajouter un fournisseur
                            </a>
                            
                            <a href="{{ route('purchases.create') }}" class="btn text-dark fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Nouvelle commande
                            </a>
                            
                            <a href="{{ route('purchases.index', ['status' => 'pending']) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-clock me-2"></i>
                                Commandes en attente
                            </a>
                        @endif
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
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    /* Animation pour les lignes en retard */
    .table-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(200, 35, 51, 0.1) 100%) !important;
        animation: pulse-danger 3s infinite;
    }
    
    @keyframes pulse-danger {
        0% { background-color: rgba(220, 53, 69, 0.1); }
        50% { background-color: rgba(220, 53, 69, 0.2); }
        100% { background-color: rgba(220, 53, 69, 0.1); }
    }
    
    /* Effet glassmorphism pour les cartes */
    .card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Animation pour les avatars */
    .rounded-circle {
        transition: all 0.3s ease;
    }
    
    .rounded-circle:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 4px 15px rgba(51, 102, 153, 0.4);
    }
    
    /* Styles pour les commandes en cours */
    .card-body .mb-3 {
        transition: all 0.3s ease;
    }
    
    .card-body .mb-3:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Amélioration des performances des fournisseurs */
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        border-left: 4px solid #336699;
        padding-left: 1rem;
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
    }
    
    /* Animation pour les badges de performance */
    .badge.bg-success {
        animation: glow-success 3s infinite;
    }
    
    .badge.bg-danger {
        animation: glow-danger 3s infinite;
    }
    
    @keyframes glow-success {
        0%, 100% { box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
        50% { box-shadow: 0 0 15px rgba(40, 167, 69, 0.8); }
    }
    
    @keyframes glow-danger {
        0%, 100% { box-shadow: 0 0 5px rgba(220, 53, 69, 0.5); }
        50% { box-shadow: 0 0 15px rgba(220, 53, 69, 0.8); }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
        const finalValue = parseInt(text.replace(/[^\d]/g, ''));
        
        if (finalValue && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 30;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    current = finalValue;
                    clearInterval(timer);
                }
                number.textContent = Math.floor(current) + (text.includes('€') ? ' €' : '');
            }, 50);
        }
    });
    
    // Animation pour les badges de rang
    const rankBadges = document.querySelectorAll('.badge.bg-warning');
    rankBadges.forEach(badge => {
        if (badge.textContent.includes('#')) {
            badge.style.animation = 'shine 3s infinite';
        }
    });
    
    // Ajout de l'animation CSS pour l'effet brillant
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shine {
            0% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
            50% { box-shadow: 0 0 20px rgba(255, 193, 7, 0.8), 0 0 30px rgba(255, 193, 7, 0.6); }
            100% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
        }
    `;
    document.head.appendChild(style);
    
    // Interaction avec les lignes de commandes en retard
    const overdueRows = document.querySelectorAll('.table-danger');
    overdueRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.borderLeft = '5px solid #dc3545';
            this.style.paddingLeft = '1.5rem';
            this.style.boxShadow = '0 4px 15px rgba(220, 53, 69, 0.3)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.borderLeft = 'none';
            this.style.paddingLeft = '0.75rem';
            this.style.boxShadow = 'none';
        });
    });
    
    // Animation pour les commandes en cours
    const pendingOrders = document.querySelectorAll('.card-body .mb-3');
    pendingOrders.forEach(order => {
        order.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px) scale(1.02)';
            this.style.backgroundColor = 'rgba(23, 162, 184, 0.15)';
        });
        
        order.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
            this.style.backgroundColor = 'rgba(23, 162, 184, 0.1)';
        });
    });
    
    // Tooltip pour les badges de performance
    const performanceBadges = document.querySelectorAll('.badge.bg-success, .badge.bg-warning, .badge.bg-danger');
    performanceBadges.forEach(badge => {
        if (badge.textContent.includes('%')) {
            badge.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.2)';
                this.style.zIndex = '10';
            });
            
            badge.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = 'auto';
            });
        }
    });
    
    // Animation pour les avatars de fournisseurs
    const supplierAvatars = document.querySelectorAll('.rounded-circle');
    supplierAvatars.forEach(avatar => {
        avatar.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(45deg, #336699 0%, #4a90e2 50%, #20c997 100%)';
        });
        
        avatar.addEventListener('mouseleave', function() {
            this.style.background = 'linear-gradient(180deg, #336699 0%, #4a90e2 100%)';
        });
    });
    
    // Interaction avec les liens d'actions rapides
    const actionLinks = document.querySelectorAll('.d-grid .btn');
    actionLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.2)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-1px) scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';
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
    
    // Observer tous les éléments de tableau
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'all 0.6s ease';
        observer.observe(row);
    });
});
</script>
@endsection