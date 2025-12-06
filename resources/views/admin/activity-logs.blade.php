@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-history text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Logs d'activité du système</h2>
                    <small class="text-muted">Surveillance complète de toutes les activités des utilisateurs</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <button type="button" class="btn text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#clearLogsModal" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-trash me-1"></i> Nettoyer
            </button>
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
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ number_format($activities->total()) }}</h4>
                    <small class="opacity-75">Total activités</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-calendar-day fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ \App\Models\ActivityLog::whereDate('created_at', today())->count() }}</h4>
                    <small class="opacity-75">Aujourd'hui</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ \App\Models\ActivityLog::whereIn('action', ['view', 'view_form'])->whereDate('created_at', today())->count() }}</h4>
                    <small class="opacity-75">Consultations</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-edit fa-2x" style="color: #212529;"></i>
                    </div>
                    <h4 class="mb-1">{{ \App\Models\ActivityLog::whereIn('action', ['create', 'update', 'delete'])->whereDate('created_at', today())->count() }}</h4>
                    <small class="opacity-75">Modifications</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ \App\Models\ActivityLog::whereDate('created_at', '>=', now()->subDays(7))->count() }}</h4>
                    <small class="opacity-75">7 derniers jours</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres avancés -->
    <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-filter me-2" style="color: #336699;"></i>
                Filtres et recherche
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.activity-logs') }}" method="GET" class="row g-3" id="filterForm">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Description, action..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-2">
                    <label for="user_id" class="form-label fw-semibold">Utilisateur</label>
                    <select class="form-select" id="user_id" name="user_id" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les utilisateurs</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="action" class="form-label fw-semibold">Action</label>
                    <select class="form-select" id="action" name="action" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Toutes les actions</option>
                        @foreach($actions as $actionOption)
                            @php
                                $actionLabel = match($actionOption) {
                                    'view' => 'Consultation',
                                    'view_form' => 'Formulaire',
                                    'create' => 'Création',
                                    'update' => 'Modification',
                                    'delete' => 'Suppression',
                                    'export' => 'Export',
                                    'print' => 'Impression',
                                    'login' => 'Connexion',
                                    'logout' => 'Déconnexion',
                                    default => ucfirst($actionOption)
                                };
                            @endphp
                            <option value="{{ $actionOption }}" {{ request('action') == $actionOption ? 'selected' : '' }}>
                                {{ $actionLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="model_type" class="form-label fw-semibold">Type de modèle</label>
                    <select class="form-select" id="model_type" name="model_type" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les types</option>
                        @foreach($modelTypes as $modelType)
                            @php
                                $displayName = match($modelType) {
                                    'App\Models\User' => 'Utilisateur',
                                    'App\Models\Product' => 'Produit',
                                    'App\Models\Sale' => 'Vente',
                                    'App\Models\Client' => 'Client',
                                    'App\Models\Prescription' => 'Ordonnance',
                                    'App\Models\Purchase' => 'Achat',
                                    'App\Models\Supplier' => 'Fournisseur',
                                    'App\Models\Notification' => 'Notification',
                                    'App\Models\Category' => 'Catégorie',
                                    'App\Models\SystemSetting' => 'Paramètre système',
                                    default => class_basename($modelType)
                                };
                            @endphp
                            <option value="{{ $modelType }}" {{ request('model_type') == $modelType ? 'selected' : '' }}>
                                {{ $displayName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="date_from" class="form-label fw-semibold">Du</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-1">
                    <label for="date_to" class="form-label fw-semibold">Au</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
            </form>
            
            <!-- Actions rapides -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.activity-logs', ['action' => 'view']) }}" 
                       class="btn btn-sm {{ request('action') == 'view' ? 'btn-info' : 'btn-outline-info' }}" style="border-radius: 8px; margin-right: 5px;">
                        <i class="fas fa-eye me-1"></i>Consultations
                    </a>
                    <a href="{{ route('admin.activity-logs', ['action' => 'create']) }}" 
                       class="btn btn-sm {{ request('action') == 'create' ? 'btn-success' : 'btn-outline-success' }}" style="border-radius: 8px; margin-right: 5px;">
                        <i class="fas fa-plus me-1"></i>Créations
                    </a>
                    <a href="{{ route('admin.activity-logs', ['action' => 'update']) }}" 
                       class="btn btn-sm {{ request('action') == 'update' ? 'btn-warning' : 'btn-outline-warning' }}" style="border-radius: 8px; margin-right: 5px;">
                        <i class="fas fa-edit me-1"></i>Modifications
                    </a>
                    <a href="{{ route('admin.activity-logs', ['action' => 'delete']) }}" 
                       class="btn btn-sm {{ request('action') == 'delete' ? 'btn-danger' : 'btn-outline-danger' }}" style="border-radius: 8px; margin-right: 5px;">
                        <i class="fas fa-trash me-1"></i>Suppressions
                    </a>
                    <a href="{{ route('admin.activity-logs', ['date_from' => today()->format('Y-m-d')]) }}" 
                       class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                        <i class="fas fa-calendar-day me-1"></i>Aujourd'hui
                    </a>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" form="filterForm" class="btn" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px 20px;">
                        <i class="fas fa-search me-1"></i> Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'user_id', 'action', 'model_type', 'date_from', 'date_to']))
                        <a href="{{ route('admin.activity-logs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Réinitialiser
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Table des activités -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Historique des activités ({{ number_format($activities->total()) }})
                @if(request()->hasAny(['search', 'user_id', 'action', 'model_type', 'date_from', 'date_to']))
                    <span class="badge bg-info rounded-pill">Filtré</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">Date/Heure</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Utilisateur</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Action</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Description</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Modèle</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Adresse IP</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr class="table-row border-0 {{ in_array($activity->action, ['create', 'update', 'delete']) ? 'table-warning' : '' }}">
                                <td class="border-0">
                                    <div style="font-size: 0.9em;">
                                        {{ $activity->created_at->format('d/m/Y') }}
                                        <br>{{ $activity->created_at->format('H:i:s') }}
                                    </div>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="border-0">
                                    @if($activity->user)
                                        <div class="d-flex align-items-center">
                                            @if($activity->user->profile_photo)
                                                <img src="{{ asset('storage/'.$activity->user->profile_photo) }}" 
                                                     alt="{{ $activity->user->name }}" 
                                                     class="rounded-circle me-2 user-avatar" 
                                                     style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #336699;">
                                            @else
                                                <div class="me-2 user-avatar" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                                </div>
                                            @endif
                                            <div style="font-size: 0.9em;">
                                                <div class="fw-medium">{{ Str::limit($activity->user->name, 15) }}</div>
                                                <small class="text-muted">
                                                    {{ $activity->user->role === 'responsable' ? 'Admin' : 'Pharmacien' }}
                                                </small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 32px; height: 32px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                                                <i class="fas fa-cog"></i>
                                            </div>
                                            <small class="text-muted">Système</small>
                                        </div>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <span class="badge {{ $activity->action_badge ?? 'bg-secondary' }} rounded-pill">
                                        <i class="{{ $activity->action_icon ?? 'fas fa-circle' }} me-1"></i>
                                        {{ $activity->action_label ?? ucfirst($activity->action) }}
                                    </span>
                                    @if(in_array($activity->action, ['create', 'update', 'delete']))
                                        <br><small class="text-danger fw-medium"><i class="fas fa-exclamation-triangle"></i> Important</small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <div style="max-width: 350px;">
                                        {{ $activity->description }}
                                    </div>
                                    @if($activity->model_id && $activity->model_type)
                                        <br><small class="text-muted">
                                            ID: {{ $activity->model_id }}
                                            @if($activity->model)
                                                - {{ method_exists($activity->model, 'name') ? $activity->model->name : (method_exists($activity->model, 'title') ? $activity->model->title : '') }}
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if($activity->model_type)
                                        <span class="badge bg-light text-dark rounded-pill">
                                            {{ $activity->model_name ?? class_basename($activity->model_type) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if($activity->ip_address)
                                        <code style="font-size: 0.8em; background-color: #f8f9fa; padding: 2px 6px; border-radius: 4px;">{{ $activity->ip_address }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <div class="btn-group action-buttons">
                                        @if($activity->old_values || $activity->new_values || $activity->user_agent)
                                            <button type="button" 
                                                    class="btn btn-sm action-btn activity-detail-btn" 
                                                    style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 8px;" 
                                                    data-activity-id="{{ $activity->id }}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#activityDetailModal"
                                                    title="Voir les détails">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-history fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucune activité trouvée</h5>
                                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                                    @if(request()->hasAny(['search', 'user_id', 'action', 'model_type', 'date_from', 'date_to']))
                                        <a href="{{ route('admin.activity-logs') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-times me-1"></i> Réinitialiser les filtres
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($activities->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal unique pour les détails d'activité -->
<div class="modal fade" id="activityDetailModal" tabindex="-1" aria-labelledby="activityDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #336699 0%, #4a90e2 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" id="activityDetailModalLabel">
                    <i class="fas fa-info-circle me-2"></i>
                    Détails de l'activité
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="activityDetailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2 text-muted">Chargement des détails...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de nettoyage des logs -->
<div class="modal fade" id="clearLogsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-trash me-2"></i>
                    Nettoyer les logs d'activité
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.clear-old-logs') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning border-0" style="border-radius: 10px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Cette action supprimera définitivement les logs d'activité anciens.
                    </div>
                    
                    <div class="mb-3">
                        <label for="days" class="form-label fw-semibold">Supprimer les logs de plus de:</label>
                        <select class="form-select" id="days" name="days" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                            <option value="30">30 jours</option>
                            <option value="60">60 jours</option>
                            <option value="90" selected>90 jours</option>
                            <option value="180">180 jours</option>
                            <option value="365">1 an</option>
                        </select>
                        <div class="form-text">
                            Les logs récents seront conservés pour la surveillance de sécurité.
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmClear" required style="border-radius: 4px;">
                        <label class="form-check-label fw-medium" for="confirmClear">
                            Je comprends que cette action est irréversible
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                        <i class="fas fa-trash me-1"></i> Nettoyer les logs
                    </button>
                </div>
            </form>
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
        transition: all 0.3s ease;
    }
    
    .badge:hover {
        transform: scale(1.05);
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
    
    /* Profile photo styling */
    .user-avatar {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .user-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);
    }
    
    .user-avatar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s;
    }
    
    .user-avatar:hover::after {
        transform: translateX(100%);
    }
    
    /* Enhanced button group styling */
    .action-buttons {
        display: flex;
        gap: 2px;
        flex-wrap: wrap;
    }
    
    .action-btn {
        margin: 0 !important;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px) scale(1.05);
        z-index: 10;
        position: relative;
    }
    
    /* Enhanced modal animations */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: translate(0, -50px);
    }
    
    .modal.show .modal-dialog {
        transform: none;
    }
    
    /* Statistics cards enhancements */
    .stats-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        border-radius: 17px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stats-card:hover::before {
        opacity: 1;
    }
    
    /* Enhanced table styling */
    .table tbody tr {
        border-bottom: 1px solid rgba(51, 102, 153, 0.1);
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    .table-row {
        transition: all 0.3s ease;
    }
    
    .table-row:hover {
        background: linear-gradient(90deg, rgba(51, 102, 153, 0.02) 0%, rgba(51, 102, 153, 0.05) 50%, rgba(51, 102, 153, 0.02) 100%);
    }
    
    /* Form enhancements */
    .form-control,
    .form-select {
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }
    
    .form-control:hover,
    .form-select:hover {
        border-color: #336699;
        box-shadow: 0 2px 8px rgba(51, 102, 153, 0.1);
    }
    
    /* Loading states */
    .btn.loading {
        position: relative;
        color: transparent !important;
    }
    
    .btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    /* Enhanced animations */
    @keyframes modalSlideIn {
        from {
            transform: translate(0, -50px);
            opacity: 0;
        }
        to {
            transform: translate(0, 0);
            opacity: 1;
        }
    }
    
    @keyframes modalSlideOut {
        from {
            transform: translate(0, 0);
            opacity: 1;
        }
        to {
            transform: translate(0, -50px);
            opacity: 0;
        }
    }
    
    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    
    .pulse-animation {
        animation: pulse 0.6s ease-in-out;
    }
    
    /* Search highlight */
    mark {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: #212529;
        padding: 2px 4px;
        border-radius: 3px;
        font-weight: 500;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 100%;
        }
        
        .action-btn {
            width: 100%;
            border-radius: 10px !important;
            margin-bottom: 2px;
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .stats-card {
            margin-bottom: 15px;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .btn-group .btn {
            margin: 0;
            border-radius: 10px !important;
        }
    }
    
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        
        .table {
            font-size: 12px;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        .action-btn {
            padding: 8px 12px;
        }
    }
    
    /* Dark mode support (future) */
    @media (prefers-color-scheme: dark) {
        .card {
            background: rgba(33, 37, 41, 0.95) !important;
            color: #fff;
        }
        
        .table {
            color: #fff;
        }
        
        .text-muted {
            color: #adb5bd !important;
        }
    }
    
    /* Print styles */
    @media print {
        .btn,
        .modal,
        .action-buttons {
            display: none !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        
        .table {
            font-size: 12px;
        }
    }
    
    /* Focus management for accessibility */
    .btn:focus,
    .form-control:focus,
    .form-select:focus {
        outline: 2px solid #336699;
        outline-offset: 2px;
    }
    
    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .btn {
            border: 2px solid currentColor;
        }
        
        .card {
            border: 2px solid #000;
        }
        
        .table th,
        .table td {
            border: 1px solid #000;
        }
    }
    
    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
// Données des activités pour le modal
const activitiesData = {
    @foreach($activities as $activity)
    {{ $activity->id }}: {
        id: {{ $activity->id }},
        created_at: '{{ $activity->created_at->format('d/m/Y H:i:s') }}',
        user_name: '{{ $activity->user->name ?? 'Système' }}',
        action: '{{ $activity->action }}',
        action_label: '{{ $activity->action_label ?? $activity->action }}',
        action_badge: '{{ $activity->action_badge ?? 'bg-secondary' }}',
        description: {!! json_encode($activity->description) !!},
        ip_address: '{{ $activity->ip_address ?? 'N/A' }}',
        model_type: '{{ $activity->model_type }}',
        model_name: '{{ $activity->model_name ?? class_basename($activity->model_type ?? '') }}',
        model_id: '{{ $activity->model_id }}',
        user_agent: {!! json_encode($activity->user_agent ?? '') !!},
        old_values: @if($activity->old_values) {!! json_encode($activity->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!} @else null @endif,
        new_values: @if($activity->new_values) {!! json_encode($activity->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!} @else null @endif
    },
    @endforeach
};

document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const searchInput = document.getElementById('search');
    const userSelect = document.getElementById('user_id');
    const actionSelect = document.getElementById('action');
    const modelTypeSelect = document.getElementById('model_type');
    const filterForm = document.getElementById('filterForm');
    const tableRows = document.querySelectorAll('.table-row');
    
    // Gestionnaire pour les boutons de détails d'activité
    const activityDetailButtons = document.querySelectorAll('.activity-detail-btn');
    const activityDetailModal = document.getElementById('activityDetailModal');
    const activityDetailContent = document.getElementById('activityDetailContent');
    
    activityDetailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const activityId = this.getAttribute('data-activity-id');
            const activityData = activitiesData[activityId];
            
            if (activityData) {
                loadActivityDetails(activityData);
            } else {
                showError('Données d\'activité non trouvées');
            }
        });
    });
    
    function loadActivityDetails(activity) {
        const content = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold" style="color: #336699;">Informations générales</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between border-0">
                            <strong>Date:</strong>
                            <span>${activity.created_at}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between border-0">
                            <strong>Utilisateur:</strong>
                            <span>${activity.user_name}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between border-0">
                            <strong>Action:</strong>
                            <span class="badge ${activity.action_badge} rounded-pill">${activity.action_label}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between border-0">
                            <strong>IP:</strong>
                            <span>${activity.ip_address}</span>
                        </li>
                        ${activity.model_type ? `
                        <li class="list-group-item d-flex justify-content-between border-0">
                            <strong>Modèle:</strong>
                            <span>${activity.model_name} (ID: ${activity.model_id})</span>
                        </li>
                        ` : ''}
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold" style="color: #336699;">Description complète</h6>
                    <p style="background-color: #f8f9fa; padding: 10px; border-radius: 8px;">${activity.description}</p>
                    
                    ${activity.user_agent ? `
                        <h6 class="fw-bold" style="color: #336699;">Navigateur/Agent</h6>
                        <small class="text-muted" style="background-color: #f8f9fa; padding: 5px; border-radius: 4px; display: block; word-break: break-all;">${activity.user_agent.substring(0, 150)}${activity.user_agent.length > 150 ? '...' : ''}</small>
                    ` : ''}
                </div>
            </div>
            
            ${activity.old_values || activity.new_values ? `
                <hr style="margin: 20px 0;">
                <div class="row">
                    ${activity.old_values ? `
                        <div class="col-md-6">
                            <h6 class="text-danger fw-bold">Anciennes valeurs</h6>
                            <pre class="bg-light p-2 small" style="max-height: 300px; overflow-y: auto; border-radius: 8px; border: 1px solid #dee2e6;">${activity.old_values}</pre>
                        </div>
                    ` : ''}
                    
                    ${activity.new_values ? `
                        <div class="col-md-6">
                            <h6 class="text-success fw-bold">Nouvelles valeurs</h6>
                            <pre class="bg-light p-2 small" style="max-height: 300px; overflow-y: auto; border-radius: 8px; border: 1px solid #dee2e6;">${activity.new_values}</pre>
                        </div>
                    ` : ''}
                </div>
            ` : ''}
        `;
        
        activityDetailContent.innerHTML = content;
    }
    
    function showError(message) {
        activityDetailContent.innerHTML = `
            <div class="text-center py-4">
                <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                </div>
                <h5 class="text-danger mb-2">Erreur</h5>
                <p class="text-muted">${message}</p>
            </div>
        `;
    }
    
    // Réinitialiser le contenu du modal à chaque fermeture
    if (activityDetailModal) {
        activityDetailModal.addEventListener('hidden.bs.modal', function() {
            activityDetailContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2 text-muted">Chargement des détails...</p>
                </div>
            `;
        });
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.parentNode) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    
    // Enhanced search with debouncing
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.toLowerCase();
            
            // Visual feedback
            if (searchTerm.length > 2) {
                this.style.borderColor = '#28a745';
                this.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
            } else if (searchTerm.length > 0) {
                this.style.borderColor = '#ffc107';
                this.style.boxShadow = '0 0 0 0.2rem rgba(255, 193, 7, 0.25)';
            } else {
                this.style.borderColor = '#e9ecef';
                this.style.boxShadow = 'none';
            }
            
            // Debounced search
            searchTimeout = setTimeout(() => {
                if (searchTerm.length >= 3) {
                    highlightSearchResults(searchTerm);
                } else {
                    clearHighlights();
                }
            }, 300);
        });
        
        // Submit form on Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterForm.submit();
            }
        });
    }
    
    // Auto-submit on select changes (optional)
    const autoSubmitSelects = [userSelect, actionSelect, modelTypeSelect];
    autoSubmitSelects.forEach(select => {
        if (select) {
            select.addEventListener('change', function() {
                // Optional: uncomment next line for auto-submit
                // filterForm.submit();
            });
        }
    });
    
    // Enhanced button animations
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-2px)';
            }
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
        
        button.addEventListener('mousedown', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(0) scale(0.98)';
            }
        });
        
        button.addEventListener('mouseup', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-2px) scale(1)';
            }
        });
    });
    
    // Enhanced modal animations
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            const modalDialog = this.querySelector('.modal-dialog');
            modalDialog.style.animation = 'modalSlideIn 0.3s ease-out';
        });
        
        modal.addEventListener('hide.bs.modal', function() {
            const modalDialog = this.querySelector('.modal-dialog');
            modalDialog.style.animation = 'modalSlideOut 0.3s ease-in';
        });
    });
    
    // Enhanced stats cards interactions
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.add('pulse-animation');
            setTimeout(() => {
                this.classList.remove('pulse-animation');
            }, 600);
        });
    });
    
    // Add loading states to form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                addLoadingState(submitButton);
            }
        });
    });
    
    // Smooth scroll to top when pagination is clicked
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
    
    // Keyboard shortcuts (removed Ctrl+E for export)
    document.addEventListener('keydown', function(e) {
        // Ctrl+F to focus search
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
                showNotification('Recherche activée', 'info');
            }
        }
        
        // Escape to clear search/filters
        if (e.key === 'Escape' && !document.querySelector('.modal.show')) {
            if (searchInput && searchInput === document.activeElement) {
                searchInput.value = '';
                clearHighlights();
                showNotification('Recherche effacée', 'info');
            }
        }
        
        // Ctrl+R to reset filters
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            const resetLink = document.querySelector('a[href*="activity-logs"]:not([href*="?"])');
            if (resetLink) {
                window.location.href = resetLink.href;
            }
        }
    });
    
    // Enhanced tooltip functionality
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add tooltips to action buttons without existing titles
    const actionButtons = document.querySelectorAll('.action-btn:not([title])');
    actionButtons.forEach(button => {
        const icon = button.querySelector('i');
        if (icon && icon.classList.contains('fa-info-circle')) {
            button.setAttribute('title', 'Voir les détails');
            new bootstrap.Tooltip(button);
        }
    });
    
    // Performance monitoring
    const performanceObserver = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
            if (entry.entryType === 'navigation') {
                console.log(`Page load time: ${entry.loadEventEnd - entry.loadEventStart}ms`);
            }
        }
    });
    
    try {
        performanceObserver.observe({ entryTypes: ['navigation'] });
    } catch (e) {
        // PerformanceObserver not supported
    }
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe table rows for scroll animations
    tableRows.forEach(row => {
        observer.observe(row);
    });
    
    // Enhanced error handling
    window.addEventListener('error', function(e) {
        console.error('JavaScript error:', e.error);
        
        // Show user-friendly error message if needed
        if (e.error && e.error.message.includes('fetch')) {
            showNotification('Connexion instable détectée. Veuillez réessayer.', 'warning');
        }
    });
    
    // Final console message
    console.log('%c✓ Activity Logs Page Loaded Successfully', 'color: #28a745; font-weight: bold; font-size: 14px;');
    console.log('%cKeyboard shortcuts:', 'color: #336699; font-weight: bold;');
    console.log('  Ctrl+F: Focus search');
    console.log('  Ctrl+R: Reset filters');
    console.log('  Escape: Clear search');
});

