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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">{{ $supplier->name }}</h2>
                    <small class="text-muted">
                        <span class="badge {{ $supplier->active ? 'bg-success' : 'bg-secondary' }} rounded-pill me-2">
                            {{ $supplier->active ? 'Actif' : 'Inactif' }}
                        </span>
                        Fournisseur depuis {{ $supplier->created_at->format('M Y') }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('suppliers.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-edit me-1"></i> Modifier
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

    <div class="row">
        <div class="col-md-8">
            <!-- Informations principales -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                        Informations détaillées
                    </h5>
                    <span class="badge {{ $supplier->active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                        {{ $supplier->active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Nom du fournisseur</h6>
                                <p class="mb-0 fs-5">{{ $supplier->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Personne de contact</h6>
                                <p class="mb-0">
                                    @if($supplier->contact_person)
                                        <i class="fas fa-user me-2 text-primary"></i>{{ $supplier->contact_person }}
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Téléphone</h6>
                                <p class="mb-0">
                                    @if($supplier->phone_number)
                                        <i class="fas fa-phone me-2 text-success"></i>
                                        <a href="tel:{{ $supplier->phone_number }}" class="text-decoration-none">{{ $supplier->phone_number }}</a>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Email</h6>
                                <p class="mb-0">
                                    @if($supplier->email)
                                        <i class="fas fa-envelope me-2 text-info"></i>
                                        <a href="mailto:{{ $supplier->email }}" class="text-decoration-none">{{ $supplier->email }}</a>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Créé le</h6>
                                <p class="mb-0">{{ $supplier->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Dernière modification</h6>
                                <p class="mb-0">{{ $supplier->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Nombre de produits</h6>
                                <p class="mb-0">
                                    <span class="badge bg-primary rounded-pill fs-6">{{ $totalProducts ?? 0 }} produit(s)</span>
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Valeur totale stock</h6>
                                <p class="mb-0 text-success fw-bold fs-5">
                                    {{ number_format($supplier->products()->sum(\DB::raw('purchase_price * stock_quantity')) ?? 0, 2) }} €
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($supplier->address)
                        <hr class="my-4">
                        <div>
                            <h6 class="fw-bold text-muted mb-2">Adresse</h6>
                            <p class="mb-0 bg-light p-3 rounded" style="border-radius: 10px;">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $supplier->address }}
                            </p>
                        </div>
                    @endif

                    @if($supplier->notes)
                        <hr class="my-4">
                        <div>
                            <h6 class="fw-bold text-muted mb-2">Notes</h6>
                            <p class="mb-0 bg-light p-3 rounded" style="border-radius: 10px;">
                                <i class="fas fa-sticky-note me-2 text-warning"></i>{{ $supplier->notes }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Produits récents -->
            @if(isset($recentProducts) && $recentProducts->count() > 0)
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-boxes me-2" style="color: #336699;"></i>
                            Produits récents ({{ $recentProducts->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Catégorie</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Prix d'achat</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Stock</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                        <tr>
                                            <td class="border-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-pills text-white small"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $product->name }}</strong>
                                                        @if($product->dosage)
                                                            <br><small class="text-muted">{{ $product->dosage }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                @if($product->category)
                                                    <span class="badge bg-secondary rounded-pill">{{ $product->category->name }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td class="border-0">
                                                <strong class="text-success">{{ number_format($product->purchase_price, 2) }} €</strong>
                                            </td>
                                            <td class="border-0">
                                                @if($product->isOutOfStock())
                                                    <span class="badge bg-danger rounded-pill">Rupture</span>
                                                @elseif($product->isLowStock())
                                                    <span class="badge bg-warning text-dark rounded-pill">Faible ({{ $product->stock_quantity }})</span>
                                                @else
                                                    <span class="badge bg-success rounded-pill">{{ $product->stock_quantity }}</span>
                                                @endif
                                            </td>
                                            <td class="border-0">
                                                <a href="{{ route('inventory.show', $product->id) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none;" title="Voir le produit">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(($totalProducts ?? 0) > $recentProducts->count())
                        <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                            <a href="{{ route('inventory.index', ['supplier' => $supplier->id]) }}" class="btn btn-primary">
                                <i class="fas fa-boxes me-1"></i>
                                Voir tous les produits ({{ $totalProducts }})
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <!-- Statistiques -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <h4 class="mb-1 fw-bold text-primary">{{ $totalProducts ?? 0 }}</h4>
                            <small class="text-muted">Total produits</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-1 fw-bold text-{{ ($lowStockProducts ?? 0) > 0 ? 'warning' : 'success' }}">{{ $lowStockProducts ?? 0 }}</h4>
                            <small class="text-muted">Stock faible</small>
                        </div>
                    </div>
                    
                    <div class="progress mb-3" style="height: 8px; border-radius: 10px;">
                        @php
                            $activeProducts = $supplier->products()->where('stock_quantity', '>', 0)->count();
                            $percentage = ($totalProducts ?? 0) > 0 ? ($activeProducts / ($totalProducts ?? 1)) * 100 : 0;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background: linear-gradient(90deg, #28a745, #20c997);"></div>
                    </div>
                    <small class="text-muted">{{ number_format($percentage, 1) }}% des produits en stock</small>
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
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-edit me-1"></i> Modifier les informations
                        </a>
                        <a href="{{ route('inventory.create', ['supplier_id' => $supplier->id]) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-plus me-1"></i> Ajouter un produit
                        </a>
                        @if(($totalProducts ?? 0) > 0)
                            <a href="{{ route('inventory.index', ['supplier' => $supplier->id]) }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                                <i class="fas fa-boxes me-1"></i> Voir tous les produits
                            </a>
                        @endif
                        <a href="{{ route('purchases.create', ['supplier_id' => $supplier->id]) }}" class="btn btn-outline-success fw-semibold" style="border-radius: 10px; border: 2px solid #28a745; padding: 12px;">
                            <i class="fas fa-shopping-cart me-1"></i> Nouvelle commande
                        </a>
                        @if(($supplier->products_count ?? 0) == 0)
                            <button type="button" class="btn text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteModal" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-trash me-1"></i> Supprimer le fournisseur
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact rapide -->
            @if($supplier->contact_person || $supplier->phone_number || $supplier->email)
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #336699;">
                            <i class="fas fa-phone-alt me-2"></i>
                            Contact rapide
                        </h6>
                        <div class="d-grid gap-2">
                            @if($supplier->phone_number)
                                <a href="tel:{{ $supplier->phone_number }}" class="btn btn-outline-success btn-sm fw-semibold" style="border-radius: 10px;">
                                    <i class="fas fa-phone me-1"></i> Appeler
                                </a>
                            @endif
                            @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" class="btn btn-outline-primary btn-sm fw-semibold" style="border-radius: 10px;">
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

@if(($supplier->products_count ?? 0) == 0)
    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
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
                    <p>Êtes-vous sûr de vouloir supprimer le fournisseur <strong>{{ $supplier->name }}</strong>?</p>
                    <p><strong>Conséquences :</strong></p>
                    <ul>
                        <li>Le fournisseur sera définitivement supprimé</li>
                        <li>Cette action ne peut pas être annulée</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: inline;">
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
    
    .table-hover tbody tr:hover {
        background-color: rgba(51, 102, 153, 0.05);
        transform: scale(1.005);
        transition: all 0.2s ease;
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