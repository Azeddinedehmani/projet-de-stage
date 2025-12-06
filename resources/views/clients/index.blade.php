@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-users text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Gestion des clients</h2>
                    <small class="text-muted">Suivi et gestion des patients</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('clients.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-plus me-1"></i> Nouveau client
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
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total clients</h6>
                            <h4 class="mb-0">{{ isset($clientStats) ? $clientStats['total'] : ($clients->total() ?? 0) }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Clients actifs</h6>
                            <h4 class="mb-0">{{ isset($clientStats) ? $clientStats['active'] : 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-check fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Avec allergies</h6>
                            <h4 class="mb-0">{{ isset($clientStats) ? $clientStats['with_allergies'] : 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Revenus totaux</h6>
                            <h4 class="mb-0">{{ number_format((isset($clientStats) ? $clientStats['total_revenue'] : 0), 0) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-euro-sign fa-2x" style="color: #212529;"></i>
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
            <form action="{{ route('clients.index') }}" method="GET" class="row g-3" id="searchForm">
               <div class="col-md-8">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nom, prénom, email, téléphone..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Statut</label>
                    <select class="form-select" id="status" name="status" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les clients</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn w-100" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            <!-- Bouton pour réinitialiser les filtres -->
            @if(request('search') || request('status'))
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-1"></i>
                            Réinitialiser les filtres
                        </a>
                        <small class="text-muted ms-2">
                            Résultats filtrés : {{ $clients->total() }} client(s) trouvé(s)
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des clients -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Liste des clients ({{ isset($clients) ? $clients->total() : 0 }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">Client</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Contact</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Âge</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Assurance</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Total dépensé</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Statut</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients ?? [] as $client)
                            <tr>
                                <td class="border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user text-white small"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $client->full_name ?? ($client->first_name . ' ' . $client->last_name) }}</strong>
                                            @if($client->allergies && trim($client->allergies) !== '')
                                                <br><small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Allergies
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border-0">
                                    @if($client->email || $client->phone)
                                        @if($client->email)
                                            <div><i class="fas fa-envelope me-1 text-muted"></i>{{ $client->email }}</div>
                                        @endif
                                        @if($client->phone)
                                            <div><i class="fas fa-phone me-1 text-muted"></i>{{ $client->phone }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Non renseignées</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if($client->date_of_birth)
                                        {{ \Carbon\Carbon::parse($client->date_of_birth)->age }} ans
                                    @elseif(isset($client->age))
                                        {{ $client->age }} ans
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    {{ $client->insurance_number ?? 'N/A' }}
                                </td>
                                <td class="border-0">
                                    <span class="fw-bold text-success">{{ number_format($client->total_spent ?? 0, 2) }} €</span>
                                </td>
                                <td class="border-0">
                                    @php
                                        $statusClass = ($client->active ?? false) ? 'bg-success' : 'bg-secondary';
                                        $statusText = ($client->active ?? false) ? 'Actif' : 'Inactif';
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill">{{ $statusText }}</span>
                                </td>
                                <td class="border-0">
                                    <div class="btn-group">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none;" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Bouton Modifier -->
                                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none;" title="Modifier le client">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Nouvelle vente -->
                                        <a href="{{ route('sales.create', ['client_id' => $client->id]) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none;" title="Nouvelle vente">
                                            <i class="fas fa-cash-register"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <button type="button" class="btn btn-sm btn-delete-client" 
                                                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none;" 
                                                data-client-id="{{ $client->id }}" 
                                                data-client-name="{{ $client->full_name ?? ($client->first_name . ' ' . $client->last_name) }}"
                                                title="Supprimer le client">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-user-slash fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucun client trouvé</h5>
                                    @if(request('search') || request('status'))
                                        <p class="text-muted">Aucun client ne correspond à vos critères de recherche</p>
                                        <a href="{{ route('clients.index') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-times me-1"></i>
                                            Voir tous les clients
                                        </a>
                                    @else
                                        <p class="text-muted">Commencez par ajouter votre premier client</p>
                                        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>
                                            Ajouter un client
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($clients) && $clients->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $clients->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de confirmation de suppression UNIQUE -->
<div class="modal fade" id="deleteClientModal" tabindex="-1">
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
                <p>Êtes-vous sûr de vouloir supprimer le client <strong id="clientNameToDelete"></strong>?</p>
                <p><strong>Conséquences :</strong></p>
                <ul>
                    <li>Le client sera définitivement supprimé</li>
                    <li>L'historique des ventes sera conservé</li>
                    <li>Cette action ne peut pas être annulée</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                <form id="deleteClientForm" method="POST" style="display: inline;">
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
    
    /* Amélioration de la recherche */
    #searchForm .form-control {
        transition: all 0.3s ease;
    }
    
    #searchForm .form-control:focus {
        transform: scale(1.02);
    }
    
    /* Animation pour les statistiques */
    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit du formulaire de recherche avec délai
    let searchTimeout;
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const searchForm = document.getElementById('searchForm');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                // Optionnel : auto-submit après 1 seconde de non-activité
                // searchForm.submit();
            }, 1000);
        });
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            searchForm.submit();
        });
    }
    
    // Gestion uniforme de la suppression
    const deleteButtons = document.querySelectorAll('.btn-delete-client');
    const deleteModal = document.getElementById('deleteClientModal');
    const deleteForm = document.getElementById('deleteClientForm');
    const clientNameElement = document.getElementById('clientNameToDelete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const clientId = this.getAttribute('data-client-id');
            const clientName = this.getAttribute('data-client-name');
            
            // Mettre à jour le contenu de la modale
            clientNameElement.textContent = clientName;
            deleteForm.action = `/clients/${clientId}`;
            
            // Afficher la modale
            const modal = new bootstrap.Modal(deleteModal);
            modal.show();
        });
    });
    
    // Amélioration de l'UX des modales
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function() {
            // Focus sur le bouton d'annulation par défaut
            setTimeout(() => {
                const cancelBtn = deleteModal.querySelector('.btn-secondary');
                if (cancelBtn) cancelBtn.focus();
            }, 500);
        });
    }
    
    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K pour focus sur la recherche
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // Escape pour réinitialiser la recherche ou fermer la modale
        if (e.key === 'Escape') {
            if (document.activeElement === searchInput) {
                searchInput.value = '';
                // Optionnel : auto-submit
                // searchForm.submit();
            }
        }
    });
});
</script>
@endsection