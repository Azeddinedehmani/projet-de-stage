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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">
                        @if(auth()->user()->isAdmin())
                            Gestion des produits
                        @else
                            Consultation de l'inventaire
                        @endif
                    </h2>
                    <small class="text-muted">
                        @if(auth()->user()->isPharmacist())
                            <i class="fas fa-info-circle me-1"></i>
                            Consultation en mode lecture seule
                        @else
                            Suivi et gestion de l'inventaire
                        @endif
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('inventory.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-plus me-1"></i> Nouveau produit
                </a>
            @else
                <div class="btn-group">
                    <button type="button" class="btn text-white fw-semibold dropdown-toggle" data-bs-toggle="dropdown" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);">
                        <i class="fas fa-filter me-1"></i> Filtres rapides
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('inventory.index', ['stock_status' => 'low']) }}">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>Stock faible
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('inventory.index', ['stock_status' => 'out']) }}">
                            <i class="fas fa-times-circle text-danger me-2"></i>Rupture de stock
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('inventory.index') }}">
                            <i class="fas fa-list me-2"></i>Tous les produits
                        </a></li>
                    </ul>
                </div>
            @endif
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

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total produits</h6>
                            <h4 class="mb-0">{{ \App\Models\Product::count() }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-pills fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Stock faible</h6>
                            <h4 class="mb-0">{{ \App\Models\Product::whereColumn('stock_quantity', '<=', 'stock_threshold')->count() }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle fa-2x" style="color: #212529;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Rupture de stock</h6>
                            <h4 class="mb-0">{{ \App\Models\Product::where('stock_quantity', '<=', 0)->count() }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Expire bientôt</h6>
                            <h4 class="mb-0">{{ \App\Models\Product::where('expiry_date', '<=', now()->addDays(30))->where('expiry_date', '>', now())->count() }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-filter me-2" style="color: #336699;"></i>
                Filtres et recherche
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('inventory.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nom, code barre..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-2">
                    <label for="category" class="form-label fw-semibold">Catégorie</label>
                    <select class="form-select" id="category" name="category" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(auth()->user()->isAdmin() && $suppliers->isNotEmpty())
                <div class="col-md-2">
                    <label for="supplier" class="form-label fw-semibold">Fournisseur</label>
                    <select class="form-select" id="supplier" name="supplier" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les fournisseurs</option>
                        <option value="none" {{ request('supplier') == 'none' ? 'selected' : '' }}>Sans fournisseur</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-2">
                    <label for="stock_status" class="form-label fw-semibold">État du stock</label>
                    <select class="form-select" id="stock_status" name="stock_status" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les produits</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stock faible</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Rupture de stock</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn w-100" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @if(request()->hasAny(['search', 'category', 'supplier', 'stock_status']))
                <div class="col-md-1 d-flex align-items-end">
                    <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary w-100" style="border-radius: 10px; padding: 12px;">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-list me-2" style="color: #336699;"></i>
                    Liste des produits ({{ $products->total() }})
                </h5>
                @if(auth()->user()->isPharmacist())
                    <small class="text-muted">
                        <i class="fas fa-eye me-1"></i>Mode consultation
                    </small>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Catégorie</th>
                            @if(auth()->user()->isAdmin())
                                <th class="border-0 fw-semibold" style="color: #336699;">Prix d'achat</th>
                            @endif
                            <th class="border-0 fw-semibold" style="color: #336699;">Prix de vente</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Stock</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Emplacement</th>
                            @if(auth()->user()->isAdmin() && $suppliers->isNotEmpty())
                                <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                            @endif
                            <th class="border-0 fw-semibold" style="color: #336699;">Expiration</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="{{ $product->isOutOfStock() ? 'table-danger' : ($product->isLowStock() ? 'table-warning' : '') }}">
                                <td class="border-0">
                                    <div class="d-flex align-items-center">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/'.$product->image_path) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-thumbnail me-2" 
                                                 style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <div class="me-2" style="width: 45px; height: 45px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-pills text-white"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            @if($product->dosage)
                                                <small class="text-muted">{{ $product->dosage }}</small>
                                            @endif
                                            @if($product->prescription_required)
                                                <br><span class="badge bg-info text-white" style="font-size: 0.7rem;">
                                                    <i class="fas fa-prescription-bottle me-1"></i>Ordonnance
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border-0">
                                    <span class="badge bg-light text-dark rounded-pill">
                                        {{ $product->category ? $product->category->name : 'N/A' }}
                                    </span>
                                </td>
                                @if(auth()->user()->isAdmin())
                                <td class="border-0">
                                    <span class="text-muted">{{ number_format($product->purchase_price, 2) }} €</span>
                                </td>
                                @endif
                                <td class="border-0">
                                    <strong class="text-success">{{ number_format($product->selling_price, 2) }} €</strong>
                                </td>
                                <td class="border-0">
                                    @if($product->isOutOfStock())
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="fas fa-times-circle me-1"></i>Rupture
                                        </span>
                                    @elseif($product->isLowStock())
                                        <span class="badge bg-warning text-dark rounded-pill">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $product->stock_quantity }}
                                        </span>
                                    @else
                                        <span class="badge bg-success rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>{{ $product->stock_quantity }}
                                        </span>
                                    @endif
                                    <br><small class="text-muted">Seuil: {{ $product->stock_threshold }}</small>
                                </td>
                                <td class="border-0">
                                    <small class="text-muted">
                                        {{ $product->location ?? 'Non défini' }}
                                    </small>
                                </td>
                                @if(auth()->user()->isAdmin() && $suppliers->isNotEmpty())
                                <td class="border-0">
                                    @if($product->supplier)
                                        <small class="text-muted">{{ $product->supplier->name }}</small>
                                    @else
                                        <small class="text-muted">Aucun</small>
                                    @endif
                                </td>
                                @endif
                                <td class="border-0">
                                    @if($product->expiry_date)
                                        @if($product->isAboutToExpire(30))
                                            <span class="text-danger fw-bold">
                                                <i class="fas fa-clock me-1"></i>{{ $product->expiry_date->format('d/m/Y') }}
                                            </span>
                                            <br><small class="text-danger">{{ $product->expiry_date->diffForHumans() }}</small>
                                        @else
                                            <span class="text-muted">{{ $product->expiry_date->format('d/m/Y') }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if(auth()->user()->isAdmin())
                                        <!-- Admin actions -->
                                        <div class="action-buttons d-flex flex-wrap gap-1">
                                            <a href="{{ route('inventory.show', $product->id) }}" class="btn btn-sm" 
                                               style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <a href="{{ route('inventory.edit', $product->id) }}" class="btn btn-sm" 
                                               style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm" 
                                                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $product->id }}" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @else
                                        <!-- Pharmacist actions -->
                                        <div class="action-buttons d-flex flex-wrap gap-1">
                                            <a href="{{ route('inventory.show', $product->id) }}" class="btn btn-sm" 
                                               style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                    style="border-radius: 8px; padding: 8px 12px;" 
                                                    disabled title="Modification non autorisée">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? (count($suppliers) > 0 ? 9 : 8) : 7 }}" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-search fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucun produit trouvé</h5>
                                    <p class="text-muted">
                                        @if(request()->hasAny(['search', 'category', 'supplier', 'stock_status']))
                                            Aucun produit ne correspond à vos critères de recherche.
                                            <br><a href="{{ route('inventory.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-times me-1"></i>Réinitialiser les filtres
                                            </a>
                                        @else
                                            Il n'y a aucun produit dans l'inventaire.
                                            @if(auth()->user()->isAdmin())
                                                <br><a href="{{ route('inventory.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus me-1"></i>Ajouter le premier produit
                                                </a>
                                            @endif
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Affichage de {{ $products->firstItem() }} à {{ $products->lastItem() }} sur {{ $products->total() }} produits
                    </div>
                    <div>
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(auth()->user()->isPharmacist())
    <!-- Information section for pharmacists -->
    <div class="card mt-4 border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3" style="color: #336699;">
                <i class="fas fa-info-circle me-2"></i>Informations pour les pharmaciens
            </h6>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Légende des couleurs</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="badge bg-success me-2"><i class="fas fa-check-circle"></i></span>
                            Stock normal (au-dessus du seuil)
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-warning text-dark me-2"><i class="fas fa-exclamation-triangle"></i></span>
                            Stock faible (en dessous du seuil)
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-danger me-2"><i class="fas fa-times-circle"></i></span>
                            Rupture de stock (0 unité)
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Actions disponibles</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-eye text-info me-2"></i>
                            Consulter les détails d'un produit
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-filter text-primary me-2"></i>
                            Filtrer et rechercher des produits
                        </li>
                        <li class="mb-2 text-muted">
                            <i class="fas fa-lock me-2"></i>
                            Modification et suppression réservées aux responsables
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modals de suppression (placés à la fin pour éviter les conflits) -->
@if(auth()->user()->isAdmin())
    @foreach($products as $product)
        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
            <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $product->id }}">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Confirmer la suppression
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning border-0" style="border-radius: 10px;">
                            <strong><i class="fas fa-exclamation-triangle me-1"></i>Attention!</strong>
                            Cette action est irréversible.
                        </div>
                        <p>Êtes-vous sûr de vouloir supprimer le produit <strong>{{ $product->name }}</strong>?</p>
                        @if($product->stock_quantity > 0)
                            <div class="alert alert-info border-0" style="border-radius: 10px;">
                                <i class="fas fa-info-circle me-2"></i>
                                Ce produit a encore <strong>{{ $product->stock_quantity }}</strong> unité(s) en stock.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                        <form action="{{ route('inventory.destroy', $product->id) }}" method="POST" style="display: inline;" 
                              onsubmit="return confirm('Êtes-vous absolument certain de vouloir supprimer ce produit ? Cette action est irréversible.');">
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
    @endforeach
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
    
    /* Animation pour les cartes statistiques */
    .stats-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }
    
    .stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .stats-card:hover::before {
        left: 100%;
    }
    
    /* Styles pour les boutons d'action */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        align-items: center;
        justify-content: flex-start;
    }
    
    .action-buttons .btn {
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.875rem;
        min-width: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .action-buttons .btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Effet de ondulation pour les boutons */
    .action-buttons .btn::after {
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
    
    .action-buttons .btn:active::after {
        width: 120%;
        height: 120%;
    }
    
    /* Styles pour les tableaux colorés selon le stock */
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
        border-left: 4px solid #ffc107;
    }
    
    .table-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
        border-left: 4px solid #dc3545;
    }
    
    /* Styles pour les modals améliorés */
    .modal-header {
        border-bottom: none;
        position: relative;
    }
    
    .modal-footer {
        border-top: none;
        padding-top: 0;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
    }
    
    .modal.fade .modal-dialog {
        transition: transform 0.4s ease-out, opacity 0.4s ease-out;
        transform: translate(0, -50px) scale(0.9);
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0) scale(1);
    }
    
    /* Animation pour les alertes */
    .alert {
        animation: slideInDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
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
    
    /* Styles pour les badges de statut */
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
    }
    
    .badge.bg-light {
        background: #f8f9fa !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
    }
    
    /* Styles pour les images de produits */
    .img-thumbnail {
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .img-thumbnail:hover {
        border-color: #336699;
        transform: scale(1.1);
    }
    
    /* Responsive pour les petits écrans */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 15px;
        }
        
        .action-buttons {
            justify-content: center;
            gap: 2px;
        }
        
        .action-buttons .btn {
            flex: 1;
            min-width: 35px;
            padding: 6px 8px;
            font-size: 0.8rem;
        }
        
        .table-responsive {
            font-size: 0.875rem;
            border-radius: 10px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-body {
            padding: 20px 15px;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .form-control,
        .form-select {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
        }
    }
    
    @media (max-width: 576px) {
        .row.g-3 > * {
            margin-bottom: 10px;
        }
        
        .col-md-1 {
            width: 100%;
        }
        
        .action-buttons .btn {
            min-width: 32px;
            padding: 4px 6px;
        }
        
        .stats-card .card-body {
            padding: 15px;
        }
        
        .stats-card h4 {
            font-size: 1.3rem;
        }
        
        .stats-card h6 {
            font-size: 0.8rem;
        }
    }
    
    /* Amélioration de l'accessibilité */
    .btn:focus,
    .form-control:focus,
    .form-select:focus {
        outline: 2px solid #336699;
        outline-offset: 2px;
    }
    
    .btn:focus:not(:focus-visible) {
        outline: none;
    }
    
    /* Styles pour les tooltips */
    [title] {
        cursor: help;
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
        
        .form-control,
        .form-select {
            background-color: rgba(33, 37, 41, 0.9);
            border-color: rgba(255, 255, 255, 0.2);
            color: #f8f9fa;
        }
        
        .form-control:focus,
        .form-select:focus {
            background-color: rgba(33, 37, 41, 0.9);
            border-color: #336699;
            color: #f8f9fa;
        }
        
        .modal-content {
            background: rgba(33, 37, 41, 0.95);
            color: #f8f9fa;
        }
        
        .alert {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .badge.bg-light {
            background: rgba(108, 117, 125, 0.3) !important;
            color: #f8f9fa !important;
            border-color: rgba(255, 255, 255, 0.2);
        }
    }
    
    /* Styles pour l'impression */
    @media print {
        .btn,
        .action-buttons,
        .modal,
        .alert,
        .card-header,
        .card-footer {
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
    
    /* Animation de chargement */
    .loading {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #336699;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 1000;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
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
    
    /* Correction pour éviter que les modals se chevauchent */
    .modal {
        z-index: 1055;
    }
    
    .modal-backdrop {
        z-index: 1050;
    }
    
    /* Styles pour les confirmations de suppression */
    .btn[data-bs-toggle="modal"] {
        cursor: pointer;
    }
    
    .btn[data-bs-toggle="modal"]:hover {
        opacity: 0.9;
    }
    
    /* Performance optimizations */
    .card,
    .btn,
    .badge,
    .alert {
        will-change: transform;
    }
    
    /* Styles pour les états de validation */
    .is-valid {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Amélioration de la lisibilité */
    .table td {
        vertical-align: middle;
        line-height: 1.4;
    }
    
    /* Styles pour les filtres actifs */
    .filter-active {
        background: rgba(51, 102, 153, 0.1);
        border-color: #336699;
    }
    
    /* Dropdown amélioré */
    .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }
    
    .dropdown-item {
        transition: all 0.2s ease;
        border-radius: 8px;
        margin: 2px 5px;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(135deg, #336699 0%, #4a90e2 100%);
        color: white;
        transform: translateX(5px);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change for better UX
    const filterSelects = document.querySelectorAll('#category, #supplier, #stock_status');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Add a small delay to improve UX
            setTimeout(() => {
                this.closest('form').submit();
            }, 100);
        });
    });
    
    // Enhanced search with enter key
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').submit();
            }
        });
        
        // Real-time search feedback
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.add('filter-active');
            } else {
                this.classList.remove('filter-active');
            }
        });
    }
    
    // Highlight current filters
    const currentFilters = ['{{ request("search") }}', '{{ request("category") }}', '{{ request("supplier") }}', '{{ request("stock_status") }}'];
    const hasActiveFilters = currentFilters.some(filter => filter && filter.trim() !== '');
    
    if (hasActiveFilters) {
        const filterCard = document.querySelector('.card-header h5.card-title');
        if (filterCard && filterCard.textContent.includes('Filtres')) {
            filterCard.innerHTML = '<i class="fas fa-filter me-2 text-primary"></i>Filtres et recherche <small class="badge bg-primary ms-2">Actifs</small>';
        }
        
        // Highlight active filter inputs
        filterSelects.forEach(select => {
            if (select.value) {
                select.classList.add('filter-active');
            }
        });
        
        if (searchInput && searchInput.value) {
            searchInput.classList.add('filter-active');
        }
    }
    
    // Tooltip initialization for disabled buttons and other elements
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Image preview on hover for product images
    const productImages = document.querySelectorAll('.img-thumbnail');
    productImages.forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.zIndex = '1000';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.zIndex = 'auto';
        });
    });
    
    // Enhanced modal behavior
    const deleteModals = document.querySelectorAll('[id^="deleteModal"]');
    deleteModals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            // Add loading state to delete button when modal opens
            const deleteBtn = this.querySelector('button[type="submit"]');
            deleteBtn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Suppression...';
                this.disabled = true;
            });
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.classList.contains('show')) {
                alert.classList.remove('show');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }, 5000);
    });
    
    // Statistics cards click behavior
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function() {
            let filterUrl = '{{ route("inventory.index") }}';
            
            switch(index) {
                case 1: // Stock faible
                    filterUrl += '?stock_status=low';
                    break;
                case 2: // Rupture de stock
                    filterUrl += '?stock_status=out';
                    break;
                case 3: // Expire bientôt
                    filterUrl += '?expiring_soon=1';
                    break;
                default:
                    filterUrl += '';
            }
            
            window.location.href = filterUrl;
        });
    });
    
    // Enhanced table row interactions
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.action-buttons') && !e.target.closest('button')) {
                const viewLink = this.querySelector('.action-buttons a[href*="show"]');
                if (viewLink) {
                    window.location.href = viewLink.href;
                }
            }
        });
    });
    
    // Loading state for form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape') {
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.classList.remove('filter-active');
            }
        }
    });
});
</script>
@endsection