// Utility functions
function addLoadingState(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Traitement...';
    button.disabled = true;
    button.classList.add('loading');
    
    // Store original state for potential restoration
    button.setAttribute('data-original-text', originalText);
    
    // Auto-restore after 10 seconds as fallback
    setTimeout(() => {
        if (button.classList.contains('loading')) {
            restoreButtonState(button);
        }
    }, 10000);
}

function restoreButtonState(button) {
    const originalText = button.getAttribute('data-original-text');
    if (originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
        button.classList.remove('loading');
        button.removeAttribute('data-original-text');
    }
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const iconClass = type === 'success' ? 'fa-check-circle' : 
                     type === 'warning' ? 'fa-exclamation-triangle' : 
                     type === 'info' ? 'fa-info-circle' : 'fa-times-circle';
    
    notification.className = `alert alert-${type} alert-dismissible fade show`;
   notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px; animation: slideInRight 0.3s ease-out; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);';
    notification.innerHTML = `
        <i class="fas ${iconClass} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            const bsAlert = new bootstrap.Alert(notification);
            bsAlert.close();
        }
    }, 5000);
}

function highlightSearchResults(searchTerm) {
    if (!searchTerm || searchTerm.length < 2) return;
    
    const tableRows = document.querySelectorAll('.table tbody tr:not(:last-child)');
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach(cell => {
            const textNodes = getTextNodes(cell);
            textNodes.forEach(textNode => {
                const text = textNode.textContent;
                if (text.toLowerCase().includes(searchTerm.toLowerCase())) {
                    const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
                    const highlightedText = text.replace(regex, '<mark>$1</mark>');
                    
                    // Create a temporary element to hold the highlighted content
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = highlightedText;
                    
                    // Replace the text node with the highlighted content
                    const parent = textNode.parentNode;
                    while (tempDiv.firstChild) {
                        parent.insertBefore(tempDiv.firstChild, textNode);
                    }
                    parent.removeChild(textNode);
                }
            });
        });
    });
}

function clearHighlights() {
    const highlights = document.querySelectorAll('mark');
    highlights.forEach(mark => {
        const parent = mark.parentNode;
        parent.replaceChild(document.createTextNode(mark.textContent), mark);
        parent.normalize();
    });
}

function getTextNodes(element) {
    const textNodes = [];
    const walker = document.createTreeWalker(
        element,
        NodeFilter.SHOW_TEXT,
        {
            acceptNode: function(node) {
                // Skip text nodes that are inside script, style, or other elements we don't want to highlight
                const parent = node.parentElement;
                if (parent && (parent.tagName === 'SCRIPT' || parent.tagName === 'STYLE' || parent.tagName === 'MARK')) {
                    return NodeFilter.FILTER_REJECT;
                }
                return node.textContent.trim() ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
            }
        }
    );
    
    let node;
    while (node = walker.nextNode()) {
        textNodes.push(node);
    }
    
    return textNodes;
}

function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Export utility functions to global scope
window.activityLogsManagement = {
    showNotification,
    highlightSearchResults,
    clearHighlights,
    addLoadingState,
    restoreButtonState
};

// Add slideInRight animation
const slideInRightCSS = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = slideInRightCSS;
document.head.appendChild(styleSheet);
</script>
@endsection