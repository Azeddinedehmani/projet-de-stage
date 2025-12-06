@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-users-cog text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Gestion des utilisateurs</h2>
                    <small class="text-muted">Administration et gestion des comptes</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('admin.users.export', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-download me-1"></i> Exporter CSV
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-plus me-1"></i> Nouvel utilisateur
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            @if(session('temp_password'))
                <br><strong>🔑 Mot de passe temporaire: {{ session('temp_password') }}</strong>
            @endif
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

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ $totalUsers ?? 0 }}</h4>
                    <small class="opacity-75">Total utilisateurs</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ $activeUsers ?? 0 }}</h4>
                    <small class="opacity-75">Actifs</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ $adminUsers ?? 0 }}</h4>
                    <small class="opacity-75">Administrateurs</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-user-md fa-2x" style="color: #212529;"></i>
                    </div>
                    <h4 class="mb-1">{{ $pharmacistUsers ?? 0 }}</h4>
                    <small class="opacity-75">Pharmaciens</small>
                </div>
            </div>
        </div>
        <div class="col-lg mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ $recentLogins ?? 0 }}</h4>
                    <small class="opacity-75">Connexions 7j</small>
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
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3" id="userFilterForm">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nom, email, téléphone..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-3">
                    <label for="role" class="form-label fw-semibold">Rôle</label>
                    <select class="form-select" id="role" name="role" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les rôles</option>
                        <option value="responsable" {{ request('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                        <option value="pharmacien" {{ request('role') == 'pharmacien' ? 'selected' : '' }}>Pharmacien</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Statut</label>
                    <select class="form-select" id="status" name="status" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn w-100" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search me-1"></i> Filtrer
                    </button>
                </div>
            </form>
            
            <!-- Bouton de reset des filtres -->
            @if(request()->hasAny(['search', 'role', 'status']))
                <div class="mt-3 text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i> Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des utilisateurs -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Liste des utilisateurs ({{ isset($users) ? $users->total() : 0 }})
                @if(request()->hasAny(['search', 'role', 'status']))
                    <span class="badge bg-info rounded-pill">Filtré</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">Utilisateur</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Contact</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Rôle</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Dernière connexion</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Activités</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Statut</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users ?? [] as $user)
                            <tr class="table-row">
                                <td class="border-0">
                                    <div class="d-flex align-items-center">
                                        @if($user->profile_photo)
                                            <img src="{{ asset('storage/'.$user->profile_photo) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="rounded-circle me-3 user-avatar" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #336699;">
                                        @else
                                            <div class="me-3 user-avatar" style="width: 40px; height: 40px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $user->name ?? 'N/A' }}</strong>
                                            <br><small class="text-muted">{{ $user->email ?? 'N/A' }}</small>
                                            @if($user->force_password_change ?? false)
                                                <br><small class="text-warning">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Changement mot de passe requis
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border-0">
                                    @if($user->phone || $user->address)
                                        @if($user->phone)
                                            <div><i class="fas fa-phone me-1 text-muted"></i>{{ $user->phone }}</div>
                                        @endif
                                        @if($user->address)
                                            <div><i class="fas fa-map-marker-alt me-1 text-muted"></i>{{ Str::limit($user->address, 30) }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <span class="badge {{ ($user->role ?? '') === 'responsable' ? 'bg-info' : 'bg-success' }} rounded-pill">
                                        {{ ($user->role ?? '') === 'responsable' ? 'Responsable' : 'Pharmacien' }}
                                    </span>
                                </td>
                                <td class="border-0">
                                    @if($user->last_login_at)
                                        <div class="fw-medium">{{ $user->last_login_at->format('d/m/Y H:i') }}</div>
                                        @if($user->last_login_ip)
                                            <small class="text-muted">IP: {{ $user->last_login_ip }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Jamais connecté</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <span class="badge bg-primary rounded-pill">{{ $user->activity_logs_count ?? 0 }}</span>
                                    @if(($user->activity_logs_count ?? 0) > 0)
                                        <br><small class="text-muted">activités</small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if($user->is_active ?? true)
                                        <span class="badge bg-success rounded-pill">Actif</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Inactif</span>
                                    @endif
                                    
                                    @if($user->id === auth()->id())
                                        <br><small class="text-primary fw-semibold">👤 Vous</small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <div class="btn-group action-buttons">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm action-btn" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 8px; margin-right: 2px;" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Bouton Modifier -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm action-btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 8px; margin-right: 2px;" title="Modifier l'utilisateur">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if($user->id !== auth()->id())
                                            <!-- Toggle Status -->
                                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display: inline; margin-right: 2px;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm action-btn confirm-action" 
                                                        style="background: linear-gradient(135deg, {{ ($user->is_active ?? true) ? '#ffc107' : '#28a745' }} 0%, {{ ($user->is_active ?? true) ? '#fd7e14' : '#20c997' }} 100%); color: {{ ($user->is_active ?? true) ? '#212529' : 'white' }}; border: none; border-radius: 8px;"
                                                        data-action="{{ ($user->is_active ?? true) ? 'désactiver' : 'activer' }}"
                                                        data-user="{{ $user->name }}"
                                                        title="{{ ($user->is_active ?? true) ? 'Désactiver' : 'Activer' }}">
                                                    <i class="fas {{ ($user->is_active ?? true) ? 'fa-pause' : 'fa-play' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Reset Password -->
                                            <button type="button" class="btn btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}" 
                                                    style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; border-radius: 8px; margin-right: 2px;" title="Réinitialiser le mot de passe">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            
                                            <!-- Delete User -->
                                            @if(($user->role ?? '') !== 'responsable' || \App\Models\User::where('role', 'responsable')->where('id', '!=', $user->id)->count() > 0)
                                                <button type="button" class="btn btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" 
                                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 8px;" title="Supprimer l'utilisateur">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    @if($user->id !== auth()->id())
                                        <!-- Reset Password Modal -->
                                        <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                                                    <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px 15px 0 0;">
                                                        <h5 class="modal-title fw-bold">
                                                            <i class="fas fa-key me-2"></i>
                                                            Réinitialiser le mot de passe
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Êtes-vous sûr de vouloir réinitialiser le mot de passe de <strong>{{ $user->name }}</strong> ?</p>
                                                        <div class="alert alert-warning border-0" style="border-radius: 10px;">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Un mot de passe temporaire sera généré et l'utilisateur devra le changer à sa prochaine connexion.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                                                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; color: #212529;">
                                                                <i class="fas fa-key me-1"></i> Réinitialiser
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        @if(($user->role ?? '') !== 'responsable' || \App\Models\User::where('role', 'responsable')->where('id', '!=', $user->id)->count() > 0)
                                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                                                        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                                                            <h5 class="modal-title fw-bold">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                Supprimer l'utilisateur
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Êtes-vous sûr de vouloir supprimer <strong>{{ $user->name }}</strong> ?</p>
                                                            <div class="alert alert-danger border-0" style="border-radius: 10px;">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                <strong>Cette action est irréversible !</strong>
                                                                Toutes les données associées à cet utilisateur seront supprimées.
                                                            </div>
                                                            <p><strong>Statistiques :</strong></p>
                                                            <ul>
                                                                <li>{{ $user->activity_logs_count ?? 0 }} activités enregistrées</li>
                                                                <li>Membre depuis {{ $user->created_at->diffForHumans() }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                                                                    <i class="fas fa-trash me-1"></i> Supprimer définitivement
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-users fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucun utilisateur trouvé</h5>
                                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                                    @if(request()->hasAny(['search', 'role', 'status']))
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
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
        @if(isset($users) && $users->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $users->appends(request()->query())->links()}}
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
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const searchInput = document.getElementById('search');
    const roleSelect = document.getElementById('role');
    const statusSelect = document.getElementById('status');
    const filterForm = document.getElementById('userFilterForm');
    const tableRows = document.querySelectorAll('.table-row');
    
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
    const autoSubmitSelects = [roleSelect, statusSelect];
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
    
    // Enhanced confirmation dialogs
    const confirmButtons = document.querySelectorAll('.confirm-action');
    confirmButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const action = this.getAttribute('data-action') || 'cette action';
            const userName = this.getAttribute('data-user') || 'cet utilisateur';
            
            // Create custom confirmation modal
            const confirmModal = document.createElement('div');
            confirmModal.className = 'modal fade';
            confirmModal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
                        <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title fw-bold">
                                <i class="fas fa-question-circle me-2"></i>
                                Confirmation
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                            </div>
                            <p class="fs-6">Êtes-vous sûr de vouloir <strong>${action}</strong> <strong>${userName}</strong> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning" id="confirmAction">Confirmer</button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(confirmModal);
            const modal = new bootstrap.Modal(confirmModal);
            modal.show();
            
            // Handle confirmation
            confirmModal.querySelector('#confirmAction').addEventListener('click', () => {
                modal.hide();
                // Submit the form
                const form = this.closest('form');
                if (form) {
                    addLoadingState(this);
                    form.submit();
                }
            });
            
            // Clean up modal after hiding
            confirmModal.addEventListener('hidden.bs.modal', () => {
                document.body.removeChild(confirmModal);
            });
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
    
    // Keyboard shortcuts
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
        
        // Ctrl+N for new user
        if (e.ctrlKey && e.key === 'n') {
            e.preventDefault();
            const newUserLink = document.querySelector('a[href*="users/create"]');
            if (newUserLink) {
                window.location.href = newUserLink.href;
            }
        }
        
        // Ctrl+E for export
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            const exportLink = document.querySelector('a[href*="export"]');
            if (exportLink) {
                showNotification('Export en cours...', 'info');
                window.location.href = exportLink.href;
            }
        }
        
        // Ctrl+R to reset filters
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            const resetLink = document.querySelector('a[href*="admin.users.index"]:not([href*="?"])');
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
        if (icon) {
            let title = '';
            if (icon.classList.contains('fa-eye')) {
                title = 'Voir les détails';
            } else if (icon.classList.contains('fa-edit')) {
                title = 'Modifier';
            } else if (icon.classList.contains('fa-pause')) {
                title = 'Désactiver';
            } else if (icon.classList.contains('fa-play')) {
                title = 'Activer';
            } else if (icon.classList.contains('fa-key')) {
                title = 'Réinitialiser mot de passe';
            } else if (icon.classList.contains('fa-trash')) {
                title = 'Supprimer';
            }
            
            if (title) {
                button.setAttribute('title', title);
                new bootstrap.Tooltip(button);
            }
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
    console.log('%c✓ Users Management Page Loaded Successfully', 'color: #28a745; font-weight: bold; font-size: 14px;');
    console.log('%cKeyboard shortcuts:', 'color: #336699; font-weight: bold;');
    console.log('  Ctrl+F: Focus search');
    console.log('  Ctrl+N: New user');
    console.log('  Ctrl+E: Export');
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
window.userManagement = {
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