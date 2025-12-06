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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Modifier l'ordonnance</h2>
                    <small class="text-muted">{{ $prescription->prescription_number }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-eye me-1"></i> Voir
                </a>
                <a href="{{ route('prescriptions.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
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

    @if($prescription->prescriptionItems->where('product', null)->count() > 0)
        <div class="alert alert-warning alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); color: #212529; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Attention:</strong> Cette ordonnance contient des médicaments qui ne sont plus disponibles dans le système. 
            Veuillez contacter l'administrateur pour résoudre ce problème.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('prescriptions.update', $prescription->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                            Informations générales
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Client</label>
                                <input type="text" class="form-control" value="{{ $prescription->client->full_name }}" readonly
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px; background-color: #f8f9fa;">
                                <small class="text-muted">Le client ne peut pas être modifié</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="doctor_name" class="form-label fw-semibold">Nom du médecin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('doctor_name') is-invalid @enderror" 
                                       id="doctor_name" name="doctor_name" value="{{ old('doctor_name', $prescription->doctor_name) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('doctor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="doctor_phone" class="form-label fw-semibold">Téléphone du médecin</label>
                                <input type="tel" class="form-control @error('doctor_phone') is-invalid @enderror" 
                                       id="doctor_phone" name="doctor_phone" value="{{ old('doctor_phone', $prescription->doctor_phone) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('doctor_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="doctor_speciality" class="form-label fw-semibold">Spécialité</label>
                                <input type="text" class="form-control @error('doctor_speciality') is-invalid @enderror" 
                                       id="doctor_speciality" name="doctor_speciality" value="{{ old('doctor_speciality', $prescription->doctor_speciality) }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('doctor_speciality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prescription_date" class="form-label fw-semibold">Date de prescription <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('prescription_date') is-invalid @enderror" 
                                       id="prescription_date" name="prescription_date" 
                                       value="{{ old('prescription_date', $prescription->prescription_date->format('Y-m-d')) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('prescription_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label fw-semibold">Date d'expiration <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" name="expiry_date" 
                                       value="{{ old('expiry_date', $prescription->expiry_date->format('Y-m-d')) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="medical_notes" class="form-label fw-semibold">Notes médicales</label>
                            <textarea class="form-control @error('medical_notes') is-invalid @enderror" 
                                      id="medical_notes" name="medical_notes" rows="3" 
                                      placeholder="Notes du médecin, recommandations spéciales..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('medical_notes', $prescription->medical_notes) }}</textarea>
                            @error('medical_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="pharmacist_notes" class="form-label fw-semibold">Notes du pharmacien</label>
                            <textarea class="form-control @error('pharmacist_notes') is-invalid @enderror" 
                                      id="pharmacist_notes" name="pharmacist_notes" rows="3" 
                                      placeholder="Notes du pharmacien, observations..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('pharmacist_notes', $prescription->pharmacist_notes) }}</textarea>
                            @error('pharmacist_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-pills me-2" style="color: #336699;"></i>
                            Médicaments prescrits
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Médicament</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité prescrite</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité délivrée</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Posologie</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Instructions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prescription->prescriptionItems as $item)
                                        <tr class="{{ $item->product ? '' : 'table-warning' }}">
                                            <td class="border-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-pills text-white small"></i>
                                                    </div>
                                                    <div>
                                                        @if($item->product)
                                                            <strong>{{ $item->product->name }}</strong>
                                                            @if($item->product->dosage)
                                                                <br><small class="text-muted">{{ $item->product->dosage }}</small>
                                                            @endif
                                                        @else
                                                            <strong class="text-warning">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Produit non disponible (ID: {{ $item->product_id }})
                                                            </strong>
                                                            <br><small class="text-muted">Ce produit a été supprimé du système</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0 text-center">
                                                <span class="badge bg-primary rounded-pill">{{ $item->quantity_prescribed }}</span>
                                            </td>
                                            <td class="border-0 text-center">
                                                @if($item->product)
                                                    <span class="badge {{ $item->isFullyDelivered() ? 'bg-success' : ($item->isPartiallyDelivered() ? 'bg-warning' : 'bg-secondary') }} rounded-pill">
                                                        {{ $item->quantity_delivered }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill">{{ $item->quantity_delivered }}</span>
                                                @endif
                                            </td>
                                            <td class="border-0">
                                                <strong class="text-primary">{{ $item->dosage_instructions }}</strong>
                                            </td>
                                            <td class="border-0">{{ $item->instructions }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 mt-3" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> Seules les informations générales et les notes peuvent être modifiées. 
                    Les médicaments ne peuvent pas être modifiés après la création de l'ordonnance.
                </div>
            </div>
            
            <div class="col-md-4">
                @if($prescription->client->allergies)
                    <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-exclamation-triangle me-2"></i>Allergies connues
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="mb-0">{{ $prescription->client->allergies }}</p>
                        </div>
                    </div>
                @endif

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-user-injured me-2" style="color: #336699;"></i>
                            Informations client
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-2">
                            <strong>Nom:</strong> {{ $prescription->client->full_name }}
                        </div>
                        @if($prescription->client->phone)
                            <div class="mb-2">
                                <strong>Téléphone:</strong> 
                                <a href="tel:{{ $prescription->client->phone }}" class="text-decoration-none">{{ $prescription->client->phone }}</a>
                            </div>
                        @endif
                        @if($prescription->client->date_of_birth)
                            <div class="mb-2">
                                <strong>Âge:</strong> {{ $prescription->client->age }} ans
                            </div>
                        @endif
                        @if($prescription->client->insurance_number)
                            <div class="mb-2">
                                <strong>Assurance:</strong> {{ $prescription->client->insurance_number }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                            Actions
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-save me-1"></i> Mettre à jour
                            </button>
                            <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px;">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                        </div>
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
    
    .table-hover tbody tr:hover {
        background-color: rgba(51, 102, 153, 0.05);
        transform: scale(1.005);
        transition: all 0.2s ease;
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