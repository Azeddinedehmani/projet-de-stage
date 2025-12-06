@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-pills text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">{{ $product->name }}</h2>
                    <small class="text-muted">
                        @if($product->prescription_required)
                            <span class="badge bg-info rounded-pill me-2">
                                <i class="fas fa-prescription-bottle me-1"></i>Ordonnance requise
                            </span>
                        @endif
                        {{ $product->category ? $product->category->name : 'Sans catégorie' }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('inventory.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('inventory.edit', $product->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                        <i class="fas fa-edit me-1"></i> Modifier
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Image et statut principal -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-fluid rounded mb-3" 
                                     style="max-height: 300px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 15px;">
                            @else
                                <div class="d-flex align-items-center justify-content-center mb-3" 
                                     style="height: 300px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                    <i class="fas fa-pills fa-5x text-muted"></i>
                                </div>
                            @endif
                            
                            <!-- Statut du stock principal -->
                            <div class="text-center">
                                @if($product->isOutOfStock())
                                    <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px;">
                                        <i class="fas fa-times-circle me-1"></i>Rupture de stock
                                    </span>
                                    <div class="mt-2 text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Action requise !
                                    </div>
                                @elseif($product->isLowStock())
                                    <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Stock faible
                                    </span>
                                    <div class="mt-2 text-warning">
                                        <strong>{{ $product->stock_quantity }}</strong> unité(s) restante(s)
                                    </div>
                                @else
                                    <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 15px;">
                                        <i class="fas fa-check-circle me-1"></i>Stock normal
                                    </span>
                                    <div class="mt-2 text-success">
                                        <strong>{{ $product->stock_quantity }}</strong> unité(s) disponible(s)
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <!-- Informations principales -->
                            <h4 class="fw-bold mb-3" style="color: #2c3e50;">{{ $product->name }}</h4>
                            
                            @if($product->description)
                                <div class="mb-4 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; border-left: 4px solid #336699;">
                                    <h6 class="fw-bold text-muted mb-2">Description</h6>
                                    <p class="mb-0">{{ $product->description }}</p>
                                </div>
                            @endif
                            
                            <!-- Badges d'information -->
                            <div class="mb-3">
                                @if($product->dosage)
                                    <span class="badge bg-primary rounded-pill me-2">{{ $product->dosage }}</span>
                                @endif
                                @if($product->prescription_required)
                                    <span class="badge bg-warning text-dark rounded-pill me-2">
                                        <i class="fas fa-prescription-bottle me-1"></i>Ordonnance
                                    </span>
                                @endif
                                @if($product->barcode)
                                    <span class="badge bg-secondary rounded-pill">{{ $product->barcode }}</span>
                                @endif
                            </div>
                            
                            <!-- Prix visible selon le rôle -->
                            <div class="row">
                                @if(auth()->user()->isAdmin())
                                    <div class="col-md-6">
                                        <div class="text-center p-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 10px;">
                                            <h6 class="mb-1">Prix d'achat</h6>
                                            <h4 class="mb-0">{{ number_format($product->purchase_price, 2) }} €</h4>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-{{ auth()->user()->isAdmin() ? '6' : '12' }}">
                                    <div class="text-center p-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 10px;">
                                        <h6 class="mb-1">Prix de vente</h6>
                                        <h4 class="mb-0">{{ number_format($product->selling_price, 2) }} €</h4>
                                    </div>
                                </div>
                            </div>
                            
                            @if(auth()->user()->isAdmin())
                                <!-- Marge (admin seulement) -->
                                <div class="mt-3 text-center p-2" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border-radius: 10px;">
                                    @php
                                        $margin = $product->selling_price - $product->purchase_price;
                                        $marginPercent = $product->purchase_price > 0 ? ($margin / $product->purchase_price) * 100 : 0;
                                    @endphp
                                    <small>Marge : <strong>{{ number_format($margin, 2) }} € ({{ number_format($marginPercent, 2) }}%)</strong></small>
                                </div>
                            @else
                                <div class="mt-3 text-center p-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border-radius: 10px;">
                                    <small><i class="fas fa-lock me-1"></i>Prix d'achat et marge : accès réservé aux responsables</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails techniques -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                        Informations détaillées
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted mb-3">Informations générales</h6>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-tags me-2 text-muted"></i>Catégorie</span>
                                    <span class="badge bg-light text-dark rounded-pill">{{ $product->category ? $product->category->name : 'N/A' }}</span>
                                </div>
                                @if($product->dosage)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                        <span><i class="fas fa-pills me-2 text-muted"></i>Dosage</span>
                                        <span>{{ $product->dosage }}</span>
                                    </div>
                                @endif
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-barcode me-2 text-muted"></i>Code-barres</span>
                                    <span class="font-monospace">{{ $product->barcode ?? 'N/A' }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-map-marker-alt me-2 text-muted"></i>Emplacement</span>
                                    <span>{{ $product->location ?? 'Non défini' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted mb-3">Stock et seuils</h6>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-boxes me-2 text-muted"></i>Stock actuel</span>
                                    @if($product->isOutOfStock())
                                        <span class="badge bg-danger fs-6 rounded-pill">{{ $product->stock_quantity }}</span>
                                    @elseif($product->isLowStock())
                                        <span class="badge bg-warning text-dark fs-6 rounded-pill">{{ $product->stock_quantity }}</span>
                                    @else
                                        <span class="badge bg-success fs-6 rounded-pill">{{ $product->stock_quantity }}</span>
                                    @endif
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span><i class="fas fa-bell me-2 text-muted"></i>Seuil d'alerte</span>
                                    <span class="badge bg-info rounded-pill">{{ $product->stock_threshold }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-prescription-bottle me-2 text-muted"></i>Ordonnance</span>
                                    @if($product->prescription_required)
                                        <span class="badge bg-warning text-dark rounded-pill">Requise</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">Non requise</span>
                                    @endif
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span><i class="fas fa-calendar me-2 text-muted"></i>Date d'expiration</span>
                                    @if($product->expiry_date)
                                        @if($product->isAboutToExpire(30))
                                            <span class="text-danger fw-bold">
                                                {{ $product->expiry_date->format('d/m/Y') }}
                                                <br><small>({{ $product->expiry_date->diffForHumans() }})</small>
                                            </span>
                                        @else
                                            <span>{{ $product->expiry_date->format('d/m/Y') }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Non définie</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fournisseur -->
            @if($product->supplier)
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-truck me-2" style="color: #336699;"></i>
                            Fournisseur
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3" style="width: 40px; height: 40px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $product->supplier->name }}</h6>
                                @if($product->supplier->contact_person)
                                    <small class="text-muted">Contact: {{ $product->supplier->contact_person }}</small>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            @if($product->supplier->phone_number)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <a href="tel:{{ $product->supplier->phone_number }}" class="text-decoration-none">{{ $product->supplier->phone_number }}</a>
                                </div>
                            @endif
                            @if($product->supplier->email)
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-envelope text-info me-2"></i>
                                    <a href="mailto:{{ $product->supplier->email }}" class="text-decoration-none">{{ $product->supplier->email }}</a>
                                </div>
                            @endif
                        </div>
                        
                        @if(auth()->user()->isAdmin())
                            <div class="mt-3">
                                <a href="{{ route('suppliers.show', $product->supplier->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Voir le fournisseur
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Dates importantes -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar me-2" style="color: #336699;"></i>
                        Historique et dates
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="p-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); border-radius: 10px;">
                                <i class="fas fa-plus-circle fa-2x text-primary mb-2 d-block"></i>
                                <h6 class="fw-bold">Créé le</h6>
                                <p class="mb-0">{{ $product->created_at->format('d/m/Y à H:i') }}</p>
                                <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="p-3" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 10px;">
                                <i class="fas fa-edit fa-2x text-warning mb-2 d-block"></i>
                                <h6 class="fw-bold">Modifié le</h6>
                                <p class="mb-0">{{ $product->updated_at->format('d/m/Y à H:i') }}</p>
                                <small class="text-muted">{{ $product->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @if($product->expiry_date)
                            <div class="col-md-4 text-center mb-3">
                                <div class="p-3" style="background: linear-gradient(135deg, {{ $product->isAboutToExpire(30) ? '#f8d7da' : '#d1ecf1' }} 0%, {{ $product->isAboutToExpire(30) ? '#f5c6cb' : '#bee5eb' }} 100%); border-radius: 10px;">
                                    <i class="fas fa-clock fa-2x {{ $product->isAboutToExpire(30) ? 'text-danger' : 'text-info' }} mb-2 d-block"></i>
                                    <h6 class="fw-bold">Expire le</h6>
                                    <p class="mb-0 {{ $product->isAboutToExpire(30) ? 'text-danger fw-bold' : '' }}">{{ $product->expiry_date->format('d/m/Y') }}</p>
                                    <small class="{{ $product->isAboutToExpire(30) ? 'text-danger' : 'text-muted' }}">{{ $product->expiry_date->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
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
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('inventory.edit', $product->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-edit me-1"></i> Modifier le produit
                            </a>
                            <button class="btn text-white fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#stockAdjustmentModal" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px; color: #212529;">
                                <i class="fas fa-exchange-alt me-1"></i> Ajuster le stock
                            </button>
                            <a href="{{ route('inventory.create', ['supplier_id' => $product->supplier_id]) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-plus me-1"></i> Produit similaire
                            </a>
                            @if($product->supplier)
                                <a href="{{ route('purchases.create', ['supplier_id' => $product->supplier_id]) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 10px; padding: 12px;">
                                    <i class="fas fa-shopping-cart me-1"></i> Commander
                                </a>
                            @endif
                        @endif
                        <a href="{{ route('sales.create', ['product_id' => $product->id]) }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                            <i class="fas fa-cash-register me-1"></i> Vendre ce produit
                        </a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary fw-semibold" style="border-radius: 10px; border: 2px solid #6c757d; padding: 12px;">
                            <i class="fas fa-list me-1"></i> Retour à la liste
                        </a>
                        
                        @if(auth()->user()->isAdmin())
                            <button type="button" class="btn text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteProductModal" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-trash me-1"></i> Supprimer le produit
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistiques du stock -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #336699;">
                        <i class="fas fa-chart-pie me-2"></i>
                        Statut détaillé
                    </h6>
                    
                    <!-- Progression du stock -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="fw-semibold">Stock actuel</small>
                            <small class="fw-semibold">{{ $product->stock_quantity }} / ∞</small>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 10px;">
                            @php
                                $stockPercentage = $product->stock_threshold > 0 ? min(($product->stock_quantity / ($product->stock_threshold * 2)) * 100, 100) : 50;
                                $colorClass = $product->isOutOfStock() ? 'bg-danger' : ($product->isLowStock() ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress-bar {{ $colorClass }}" role="progressbar" style="width: {{ $stockPercentage }}%;"></div>
                        </div>
                        <small class="text-muted">Seuil d'alerte: {{ $product->stock_threshold }}</small>
                    </div>
                    
                    <!-- Valeur du stock -->
                    @if(auth()->user()->isAdmin())
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <h5 class="mb-1 fw-bold text-danger">{{ number_format($product->purchase_price * $product->stock_quantity, 2) }} €</h5>
                                <small class="text-muted">Valeur d'achat</small>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1 fw-bold text-success">{{ number_format($product->selling_price * $product->stock_quantity, 2) }} €</h5>
                                <small class="text-muted">Valeur de vente</small>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <h5 class="mb-1 fw-bold text-success">{{ number_format($product->selling_price * $product->stock_quantity, 2) }} €</h5>
                            <small class="text-muted">Valeur totale du stock</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact rapide -->
            @if($product->supplier && ($product->supplier->phone_number || $product->supplier->email))
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #856404;">
                            <i class="fas fa-phone-alt me-2"></i>
                            Contact fournisseur
                        </h6>
                        <div class="d-grid gap-2">
                            @if($product->supplier->phone_number)
                                <a href="tel:{{ $product->supplier->phone_number }}" class="btn btn-outline-success btn-sm fw-semibold" style="border-radius: 10px;">
                                    <i class="fas fa-phone me-1"></i> Appeler
                                </a>
                            @endif
                            @if($product->supplier->email)
                                <a href="mailto:{{ $product->supplier->email }}" class="btn btn-outline-primary btn-sm fw-semibold" style="border-radius: 10px;">
                                    <i class="fas fa-envelope me-1"></i> Envoyer un email
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
    <!-- Stock Adjustment Modal -->
    <div class="modal fade" id="stockAdjustmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Ajustement de stock
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('inventory.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="alert alert-info border-0" style="border-radius: 10px;">
                            <i class="fas fa-info-circle me-2"></i>
                            Stock actuel : <strong>{{ $product->stock_quantity }}</strong> unité(s)
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_stock" class="form-label fw-semibold">Nouveau stock</label>
                            <input type="number" class="form-control" id="new_stock" name="stock_quantity" 
                                   value="{{ $product->stock_quantity }}" min="0" required
                                   style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                        </div>
                        
                        <div class="mb-3">
                            <label for="adjustment_reason" class="form-label fw-semibold">Raison de l'ajustement</label>
                            <select class="form-select" id="adjustment_reason" name="adjustment_reason"
                                    style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                <option value="inventory">Inventaire</option>
                                <option value="damage">Produit endommagé</option>
                                <option value="expired">Produit expiré</option>
                                <option value="theft">Vol/Perte</option>
                                <option value="correction">Correction d'erreur</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <!-- Hidden fields to maintain other product data -->
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                        <input type="hidden" name="purchase_price" value="{{ $product->purchase_price }}">
                        <input type="hidden" name="selling_price" value="{{ $product->selling_price }}">
                        <input type="hidden" name="stock_threshold" value="{{ $product->stock_threshold }}">
                        @if($product->prescription_required)
                            <input type="hidden" name="prescription_required" value="1">
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                        <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; color: #212529;">
                            <i class="fas fa-check me-1"></i>Ajuster le stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Supprimer le produit
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger border-0" style="border-radius: 10px;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention !</strong> Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer le produit <strong>{{ $product->name }}</strong> ?</p>
                    @if($product->stock_quantity > 0)
                        <div class="alert alert-warning border-0" style="border-radius: 10px;">
                            <i class="fas fa-boxes me-2"></i>
                            Ce produit a encore <strong>{{ $product->stock_quantity }}</strong> unité(s) en stock.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                    <form action="{{ route('inventory.destroy', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
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
    
    .progress-bar {
        transition: width 0.6s ease;
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
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calculate stock difference in adjustment modal
    const stockInput = document.getElementById('new_stock');
    const currentStock = {{ $product->stock_quantity }};
    
    if (stockInput) {
        stockInput.addEventListener('input', function() {
            const newStock = parseInt(this.value) || 0;
            const difference = newStock - currentStock;
            
            // Update modal with visual feedback
            const alertElement = this.closest('.modal-body').querySelector('.alert-info');
            if (difference > 0) {
                alertElement.innerHTML = `<i class="fas fa-arrow-up me-2 text-success"></i>Stock actuel : <strong>${currentStock}</strong> → <strong class="text-success">${newStock}</strong> (+${difference})`;
                alertElement.className = 'alert alert-success border-0';
            } else if (difference < 0) {
                alertElement.innerHTML = `<i class="fas fa-arrow-down me-2 text-danger"></i>Stock actuel : <strong>${currentStock}</strong> → <strong class="text-danger">${newStock}</strong> (${difference})`;
                alertElement.className = 'alert alert-warning border-0';
            } else {
                alertElement.innerHTML = `<i class="fas fa-info-circle me-2"></i>Stock actuel : <strong>${currentStock}</strong> unité(s)`;
                alertElement.className = 'alert alert-info border-0';
            }
        });
    }
});
</script>
@endsection