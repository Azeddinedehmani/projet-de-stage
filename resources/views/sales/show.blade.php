@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-receipt text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Vente {{ $sale->sale_number }}</h2>
                    <small class="text-muted">Détails de la transaction</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('sales.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux ventes
            </a>
            <a href="{{ route('sales.print', $sale->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;" target="_blank">
                <i class="fas fa-print me-1"></i> Imprimer
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Détails de la vente -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                        Détails de la vente
                    </h5>
                    <span class="badge rounded-pill {{ $sale->payment_status == 'paid' ? 'bg-success' : ($sale->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ ucfirst($sale->payment_status) }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Numéro de vente</h6>
                                <p class="mb-0 fs-5">{{ $sale->sale_number }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Date et heure</h6>
                                <p class="mb-0">
                                    <i class="fas fa-calendar me-2 text-primary"></i>{{ $sale->sale_date->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Vendeur</h6>
                                <p class="mb-0">
                                    <i class="fas fa-user-tie me-2 text-primary"></i>{{ $sale->user->name }}
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Client</h6>
                                <p class="mb-0">
                                    @if($sale->client)
                                        <i class="fas fa-user me-2 text-info"></i>
                                        <a href="{{ route('clients.show', $sale->client->id) }}" class="text-decoration-none fw-medium" style="color: #336699;">
                                            {{ $sale->client->full_name }}
                                        </a>
                                    @else
                                        <span class="text-muted fst-italic">Client anonyme</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Mode de paiement</h6>
                                <p class="mb-0">{{ ucfirst($sale->payment_method) }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Statut du paiement</h6>
                                <p class="mb-0">
                                    <span class="badge rounded-pill {{ $sale->payment_status == 'paid' ? 'bg-success' : ($sale->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ ucfirst($sale->payment_status) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Ordonnance</h6>
                                <p class="mb-0">
                                    @if($sale->has_prescription)
                                        <span class="badge bg-success rounded-pill">Oui</span>
                                        @if($sale->prescription_number)
                                            <br><small class="text-muted mt-1">{{ $sale->prescription_number }}</small>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Non</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Montant total</h6>
                                <p class="mb-0 text-success fw-bold fs-5">
                                    {{ number_format($sale->total_amount, 2) }} €
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($sale->notes)
                        <hr class="my-4">
                        <div>
                            <h6 class="fw-bold text-muted mb-2">Notes</h6>
                            <p class="mb-0 bg-light p-3 rounded" style="border-radius: 10px;">
                                <i class="fas fa-sticky-note me-2 text-warning"></i>{{ $sale->notes }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Produits vendus -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-pills me-2" style="color: #336699;"></i>
                        Produits vendus
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Prix unitaire</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleItems as $item)
                                    <tr class="{{ $item->product ? '' : 'deleted-product-row' }}">
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                @if($item->product)
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-pills text-white small"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $item->product->name }}</strong>
                                                        @if($item->product->dosage)
                                                            <br><small class="text-muted">{{ $item->product->dosage }}</small>
                                                        @endif
                                                        @if($item->product->prescription_required)
                                                            <br><small class="text-warning">
                                                                <i class="fas fa-prescription-bottle me-1"></i>
                                                                Ordonnance requise
                                                            </small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-trash text-white small"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="text-danger fst-italic">{{ $item->product_name ?? 'Produit supprimé' }}</strong>
                                                        <br><small class="text-danger">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Ce produit a été supprimé de l'inventaire
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-secondary rounded-pill">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end border-0">
                                            <strong class="text-success">{{ number_format($item->unit_price, 2) }} €</strong>
                                        </td>
                                        <td class="text-end border-0">
                                            <span class="badge bg-success rounded-pill fs-6">{{ number_format($item->total_price, 2) }} €</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <th colspan="3" class="text-end border-0" style="color: #336699;">Sous-total:</th>
                                    <th class="text-end border-0" style="color: #336699;">{{ number_format($sale->subtotal, 2) }} €</th>
                                </tr>
                                <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <th colspan="3" class="text-end border-0" style="color: #336699;">TVA ({{ number_format($sale->tax_rate, 1) }}%):</th>
                                    <th class="text-end border-0" style="color: #336699;">{{ number_format($sale->tax_amount, 2) }} €</th>
                                </tr>
                                @if($sale->discount_amount > 0)
                                    <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                        <th colspan="3" class="text-end border-0" style="color: #336699;">Remise:</th>
                                        <th class="text-end text-danger border-0">-{{ number_format($sale->discount_amount, 2) }} €</th>
                                    </tr>
                                @endif
                                <tr style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white;">
                                    <th colspan="3" class="text-end border-0" style="font-size: 1.1rem;">Total:</th>
                                    <th class="text-end border-0" style="font-size: 1.3rem;">{{ number_format($sale->total_amount, 2) }} €</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Résumé financier -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calculator me-2" style="color: #336699;"></i>
                        Résumé financier
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <h4 class="mb-1 fw-bold text-primary">{{ number_format($sale->total_amount, 2) }} €</h4>
                            <small class="text-muted">Montant total</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-1 fw-bold text-success">{{ $sale->saleItems->count() }}</h4>
                            <small class="text-muted">Articles vendus</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Sous-total:</span>
                            <span>{{ number_format($sale->subtotal, 2) }} €</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>TVA ({{ number_format($sale->tax_rate, 1) }}%):</span>
                            <span>{{ number_format($sale->tax_amount, 2) }} €</span>
                        </div>
                    </div>
                    @if($sale->discount_amount > 0)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between text-danger">
                                <span>Remise:</span>
                                <span>-{{ number_format($sale->discount_amount, 2) }} €</span>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold">
                        <span>Total:</span>
                        <span class="text-success">{{ number_format($sale->total_amount, 2) }} €</span>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sales.print', $sale->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;" target="_blank">
                            <i class="fas fa-print me-1"></i> Imprimer le reçu
                        </a>
                        
                        @if($sale->payment_status !== 'paid')
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px; color: #212529 !important;">
                                <i class="fas fa-edit me-1"></i> Modifier le statut
                            </a>
                        @endif
                        
                        @if($sale->client)
                            <a href="{{ route('clients.show', $sale->client->id) }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                                <i class="fas fa-user me-1"></i> Voir le client
                            </a>
                        @endif
                        
                        <a href="{{ route('sales.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-plus me-1"></i> Nouvelle vente
                        </a>
                        
                        @if($sale->sale_date >= now()->subDays(7) && Auth::user()->isAdmin())
                            <button type="button" class="btn text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteModal" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-trash me-1"></i> Supprimer la vente
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informations client -->
            @if($sale->client)
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #336699;">
                            <i class="fas fa-user-circle me-2"></i>
                            Informations client
                        </h6>
                        <div class="text-center mb-3">
                            <div class="mb-2" style="width: 40px; height: 40px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <strong class="fw-bold">{{ $sale->client->full_name }}</strong>
                        </div>
                        
                        @if($sale->client->phone)
                            <div class="mb-2">
                                <i class="fas fa-phone me-2" style="color: #336699;"></i>
                                <span>{{ $sale->client->phone }}</span>
                            </div>
                        @endif
                        
                        @if($sale->client->email)
                            <div class="mb-2">
                                <i class="fas fa-envelope me-2" style="color: #336699;"></i>
                                <span>{{ $sale->client->email }}</span>
                            </div>
                        @endif
                        
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Total dépensé:</span>
                            <strong class="text-success">{{ number_format($sale->client->total_spent ?? 0, 2) }} €</strong>
                        </div>
                        
                        @if($sale->client->allergies)
                            <div class="alert alert-warning border-0 mt-3" style="border-radius: 10px;">
                                <strong><i class="fas fa-exclamation-triangle me-1"></i>Allergies connues:</strong><br>
                                {{ $sale->client->allergies }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if($sale->sale_date >= now()->subDays(7) && Auth::user()->isAdmin())
    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning border-0" style="border-radius: 10px;">
                        <strong><i class="fas fa-exclamation-triangle me-1"></i>Attention!</strong>
                        Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer la vente <strong>{{ $sale->sale_number }}</strong>?</p>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white;">
                                    <strong>Informations de la vente</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0">
                                        <li><strong>Date :</strong> {{ $sale->sale_date->format('d/m/Y H:i') }}</li>
                                        <li><strong>Montant :</strong> {{ number_format($sale->total_amount, 2) }} € (TVA: {{ number_format($sale->tax_rate, 1) }}%)</li>
                                        <li><strong>Client :</strong> {{ $sale->client ? $sale->client->full_name : 'Anonyme' }}</li>
                                        <li><strong>Vendeur :</strong> {{ $sale->user->name }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
                                    <strong>Conséquences</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0 text-danger">
                                        <li>La vente sera définitivement supprimée</li>
                                        <li>Le stock des produits sera restauré</li>
                                        <li>Les données ne pourront pas être récupérées</li>
                                        <li>Cette action sera tracée dans les logs</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($sale->saleItems && $sale->saleItems->count() > 0)
                        <div class="card">
                            <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                <strong>Produits qui seront remis en stock</strong>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead style="background: #f8f9fa;">
                                            <tr>
                                                <th style="color: #336699;">Produit</th>
                                                <th class="text-center" style="color: #336699;">Quantité à remettre</th>
                                                <th class="text-center" style="color: #336699;">Stock actuel</th>
                                                <th class="text-center" style="color: #336699;">Nouveau stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sale->saleItems as $item)
                                                <tr class="{{ $item->product ? '' : 'deleted-product-row' }}">
                                                    <td>
                                                        @if($item->product)
                                                            {{ $item->product->name }}
                                                        @else
                                                            <span class="text-danger fst-italic">
                                                                {{ $item->product_name ?? 'Produit supprimé' }}
                                                                <i class="fas fa-exclamation-triangle ms-1"></i>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-warning text-dark">{{ $item->quantity }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($item->product)
                                                            {{ $item->product->stock_quantity }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($item->product)
                                                            <strong class="text-success" style="font-size: 1.1rem;">
                                                                {{ $item->product->stock_quantity + $item->quantity }}
                                                            </strong>
                                                       @else
                                                            <span class="text-muted">N/A</span>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display: inline;" 
                          onsubmit="return confirm('Êtes-vous absolument certain de vouloir supprimer cette vente ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn text-white" 
                                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                            <i class="fas fa-trash me-1"></i>Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

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
        transform: scale(1.005);
        transition: all 0.2s ease;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #336699;
        box-shadow: 0 0 0 0.2rem rgba(51, 102, 153, 0.25);
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .modal-content {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    /* Harmonisation avec le sidebar */
    .text-primary {
        color: #336699 !important;
    }
    
    .bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
    
    .btn-outline-primary {
        color: #336699;
        border-color: #336699;
    }
    
    .btn-outline-primary:hover {
        background-color: #336699;
        border-color: #336699;
    }
    
    /* Styles pour les lignes de produits supprimés */
    .deleted-product-row {
        background: rgba(220, 53, 69, 0.05) !important;
        border-left: 3px solid #dc3545 !important;
    }
    
    /* Animation pour les alertes */
    .alert {
        animation: slideInDown 0.5s ease;
    }
    
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Amélioration de l'accessibilité */
    .btn:focus {
        outline: 2px solid #336699;
        outline-offset: 2px;
    }
    
    .btn:focus:not(:focus-visible) {
        outline: none;
    }
    
    /* Styles pour les badges */
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .col-md-8, .col-md-4 {
            margin-bottom: 20px;
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .btn {
            padding: 10px 16px;
            font-size: 14px;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-body {
            padding: 20px 15px;
        }
    }
    
    @media (max-width: 576px) {
        .d-grid .btn {
            font-size: 0.9rem;
            padding: 10px;
        }
        
        .card-body {
            padding: 12px;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        .table th,
        .table td {
            padding: 8px 4px;
            font-size: 0.8rem;
        }
    }
    
    /* Animation pour les cartes */
    .card {
        border: none !important;
        border-radius: 15px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Styles pour les modales */
    .modal-header {
        border-bottom: none;
    }
    
    .modal-footer {
        border-top: none;
        padding-top: 0;
    }
    
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
    }
    
    /* Animation pour les boutons */
    .btn {
        position: relative;
        overflow: hidden;
    }
    
    .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.3s, height 0.3s;
    }
    
    .btn:active::after {
        width: 120%;
        height: 120%;
    }
    
    /* Styles pour les tableaux */
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 12px;
    }
    
    .table td {
        border-top: 1px solid #dee2e6;
        font-size: 0.875rem;
        padding: 12px;
        vertical-align: middle;
    }
    
    /* Amélioration des bordures */
    .border-0 {
        border: none !important;
    }
    
    /* Styles pour l'impression */
    @media print {
        .btn,
        .modal,
        .alert {
            display: none !important;
        }
        
        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
        }
        
        .table {
            font-size: 12px;
        }
        
        .table th,
        .table td {
            padding: 4px !important;
            border: 1px solid #000 !important;
        }
        
        body {
            background: white !important;
            color: black !important;
        }
        
        .badge {
            border: 1px solid #000;
            background: white !important;
            color: black !important;
        }
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar pour les tableaux */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #336699 0%, #4a90e2 100%);
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #2c5282 0%, #3182ce 100%);
    }
    
    /* Amélioration de la lisibilité */
    .table td {
        line-height: 1.4;
    }
    
    /* Animation pour les nouveaux éléments */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .card {
            background: rgba(33, 37, 41, 0.95) !important;
            color: #f8f9fa;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .table {
            color: #f8f9fa;
        }
        
        .table thead th {
            background-color: rgba(33, 37, 41, 0.9) !important;
            color: #f8f9fa;
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .table tbody td {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .text-muted {
            color: #adb5bd !important;
        }
        
        .modal-content {
            background: rgba(33, 37, 41, 0.95);
            color: #f8f9fa;
        }
        
        .alert {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour les cartes au chargement
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animation pour les alertes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            alert.style.transition = 'all 0.3s ease';
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        }, 100);
    });
    
    // Amélioration des boutons avec effet ripple
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Animation au survol des lignes du tableau
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Gestion de la modal de suppression
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function() {
            // Animation d'ouverture
            this.style.opacity = '0';
            setTimeout(() => {
                this.style.transition = 'opacity 0.3s ease';
                this.style.opacity = '1';
            }, 10);
        });
    }
    
    // Tooltip pour les badges
    const badges = document.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Animation smooth pour le scroll
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Lazy loading des images si présentes
    const images = document.querySelectorAll('img[data-src]');
    if (images.length > 0) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
    
    // Amélioration de l'accessibilité
    const focusableElements = document.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #336699';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
    
    // Gestion des erreurs réseau
    window.addEventListener('online', function() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x';
        alert.style.zIndex = '9999';
        alert.innerHTML = '<i class="fas fa-wifi me-2"></i>Connexion rétablie';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });
    
    window.addEventListener('offline', function() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-warning position-fixed top-0 start-50 translate-middle-x';
        alert.style.zIndex = '9999';
        alert.innerHTML = '<i class="fas fa-wifi-slash me-2"></i>Connexion perdue';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    });
});

// CSS pour l'effet ripple
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection