@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-edit text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Modifier le fournisseur</h2>
                    <small class="text-muted">{{ $supplier->name }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-eye me-1"></i> Voir
                </a>
                <a href="{{ route('suppliers.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
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

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-truck me-2" style="color: #336699;"></i>
                            Informations du fournisseur
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nom du fournisseur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $supplier->name) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="contact_person" class="form-label fw-semibold">Personne de contact</label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label fw-semibold">Numéro de téléphone</label>
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" name="phone_number" value="{{ old('phone_number', $supplier->phone_number) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Adresse email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $supplier->email) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Adresse complète</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="Adresse, ville, code postal, pays..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('address', $supplier->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label for="notes" class="form-label fw-semibold">Notes et commentaires</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Informations complémentaires, conditions particulières..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('notes', $supplier->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Status Card -->
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
                                   id="active" name="active" value="1" {{ old('active', $supplier->active) ? 'checked' : '' }}
                                   style="font-size: 1.2rem;">
                            <label class="form-check-label fw-semibold" for="active">
                                Fournisseur actif
                            </label>
                        </div>
                        <small class="text-muted">Un fournisseur actif peut être utilisé pour les commandes et apparaît dans les listes de sélection.</small>
                    </div>
                </div>

                <!-- Statistics Card -->
                @if($supplier->products && $supplier->products->count() > 0)
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #336699;">
                            <i class="fas fa-chart-line me-2"></i>
                            Statistiques
                        </h6>
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <h4 class="mb-1 fw-bold text-primary">{{ $supplier->products->count() }}</h4>
                                <small class="text-muted">Produits</small>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-1 fw-bold text-success">{{ $supplier->products->where('stock_quantity', '>', 0)->count() }}</h4>
                                <small class="text-muted">En stock</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Information Card -->
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
                                <small>Un fournisseur inactif reste visible</small>
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check text-warning me-2"></i>
                                <small>Les produits associés ne sont pas supprimés</small>
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
                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 24px;">
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
        const phoneInput = document.getElementById('phone_number');
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