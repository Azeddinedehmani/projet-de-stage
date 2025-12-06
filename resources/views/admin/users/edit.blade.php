@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-user-edit text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Modifier l'utilisateur</h2>
                    <small class="text-muted">{{ $user->name }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-eye me-1"></i> Voir profil
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>
    </div>

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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <!-- Informations personnelles -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-user me-2" style="color: #336699;"></i>
                            Informations personnelles
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Adresse email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Téléphone</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-semibold">Date de naissance</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Adresse complète</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Adresse, ville, code postal..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                <label for="role" class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required
                                        style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="responsable" {{ old('role', $user->role) == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                    <option value="pharmacien" {{ old('role', $user->role) == 'pharmacien' ? 'selected' : '' }}>Pharmacien</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="profile_photo" class="form-label fw-semibold">Photo de profil</label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                                       id="profile_photo" name="profile_photo" accept="image/*"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                <div class="form-text">Formats acceptés: JPG, PNG, JPEG. Taille max: 2MB</div>
                                @if($user->profile_photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$user->profile_photo) }}" 
                                             alt="Photo actuelle" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        <small class="text-muted d-block">Photo actuelle</small>
                                    </div>
                                @endif
                                @error('profile_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sécurité -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-shield-alt me-2" style="color: #336699;"></i>
                            Sécurité et accès
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-0">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                <div class="form-text">Laissez vide pour conserver le mot de passe actuel</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations système -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                            Informations système et statistiques
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Informations système</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Créé le:</strong></td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Modifié le:</strong></td>
                                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dernière connexion:</strong></td>
                                        <td>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais connecté' }}</td>
                                    </tr>
                                    @if($user->last_login_ip)
                                        <tr>
                                            <td><strong>Dernière IP:</strong></td>
                                            <td><code>{{ $user->last_login_ip }}</code></td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Statistiques</h6>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 class="mb-1 fw-bold text-primary">{{ $user->activityLogs->count() }}</h4>
                                        <small class="text-muted">Activités</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="mb-1 fw-bold text-success">{{ $user->activityLogs->where('action', 'login')->count() }}</h4>
                                        <small class="text-muted">Connexions</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="mb-1 fw-bold text-info">{{ $user->activityLogs->where('model_type', 'App\Models\Sale')->count() }}</h4>
                                        <small class="text-muted">Ventes</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Statut et accès -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-toggle-on me-2" style="color: #336699;"></i>
                            Statut et accès
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   style="font-size: 1.2rem;">
                            <label class="form-check-label fw-semibold" for="is_active">
                                Compte actif
                            </label>
                        </div>
                        <small class="text-muted d-block mb-3">L'utilisateur pourra se connecter au système</small>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="force_password_change" name="force_password_change" value="1" {{ old('force_password_change', $user->force_password_change) ? 'checked' : '' }}
                                   style="font-size: 1.2rem;">
                            <label class="form-check-label fw-semibold" for="force_password_change">
                                Forcer le changement de mot de passe
                            </label>
                        </div>
                        <small class="text-muted">L'utilisateur devra changer son mot de passe à la prochaine connexion</small>
                    </div>
                </div>

                <!-- Aperçu du profil -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4 text-center">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/'.$user->profile_photo) }}" 
                                 alt="{{ $user->name }}" 
                                 class="rounded-circle mb-3" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 80px; height: 80px; font-size: 32px;">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        
                        <h6 class="fw-bold">{{ $user->name }}</h6>
                        <p class="text-muted small mb-2">{{ $user->email }}</p>
                        
                        <span class="badge {{ $user->role === 'responsable' ? 'bg-info' : 'bg-success' }} mb-2">
                            {{ $user->role === 'responsable' ? 'Responsable' : 'Pharmacien' }}
                        </span>
                        
                        @if($user->is_active)
                            <span class="badge bg-success d-block">Actif</span>
                        @else
                            <span class="badge bg-secondary d-block">Inactif</span>
                        @endif
                    </div>
                </div>

                <!-- Conseils -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #856404;">
                            <i class="fas fa-lightbulb me-2"></i>
                            Conseils
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Laissez le mot de passe vide pour le conserver</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Un utilisateur inactif ne peut pas se connecter</small>
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Le changement de rôle affecte les permissions</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold">Prêt à sauvegarder ?</h6>
                        <small class="text-muted">Les modifications seront appliquées immédiatement</small>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 24px;">
                            <i class="fas fa-times me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);">
                            <i class="fas fa-save me-1"></i> Enregistrer les modifications
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
        // Preview uploaded image
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('New image selected:', file.name);
                    // You can add image preview functionality here
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-format phone number
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 10) {
                    value = value.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
                }
                e.target.value = value;
            });
        }

        // Form validation enhancement
        const form = document.querySelector('form');
        const requiredFields = form.querySelectorAll('[required]');
        
        form.addEventListener('submit', function(e) {
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
                // Scroll to first invalid field
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

        // Highlight changes
        const originalValues = {};
        const formInputs = form.querySelectorAll('input, textarea, select');
        
        formInputs.forEach(function(input) {
            if (input.type !== 'checkbox') {
                originalValues[input.name] = input.value;
            } else {
                originalValues[input.name] = input.checked;
            }
        });
        
        formInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                let currentValue = input.type === 'checkbox' ? input.checked : input.value;
                let originalValue = originalValues[input.name];
                
                if (currentValue !== originalValue) {
                    input.style.borderColor = '#ffc107';
                    input.style.backgroundColor = 'rgba(255, 193, 7, 0.1)';
                } else {
                    input.style.borderColor = '#e9ecef';
                    input.style.backgroundColor = '';
                }
            });
        });
    });
</script>
@endsection