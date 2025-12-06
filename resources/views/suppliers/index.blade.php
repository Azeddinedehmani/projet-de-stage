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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Gestion des fournisseurs</h2>
                    <small class="text-muted">Suivi et gestion des partenaires</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('suppliers.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-plus me-1"></i> Nouveau fournisseur
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

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stat-card" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total fournisseurs</h6>
                            <h4 class="mb-0">{{ $totalSuppliers ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stat-card" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Fournisseurs actifs</h6>
                            <h4 class="mb-0">{{ $activeSuppliers ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stat-card" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Avec produits</h6>
                            <h4 class="mb-0">{{ $suppliersWithProducts ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stat-card" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Fournisseurs inactifs</h6>
                            <h4 class="mb-0">{{ $inactiveSuppliers ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-pause-circle fa-2x" style="color: #212529;"></i>
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
            <form action="{{ route('suppliers.index') }}" method="GET" class="row g-3" id="searchForm">
                <div class="col-md-8">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nom, contact, email, téléphone, adresse..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Statut</label>
                    <select class="form-select" id="status" name="status" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les fournisseurs</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn w-100" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px;" title="Rechercher">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            <!-- Bouton pour réinitialiser les filtres -->
            @if(request('search') || request('status'))
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>
                            Réinitialiser les filtres
                        </a>
                        <small class="text-muted ms-2">
                            @if(request('search'))
                                Recherche: "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if(request('status'))
                                @if(request('search')) | @endif
                                Statut: <strong>{{ request('status') == 'active' ? 'Actifs' : 'Inactifs' }}</strong>
                            @endif
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des fournisseurs -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Liste des fournisseurs ({{ isset($suppliers) ? $suppliers->total() : 0 }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">Fournisseur</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Contact</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Coordonnées</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Produits</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Statut</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers ?? [] as $supplier)
                            <tr>
                                <td class="border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-truck text-white small"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $supplier->name ?? 'N/A' }}</strong>
                                            @if($supplier->notes)
                                                <br><small class="text-muted">{{ Str::limit($supplier->notes, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border-0">
                                    @if($supplier->contact_person)
                                        <span class="fw-medium">{{ $supplier->contact_person }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if($supplier->phone_number || $supplier->email)
                                        @if($supplier->phone_number)
                                            <div><i class="fas fa-phone me-1 text-muted"></i>{{ $supplier->phone_number }}</div>
                                        @endif
                                        @if($supplier->email)
                                            <div><i class="fas fa-envelope me-1 text-muted"></i>{{ $supplier->email }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Non renseignées</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <span class="badge {{ ($supplier->products_count ?? 0) > 0 ? 'bg-primary' : 'bg-secondary' }} rounded-pill">
                                        {{ $supplier->products_count ?? 0 }} produit(s)
                                    </span>
                                </td>
                                <td class="border-0">
                                    @php
                                        $statusClass = ($supplier->active ?? false) ? 'bg-success' : 'bg-secondary';
                                        $statusText = ($supplier->active ?? false) ? 'Actif' : 'Inactif';
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill">{{ $statusText }}</span>
                                </td>
                                <td class="border-0">
                                    <div class="btn-group" role="group">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm action-btn-view" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 6px 0 0 6px;" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Bouton Modifier -->
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm action-btn-edit" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; {{ ($supplier->products_count ?? 0) == 0 ? 'border-radius: 0;' : 'border-radius: 0 6px 6px 0;' }}" title="Modifier le fournisseur">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer - seulement si aucun produit -->
                                        @if(($supplier->products_count ?? 0) == 0)
                                            <button type="button" class="btn btn-sm action-btn-delete" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 0 6px 6px 0;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $supplier->id }}" title="Supprimer le fournisseur">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-inbox fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucun fournisseur trouvé</h5>
                                    @if(request('search') || request('status'))
                                        <p class="text-muted">Essayez de modifier vos critères de recherche ou 
                                            <a href="{{ route('suppliers.index') }}" class="text-decoration-none">réinitialisez les filtres</a>
                                        </p>
                                    @else
                                        <p class="text-muted">Commencez par ajouter votre premier fournisseur</p>
                                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mt-2" style="border-radius: 10px;">
                                            <i class="fas fa-plus me-1"></i>Ajouter un fournisseur
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($suppliers) && $suppliers->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $suppliers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modals de confirmation de suppression -->
@if(isset($suppliers))
    @foreach($suppliers as $supplier)
        @if(($supplier->products_count ?? 0) == 0)
            <div class="modal fade" id="deleteModal{{ $supplier->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $supplier->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $supplier->id }}">
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
    
    /* Animation pour les cartes de statistiques */
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    /* Style pour les badges */
    .badge.bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
    
    /* Style pour les alertes */
    .alert {
        border: none;
        border-radius: 12px;
    }
    
    /* Amélioration du formulaire de recherche */
    #searchForm .form-control,
    #searchForm .form-select {
        transition: all 0.3s ease;
    }
    
    #searchForm .form-control:focus,
    #searchForm .form-select:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(51, 102, 153, 0.2);
    }
    
    /* Style pour les boutons d'action */
    .btn-group .btn {
        position: relative;
        z-index: 1;
    }
    
    .action-btn-view:hover {
        background: linear-gradient(180deg, #2c5282 0%, #3d7bc6 100%) !important;
        z-index: 2;
    }
    
    .action-btn-edit:hover {
        background: linear-gradient(135deg, #1e7e34 0%, #1a9d84 100%) !important;
        z-index: 2;
    }
    
    .action-btn-delete:hover {
        background: linear-gradient(135deg, #c62828 0%, #ad1a1a 100%) !important;
        z-index: 2;
    }
    
    /* Espacement correct pour les boutons groupés */
    .btn-group .btn + .btn {
        margin-left: 0;
        border-left: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Correction de l'alignement des icônes */
    .btn i {
        font-size: 0.875rem;
    }
    
    /* Style pour les modales */
    .modal-backdrop {
        backdrop-filter: blur(3px);
    }
    
    .modal-dialog {
        margin: 1.75rem auto;
    }
    
    /* Responsivité améliorée */
    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        
        .btn-group .btn {
            border-radius: 6px !important;
            margin-bottom: 2px;
            border-left: none !important;
        }
        
        .btn-group .btn:last-child {
            margin-bottom: 0;
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit du formulaire lors du changement de statut
    const statusSelect = document.getElementById('status');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    }
    
    // Recherche en temps réel (optionnel)
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                // Optionnel: soumission automatique après 1 seconde d'inactivité
                // document.getElementById('searchForm').submit();
            }, 1000);
        });
    }
    
    // Animation des cartes de statistiques
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Amélioration de l'accessibilité des modales
    const deleteModals = document.querySelectorAll('[id^="deleteModal"]');
    deleteModals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const deleteButton = this.querySelector('button[type="submit"]');
            if (deleteButton) {
                deleteButton.focus();
            }
        });
    });
    
    // Confirmation avant suppression
    const deleteButtons = document.querySelectorAll('button[data-bs-toggle="modal"][data-bs-target^="#deleteModal"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Optionnel: ajouter une confirmation supplémentaire
            console.log('Modal de suppression ouverte');
        });
    });
    
    // Animation smooth pour les alertes
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
});
</script>
@endsection