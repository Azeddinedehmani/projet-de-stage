@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-edit text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Modifier le produit</h2>
                    <small class="text-muted">{{ $product->name }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('inventory.show', $product->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-eye me-1"></i> Voir
                </a>
                <a href="{{ route('inventory.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('inventory.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <!-- Informations générales -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                            Informations générales
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nom du produit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $product->name) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold">Catégorie <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required
                                        style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dosage" class="form-label fw-semibold">Dosage</label>
                                <input type="text" class="form-control @error('dosage') is-invalid @enderror" 
                                       id="dosage" name="dosage" value="{{ old('dosage', $product->dosage) }}"
                                       placeholder="Ex: 500mg, 10ml, 1g"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('dosage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="barcode" class="form-label fw-semibold">Code-barres</label>
                                <input type="text" class="form-control @error('barcode') is-invalid @enderror" 
                                       id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('barcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3"
                                      placeholder="Description détaillée du produit"
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Prix et stock -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-euro-sign me-2" style="color: #336699;"></i>
                            Prix et stock
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="purchase_price" class="form-label fw-semibold">Prix d'achat (€) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" 
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required
                                           style="border-radius: 10px 0 0 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef; border-left: none; background: #f8f9fa;">€</span>
                                </div>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="selling_price" class="form-label fw-semibold">Prix de vente (€) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" 
                                           id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required
                                           style="border-radius: 10px 0 0 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef; border-left: none; background: #f8f9fa;">€</span>
                                </div>
                                @error('selling_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="stock_quantity" class="form-label fw-semibold">Quantité en stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="stock_threshold" class="form-label fw-semibold">Seuil d'alerte <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_threshold') is-invalid @enderror" 
                                       id="stock_threshold" name="stock_threshold" value="{{ old('stock_threshold', $product->stock_threshold) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('stock_threshold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Calcul de marge -->
                        <div class="alert alert-info border-0" style="border-radius: 10px;">
                            <strong>Marge actuelle :</strong>
                            @php
                                $margin = $product->selling_price - $product->purchase_price;
                                $marginPercent = $product->purchase_price > 0 ? ($margin / $product->purchase_price) * 100 : 0;
                            @endphp
                            <span id="current-margin">{{ number_format($margin, 2) }} € ({{ number_format($marginPercent, 2) }}%)</span>
                        </div>
                    </div>
                </div>

                <!-- Autres informations -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-cogs me-2" style="color: #336699;"></i>
                            Informations complémentaires
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="supplier_id" class="form-label fw-semibold">Fournisseur</label>
                                <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                        id="supplier_id" name="supplier_id"
                                        style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                    <option value="">Sélectionner un fournisseur</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" 
                                                {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold">Emplacement</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location', $product->location) }}"
                                       placeholder="Ex: A1-01, Rayon B"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label fw-semibold">Date d'expiration</label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" name="expiry_date" 
                                       value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="image" class="form-label fw-semibold">Image du produit</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($product->image_path)
                                    <small class="text-muted">Image actuelle disponible</small>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('prescription_required') is-invalid @enderror" 
                                       type="checkbox" role="switch" value="1" id="prescription_required" 
                                       name="prescription_required" {{ old('prescription_required', $product->prescription_required) ? 'checked' : '' }}
                                       style="font-size: 1.2rem;">
                                <label class="form-check-label fw-semibold" for="prescription_required">
                                    <i class="fas fa-prescription-bottle me-1"></i>Ordonnance requise
                                </label>
                                @error('prescription_required')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar avec aperçu et actions -->
            <div class="col-md-4">
                <!-- Image actuelle -->
                @if($product->image_path)
                    <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                            <h6 class="mb-0 fw-bold">Image actuelle</h6>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/'.$product->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 200px; border-radius: 10px;">
                        </div>
                    </div>
                @endif

                <!-- Aperçu nouvelle image -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h6 class="mb-0 fw-bold">Nouvelle image</h6>
                    </div>
                    <div class="card-body text-center">
                        <div id="image-preview" style="min-height: 150px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 10px;">
                            <div class="text-muted">
                                <i class="fas fa-image fa-2x mb-2 d-block"></i>
                                <p class="mb-0">Sélectionnez une nouvelle image</p>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Statut du stock -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h6 class="mb-0 fw-bold">Statut du stock</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Stock actuel:</span>
                            <span class="badge {{ $product->isOutOfStock() ? 'bg-danger' : ($product->isLowStock() ? 'bg-warning text-dark' : 'bg-success') }} rounded-pill">
                                {{ $product->stock_quantity }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Seuil d'alerte:</span>
                            <span class="badge bg-info rounded-pill">{{ $product->stock_threshold }}</span>
                        </div>
                        @if($product->isLowStock())
                            <div class="alert alert-warning border-0 mt-2" style="border-radius: 10px;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Stock faible !
                            </div>
                        @endif
                        @if($product->isOutOfStock())
                            <div class="alert alert-danger border-0 mt-2" style="border-radius: 10px;">
                                <i class="fas fa-times-circle me-1"></i>
                                Rupture de stock !
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #336699;">
                            <i class="fas fa-chart-line me-2"></i>
                            Statistiques
                        </h6>
                        <div class="row text-center mb-3">
                            <div class="col-6 border-end">
                                <h5 class="mb-1 fw-bold text-primary">{{ $product->created_at->diffInDays() }}</h5>
                                <small class="text-muted">Jours depuis création</small>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1 fw-bold text-success">{{ $product->updated_at->diffInDays() }}</h5>
                                <small class="text-muted">Jours depuis MAJ</small>
                            </div>
                        </div>
                        
                        @if($product->expiry_date)
                            <div class="text-center">
                                <small class="text-muted d-block">Expire dans</small>
                                <span class="{{ $product->isAboutToExpire(30) ? 'text-danger fw-bold' : 'text-muted' }}">
                                    {{ $product->expiry_date->diffForHumans() }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations de modification -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #856404;">
                            <i class="fas fa-lightbulb me-2"></i>
                            Conseils de modification
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Vérifiez que le prix de vente reste supérieur au prix d'achat</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Un seuil d'alerte adapté évite les ruptures</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Les modifications seront sauvegardées immédiatement</small>
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>L'historique des changements est conservé</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card border-0 shadow-lg mt-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold">Prêt à sauvegarder ?</h6>
                        <small class="text-muted">Les modifications seront appliquées immédiatement</small>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('inventory.show', $product->id) }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 24px;">
                            <i class="fas fa-times me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);">
                            <i class="fas fa-save me-1"></i> Sauvegarder les modifications
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    
    .form-control:focus,
    .form-select:focus {
        border-color: #336699;
        box-shadow: 0 0 0 0.2rem rgba(51, 102, 153, 0.25);
        transform: scale(1.02);
        transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-color: #336699;
        border-color: #336699;
    }
    
    .form-check-input:focus {
        border-color: #336699;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(51, 102, 153, 0.25);
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .invalid-feedback {
        display: block;
    }
    
    #image-preview img {
        max-width: 100%;
        max-height: 150px;
        border-radius: 10px;
    }
    
    /* Harmonisation avec le sidebar */
    .text-primary {
        color: #336699 !important;
    }
    
    .bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcul de marge en temps réel
    const purchasePriceInput = document.getElementById('purchase_price');
    const sellingPriceInput = document.getElementById('selling_price');
    const currentMarginSpan = document.getElementById('current-margin');
    
    function updateMargin() {
        const purchasePrice = parseFloat(purchasePriceInput.value) || 0;
        const sellingPrice = parseFloat(sellingPriceInput.value) || 0;
        const margin = sellingPrice - purchasePrice;
        const marginPercent = purchasePrice > 0 ? (margin / purchasePrice) * 100 : 0;
        
        currentMarginSpan.textContent = `${margin.toFixed(2)} € (${marginPercent.toFixed(2)}%)`;
        
        // Changement de couleur selon la marge
        const alertElement = currentMarginSpan.closest('.alert');
        if (margin > 0) {
            alertElement.className = 'alert alert-success border-0';
        } else if (margin < 0) {
            alertElement.className = 'alert alert-danger border-0';
        } else {
            alertElement.className = 'alert alert-warning border-0';
        }
    }
    
    purchasePriceInput.addEventListener('input', updateMargin);
    sellingPriceInput.addEventListener('input', updateMargin);
    
    // Aperçu de la nouvelle image
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Nouvelle image" style="max-width: 100%; max-height: 150px; border-radius: 10px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = `
                <div class="text-muted">
                    <i class="fas fa-image fa-2x mb-2 d-block"></i>
                    <p class="mb-0">Sélectionnez une nouvelle image</p>
                </div>
            `;
        }
    });
    
    // Validation du formulaire
    const form = document.querySelector('form');
    const requiredFields = form.querySelectorAll('[required]');
    
    form.addEventListener('submit', function(e) {
        const purchasePrice = parseFloat(purchasePriceInput.value) || 0;
        const sellingPrice = parseFloat(sellingPriceInput.value) || 0;
        
        if (sellingPrice <= purchasePrice && purchasePrice > 0) {
            if (!confirm('Le prix de vente est inférieur ou égal au prix d\'achat. Êtes-vous sûr de continuer ?')) {
                e.preventDefault();
                return;
            }
        }
        
        let isValid = true;
        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });
    
    // Real-time validation
    requiredFields.forEach(function(field) {
        field.addEventListener('blur', function() {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
    });

    // Highlight des changements
    const originalValues = {};
    const formInputs = form.querySelectorAll('input, textarea, select');
    
    formInputs.forEach(function(input) {
        if (input.type !== 'checkbox' && input.type !== 'file') {
            originalValues[input.name] = input.value;
        } else if (input.type === 'checkbox') {
            originalValues[input.name] = input.checked;
        }
    });
    
    formInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            let currentValue = input.type === 'checkbox' ? input.checked : input.value;
            let originalValue = originalValues[input.name];
            
            if (input.type !== 'file' && currentValue !== originalValue) {
                input.style.borderColor = '#ffc107';
                input.style.backgroundColor = 'rgba(255, 193, 7, 0.1)';
            } else if (input.type !== 'file') {
                input.style.borderColor = '#e9ecef';
                input.style.backgroundColor = '';
            }
        });
    });
    
    // Navigation avec Enter
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach((input, index) => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && input.type !== 'textarea') {
                e.preventDefault();
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });
    });
});
</script>
@endsection