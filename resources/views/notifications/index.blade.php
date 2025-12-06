@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-bell text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">
                        Notifications
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2" style="border-radius: 50px;">{{ $unreadCount }}</span>
                        @endif
                    </h2>
                    <small class="text-muted">Centre de notifications et alertes</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <!-- Bouton Marquer tout comme lu avec formulaire POST -->
                @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn text-white fw-semibold me-2" 
                                style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;"
                                onclick="return confirm('Marquer toutes les notifications comme lues ?')">
                            <i class="fas fa-check-double me-1"></i>Tout marquer lu
                        </button>
                    </form>
                @endif
                
                <!-- Bouton Supprimer les lues avec formulaire DELETE -->
                @if($readCount > 0)
                    <form method="POST" action="{{ route('notifications.delete-read') }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn text-white fw-semibold"
                                style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); transition: all 0.3s ease;"
                                onclick="return confirm('Supprimer toutes les notifications lues ?')">
                            <i class="fas fa-trash me-1"></i>Supprimer lues
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
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
                            <h6 class="card-title opacity-75">Total notifications</h6>
                            <h4 class="mb-0">{{ $totalCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Non lues</h6>
                            <h4 class="mb-0">{{ $unreadCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-circle fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Haute priorité</h6>
                            <h4 class="mb-0">{{ $highPriorityCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle fa-2x" style="color: #212529;"></i>
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
                            <h6 class="card-title opacity-75">Aujourd'hui</h6>
                            <h4 class="mb-0">{{ $todayCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-day fa-2x"></i>
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
            <form method="GET" class="row g-3" id="filterForm">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les types</option>
                        <option value="stock_alert" {{ request('type') == 'stock_alert' ? 'selected' : '' }}>Alerte Stock</option>
                        <option value="expiry_alert" {{ request('type') == 'expiry_alert' ? 'selected' : '' }}>Expiration</option>
                        <option value="sale_created" {{ request('type') == 'sale_created' ? 'selected' : '' }}>Vente</option>
                        <option value="prescription_ready" {{ request('type') == 'prescription_ready' ? 'selected' : '' }}>Ordonnance</option>
                        <option value="purchase_received" {{ request('type') == 'purchase_received' ? 'selected' : '' }}>Livraison</option>
                        <option value="system_alert" {{ request('type') == 'system_alert' ? 'selected' : '' }}>Système</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Statut</label>
                    <select name="status" class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Toutes</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Non lues</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lues</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Priorité</label>
                    <select name="priority" class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Toutes</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Élevée</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normale</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Faible</option>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn w-50 me-2" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary w-50" style="border-radius: 10px; border: 2px solid #6c757d;">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </form>
            
            <!-- Affichage des filtres actifs -->
            @if(request('type') || request('status') || request('priority'))
                <div class="row mt-3">
                    <div class="col-12">
                        <span class="text-muted">Filtres actifs:</span>
                        @if(request('type'))
                            <span class="badge bg-primary ms-1">Type: {{ ucfirst(str_replace('_', ' ', request('type'))) }}</span>
                        @endif
                        @if(request('status'))
                            <span class="badge bg-info ms-1">Statut: {{ request('status') == 'unread' ? 'Non lues' : 'Lues' }}</span>
                        @endif
                        @if(request('priority'))
                            <span class="badge bg-warning ms-1">Priorité: {{ ucfirst(request('priority')) }}</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des notifications -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Notifications ({{ $notifications ? $notifications->total() : 0 }})
            </h5>
        </div>
        <div class="card-body p-0">
            @if($notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <div class="list-group-item border-0 {{ !$notification->isRead() ? 'bg-light' : '' }}" style="transition: all 0.2s ease;">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3" style="width: 40px; height: 40px; background: linear-gradient(180deg, {{ $notification->priority == 'high' ? '#dc3545, #c82333' : ($notification->priority == 'medium' ? '#ffc107, #fd7e14' : '#336699, #4a90e2') }}); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $notification->type_icon ?? 'fas fa-bell' }} text-white"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 {{ !$notification->isRead() ? 'fw-bold' : '' }}" style="color: #2c3e50;">
                                                {{ $notification->title }}
                                                @if(!$notification->isRead())
                                                    <span class="badge bg-primary ms-2" style="border-radius: 50px; font-size: 0.7rem;">Nouveau</span>
                                                @endif
                                            </h6>
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge {{ $notification->priority_badge ?? 'bg-secondary' }} me-2" style="border-radius: 50px;">
                                                    {{ $notification->priority_label ?? ucfirst($notification->priority ?? 'Normal') }}
                                                </span>
                                                <span class="badge bg-secondary" style="border-radius: 50px;">
                                                    {{ $notification->type_label ?? ucfirst(str_replace('_', ' ', $notification->type ?? '')) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="mb-2 text-muted" style="padding-left: 52px;">{{ $notification->message }}</p>
                                    
                                    <small class="text-muted" style="padding-left: 52px;">
                                        <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <div class="dropdown ms-3">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" data-bs-toggle="dropdown"
                                            style="border-radius: 8px;">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu shadow" style="border-radius: 10px; border: none; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                                        @if(!$notification->isRead())
                                            <li>
                                                <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}" class="m-0">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-check me-2 text-success"></i>Marquer comme lu
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        
                                        @if($notification->action_url)
                                            <li>
                                                <a class="dropdown-item" href="{{ $notification->action_url }}">
                                                    <i class="fas fa-external-link-alt me-2 text-primary"></i>Voir détails
                                                </a>
                                            </li>
                                        @endif
                                        
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Supprimer cette notification ?')">
                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-bell-slash fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-2" style="font-family: 'Poppins', sans-serif;">Aucune notification</h5>
                    @if(request('type') || request('status') || request('priority'))
                        <p class="text-muted">Aucune notification trouvée avec ces filtres.</p>
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary mt-2" style="border-radius: 10px;">
                            <i class="fas fa-times me-1"></i>Réinitialiser les filtres
                        </a>
                    @else
                        <p class="text-muted">Vous n'avez aucune notification pour le moment.</p>
                        
                        @if(app()->environment('local'))
                            <form method="POST" action="{{ route('notifications.test') }}" class="mt-3">
                                @csrf
                                <button type="submit" class="btn text-white fw-semibold"
                                        style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);">
                                    <i class="fas fa-plus me-1"></i>Créer une notification de test
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            @endif
        </div>
        
        @if($notifications->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $notifications->appends(request()->query())->links() }}
            </div>
        @endif
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
    
    .list-group-item {
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(51, 102, 153, 0.05) !important;
        transform: scale(1.002);
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
    
    .dropdown-menu {
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
    
    .dropdown-item:hover {
        background-color: rgba(51, 102, 153, 0.1);
    }
    
    /* Harmonisation avec le sidebar */
    .text-primary {
        color: #336699 !important;
    }
    
    .bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
    
    /* Animation pour les notifications non lues */
    .list-group-item.bg-light {
        background: linear-gradient(135deg, rgba(51, 102, 153, 0.05) 0%, rgba(74, 144, 226, 0.03) 100%) !important;
        border-left: 4px solid #336699;
    }
    
    /* Animation pour les cartes de statistiques */
    .card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    /* Style pour les alertes */
    .alert {
        border: none;
        border-radius: 12px;
    }
    
    /* Amélioration du formulaire de filtres */
    #filterForm .form-select {
        transition: all 0.3s ease;
    }
    
    #filterForm .form-select:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(51, 102, 153, 0.2);
    }
    
    /* Style pour les badges de filtres actifs */
    .badge.bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
        color: #212529 !important;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit des filtres lors du changement
    const filterSelects = document.querySelectorAll('#filterForm select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Optionnel: soumission automatique du formulaire
            // document.getElementById('filterForm').submit();
        });
    });
    
    // Animation des cartes de statistiques
    const statCards = document.querySelectorAll('.card[onmouseover]');
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
    
    // Marquer une notification comme lue au clic sur le titre
    const notificationTitles = document.querySelectorAll('.list-group-item h6');
    notificationTitles.forEach(title => {
        title.addEventListener('click', function() {
            const listItem = this.closest('.list-group-item');
            if (listItem.classList.contains('bg-light')) {
                // C'est une notification non lue, proposer de la marquer comme lue
                const notificationId = this.closest('[data-notification-id]')?.dataset.notificationId;
                if (notificationId && confirm('Marquer cette notification comme lue ?')) {
                    // Créer un formulaire et le soumettre
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/notifications/${notificationId}/mark-read`;
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken.content;
                        form.appendChild(csrfInput);
                    }
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        });
    });
    
    // Actualisation automatique du nombre de notifications (optionnel)
    if (typeof updateNotificationCount === 'function') {
        setInterval(updateNotificationCount, 30000); // Toutes les 30 secondes
    }
});

// Fonction pour actualiser le compteur de notifications (à implémenter si nécessaire)
function updateNotificationCount() {
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.badge.bg-danger');
            if (data.count > 0) {
                if (badge) {
                    badge.textContent = data.count;
                } else {
                    // Créer le badge s'il n'existe pas
                    const title = document.querySelector('h2');
                    const newBadge = document.createElement('span');
                    newBadge.className = 'badge bg-danger ms-2';
                    newBadge.style.borderRadius = '50px';
                    newBadge.textContent = data.count;
                    title.appendChild(newBadge);
                }
            } else if (badge) {
                badge.remove();
            }
        })
        .catch(error => console.error('Erreur lors de la mise à jour du compteur:', error));
}
</script>
@endsection