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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Modifier le client</h2>
                    <small class="text-muted">{{ $client->full_name }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('clients.show', $client->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-eye me-1"></i> Voir
                </a>
                <a href="{{ route('clients.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
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

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
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
                                <label for="first_name" class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" value="{{ old('first_name', $client->first_name) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-semibold">Nom de famille <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name', $client->last_name) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Adresse email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $client->email) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Numéro de téléphone</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $client->phone) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-semibold">Date de naissance</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $client->date_of_birth?->format('Y-m-d')) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="insurance_number" class="form-label fw-semibold">Numéro d'assurance</label>
                                <input type="text" class="form-control @error('insurance_number') is-invalid @enderror" 
                                       id="insurance_number" name="insurance_number" value="{{ old('insurance_number', $client->insurance_number) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('insurance_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Adresse complète</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2" 
                                      placeholder="Adresse, ville, code postal..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('address', $client->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                <label for="city" class="form-label fw-semibold">Ville</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', $client->city) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label fw-semibold">Code postal</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Contact d'urgence Card -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-phone-alt me-2" style="color: #336699;"></i>
                            Contact d'urgence
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                  <label for="emergency_contact_name" class="form-label fw-semibold">Nom du contact</label>
                            <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                   id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $client->emergency_contact_name) }}"
                                   style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                            @error('emergency_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="emergency_contact_phone" class="form-label fw-semibold">Téléphone d'urgence</label>
                            <input type="tel" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                   id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $client->emergency_contact_phone) }}"
                                   style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                            @error('emergency_contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations médicales Card -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-notes-medical me-2" style="color: #336699;"></i>
                            Informations médicales
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="allergies" class="form-label fw-semibold">Allergies connues</label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror" 
                                      id="allergies" name="allergies" rows="3" 
                                      placeholder="Décrivez les allergies connues..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('allergies', $client->allergies) }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="medical_notes" class="form-label fw-semibold">Notes médicales</label>
                            <textarea class="form-control @error('medical_notes') is-invalid @enderror" 
                                      id="medical_notes" name="medical_notes" rows="3" 
                                      placeholder="Notes importantes..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('medical_notes', $client->medical_notes) }}</textarea>
                            @error('medical_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statut Card -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-toggle-on me-2" style="color: #336699;"></i>
                            Statut
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="active" name="active" value="1" {{ old('active', $client->active) ? 'checked' : '' }}
                                   style="font-size: 1.2rem;">
                            <label class="form-check-label fw-semibold" for="active">
                                Client actif
                            </label>
                        </div>
                        <small class="text-muted">Un client actif peut faire des achats et apparaît dans les listes de sélection.</small>
                    </div>
                </div>

                <!-- Statistiques Card -->
                @if($client->sales && $client->sales->count() > 0)
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #336699;">
                            <i class="fas fa-chart-line me-2"></i>
                            Statistiques
                        </h6>
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <h4 class="mb-1 fw-bold text-success">{{ number_format($client->total_spent, 2) }} €</h4>
                                <small class="text-muted">Total dépensé</small>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-1 fw-bold text-primary">{{ $client->sales->count() }}</h4>
                                <small class="text-muted">Ventes</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Conseils Card -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #856404;">
                            <i class="fas fa-lightbulb me-2"></i>
                            Conseils
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Gardez les coordonnées à jour</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Les allergies sont importantes pour la sécurité</small>
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Le contact d'urgence peut sauver des vies</small>
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
                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 24px;">
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
        // Auto-format phone number
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(function(phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 10) {
                    value = value.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
                }
                e.target.value = value;
            });
        });

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

        // Age calculation for date of birth
        const dobInput = document.getElementById('date_of_birth');
        if (dobInput) {
            dobInput.addEventListener('change', function() {
                const dob = new Date(this.value);
                const today = new Date();
                const age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                
                if (age > 0 && age < 150) {
                    // Optional: Show age next to the field
                    let ageDisplay = this.parentNode.querySelector('.age-display');
                    if (!ageDisplay) {
                        ageDisplay = document.createElement('small');
                        ageDisplay.className = 'age-display text-muted mt-1 d-block';
                        this.parentNode.appendChild(ageDisplay);
                    }
                    ageDisplay.textContent = `Âge: ${age} ans`;
                }
            });
        }

        // Alert for allergies field
        const allergiesInput = document.getElementById('allergies');
        if (allergiesInput) {
            allergiesInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    this.style.borderColor = '#ffc107';
                    this.style.backgroundColor = 'rgba(255, 193, 7, 0.1)';
                    
                    // Show warning if not already shown
                    if (!this.parentNode.querySelector('.allergy-warning')) {
                        const warning = document.createElement('small');
                        warning.className = 'allergy-warning text-warning mt-1 d-block';
                        warning.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Information importante pour la sécurité du patient';
                        this.parentNode.appendChild(warning);
                    }
                } else {
                    this.style.borderColor = '#e9ecef';
                    this.style.backgroundColor = '';
                    
                    // Remove warning
                    const warning = this.parentNode.querySelector('.allergy-warning');
                    if (warning) {
                        warning.remove();
                    }
                }
            });
        }
    });
</script>
@endsection