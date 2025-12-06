@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-user text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">{{ $user->name }}</h2>
                    <small class="text-muted">
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill me-2">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                        Membre depuis {{ $user->created_at->format('M Y') }}
                        @if($user->id === auth()->id())
                            <span class="badge bg-warning text-dark ms-2">Votre compte</span>
                        @endif
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('admin.users.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-edit me-1"></i> Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <!-- Profil utilisateur -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-body text-center p-4">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/'.$user->profile_photo) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    @else
                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 120px; height: 120px; font-size: 48px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    
                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <span class="badge {{ $user->role === 'responsable' ? 'bg-info' : 'bg-success' }} rounded-pill mb-2 px-3 py-2">
                        {{ $user->role === 'responsable' ? 'Responsable' : 'Pharmacien' }}
                    </span>
                    
                    @if($user->is_active)
                        <span class="badge bg-success rounded-pill px-3 py-2">Actif</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-3 py-2">Inactif</span>
                    @endif
                    
                    @if($user->id === auth()->id())
                        <br><span class="badge bg-warning text-dark mt-2 px-3 py-2">Votre compte</span>
                    @endif
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Statistiques
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <h4 class="text-primary fw-bold">{{ $stats['total_activities'] }}</h4>
                            <small class="text-muted">Total activités</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success fw-bold">{{ $stats['logins_count'] }}</h4>
                            <small class="text-muted">Connexions</small>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="text-info fw-bold">{{ $stats['sales_count'] }}</h4>
                        <small class="text-muted">Actions ventes</small>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h6 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                        Actions rapides
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-edit me-1"></i> Modifier le profil
                        </a>
                        <a href="{{ route('admin.users.activity-logs', $user->id) }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                            <i class="fas fa-history me-1"></i> Voir l'activité
                        </a>
                        @if($user->phone)
                            <a href="tel:{{ $user->phone }}" class="btn btn-outline-success fw-semibold" style="border-radius: 10px; border: 2px solid #28a745; padding: 12px;">
                                <i class="fas fa-phone me-1"></i> Appeler
                            </a>
                        @endif
                        <a href="mailto:{{ $user->email }}" class="btn btn-outline-info fw-semibold" style="border-radius: 10px; border: 2px solid #17a2b8; padding: 12px;">
                            <i class="fas fa-envelope me-1"></i> Envoyer un email
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Informations personnelles -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                        Informations personnelles
                    </h5>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Nom complet</h6>
                                <p class="mb-0 fs-5">{{ $user->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Email</h6>
                                <p class="mb-0">
                                    <i class="fas fa-envelope me-2 text-info"></i>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">{{ $user->email}}</a>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Téléphone</h6>
                                <p class="mb-0">
                                    @if($user->phone)
                                        <i class="fas fa-phone me-2 text-success"></i>
                                        <a href="tel:{{ $user->phone }}" class="text-decoration-none">{{ $user->phone }}</a>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Date de naissance</h6>
                                <p class="mb-0">
                                    @if($user->date_of_birth)
                                        <i class="fas fa-calendar me-2 text-primary"></i>{{ $user->date_of_birth->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted fst-italic">Non renseignée</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Rôle</h6>
                                <p class="mb-0">
                                    <span class="badge {{ $user->role === 'responsable' ? 'bg-info' : 'bg-success' }} rounded-pill px-3 py-2">
                                        {{ $user->role === 'responsable' ? 'Responsable' : 'Pharmacien' }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Membre depuis</h6>
                                <p class="mb-0">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Dernière modification</h6>
                                <p class="mb-0">{{ $user->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Dernière connexion</h6>
                                <p class="mb-0">
                                    @if($user->last_login_at)
                                        {{ $user->last_login_at->format('d/m/Y à H:i') }}
                                        @if($user->last_login_ip)
                                            <br><small class="text-muted">IP: <code>{{ $user->last_login_ip }}</code></small>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Jamais connecté</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->address)
                        <hr class="my-4">
                        <div>
                            <h6 class="fw-bold text-muted mb-2">Adresse</h6>
                            <p class="mb-0 bg-light p-3 rounded" style="border-radius: 10px;">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $user->address }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activités récentes -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-history me-2" style="color: #336699;"></i>
                        Activités récentes
                    </h5>
                    <a href="{{ route('admin.users.activity-logs', $user->id) }}" class="btn btn-sm btn-outline-primary fw-semibold" style="border-radius: 8px;">
                        <i class="fas fa-external-link-alt me-1"></i>Voir tout
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($user->activityLogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Date</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Action</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Description</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->activityLogs->take(10) as $activity)
                                        <tr>
                                            <td class="border-0">
                                                <small class="text-muted">{{ $activity->created_at->format('d/m H:i') }}</small>
                                            </td>
                                            <td class="border-0">
                                                @php
                                                    $badgeClass = match($activity->action) {
                                                        'login' => 'bg-success',
                                                        'logout' => 'bg-secondary',
                                                        'create' => 'bg-primary',
                                                        'update' => 'bg-warning text-dark',
                                                        'delete' => 'bg-danger',
                                                        default => 'bg-info'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} rounded-pill">
                                                    {{ ucfirst($activity->action) }}
                                                </span>
                                            </td>
                                            <td class="border-0">
                                                <span title="{{ $activity->description }}">
                                                    {{ Str::limit($activity->description, 40) }}
                                                </span>
                                            </td>
                                            <td class="border-0">
                                                @if($activity->ip_address)
                                                    <code style="font-size: 0.8em;">{{ $activity->ip_address }}</code>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="font-size: 3rem; color: #e9ecef;">
                                <i class="fas fa-history"></i>
                            </div>
                            <h6 class="text-muted">Aucune activité enregistrée</h6>
                            <p class="text-muted small mb-0">Les activités de cet utilisateur apparaîtront ici</p>
                        </div>
                    @endif
                </div>
                @if($user->activityLogs->count() > 10)
                    <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                        <a href="{{ route('admin.users.activity-logs', $user->id) }}" class="btn btn-primary fw-semibold" style="border-radius: 10px;">
                            <i class="fas fa-history me-1"></i>
                            Voir toutes les activités ({{ $user->activityLogs->count() }})
                        </a>
                    </div>
                @endif
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
    
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
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
    
    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
    }
    
    .btn-outline-success:hover {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .btn-outline-info {
        color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-outline-info:hover {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    /* Animation pour les statistiques */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card-body h4 {
        animation: countUp 0.6s ease-out;
    }
    
    /* Effet de survol pour les badges */
    .badge {
        transition: all 0.3s ease;
    }
    
    .badge:hover {
        transform: scale(1.05);
    }
    
    /* Style pour les liens */
    a {
        text-decoration: none;
        color: #336699;
        transition: color 0.3s ease;
    }
    
    a:hover {
        color: #4a90e2;
    }
    
    /* Style pour les codes */
    code {
        background-color: #f1f3f4;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        font-size: 0.85em;
        color: #e83e8c;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des statistiques au chargement
        const statsNumbers = document.querySelectorAll('.card-body h4');
        
        statsNumbers.forEach((stat, index) => {
            const finalValue = parseInt(stat.textContent);
            let currentValue = 0;
            const increment = finalValue / 20;
            
            setTimeout(() => {
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        stat.textContent = finalValue;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentValue);
                    }
                }, 50);
            }, index * 200);
        });
        
        // Effet de survol pour les cartes
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
        
        // Tooltip pour les descriptions tronquées
        const truncatedTexts = document.querySelectorAll('[title]');
        truncatedTexts.forEach(element => {
            if (element.textContent.includes('...')) {
                element.style.cursor = 'help';
                element.addEventListener('click', function() {
                    alert(this.getAttribute('title'));
                });
            }
        });
        
        // Confirmation pour les actions sensibles
        const sensitiveActions = document.querySelectorAll('[data-confirm]');
        sensitiveActions.forEach(action => {
            action.addEventListener('click', function(e) {
                if (!confirm(this.getAttribute('data-confirm'))) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection