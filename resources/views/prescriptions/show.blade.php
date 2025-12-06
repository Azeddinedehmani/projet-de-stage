@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-file-prescription text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Ordonnance {{ $prescription->prescription_number }}</h2>
                    <small class="text-muted">
                        <span class="badge {{ $prescription->status_badge }} rounded-pill me-2">
                            {{ $prescription->status_label }}
                        </span>
                        Créée le {{ $prescription->created_at->format('d/m/Y à H:i') }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('prescriptions.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                <a href="{{ route('prescriptions.print', $prescription->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;" target="_blank">
                    <i class="fas fa-print me-1"></i> Imprimer
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
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

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                        Détails de l'ordonnance
                    </h5>
                    <span class="badge {{ $prescription->status_badge }} rounded-pill">
                        {{ $prescription->status_label }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Numéro d'ordonnance</h6>
                                <p class="mb-0 fs-5">{{ $prescription->prescription_number }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Date de prescription</h6>
                                <p class="mb-0">
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    {{ $prescription->prescription_date->format('d/m/Y') }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Date d'expiration</h6>
                                <p class="mb-0">
                                    <i class="fas fa-calendar-times me-2 {{ $prescription->isExpired() ? 'text-danger' : ($prescription->isAboutToExpire() ? 'text-warning' : 'text-success') }}"></i>
                                    <span class="{{ $prescription->isExpired() ? 'text-danger' : ($prescription->isAboutToExpire() ? 'text-warning' : '') }}">
                                        {{ $prescription->expiry_date->format('d/m/Y') }}
                                        @if($prescription->isExpired())
                                            (Expirée)
                                        @elseif($prescription->isAboutToExpire())
                                            (Expire dans {{ $prescription->expiry_date->diffInDays(now()) }} jour(s))
                                        @endif
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Créée par</h6>
                                <p class="mb-0">
                                    <i class="fas fa-user me-2 text-info"></i>
                                    {{ $prescription->createdBy->name }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Client</h6>
                                <p class="mb-0">
                                    <i class="fas fa-user-injured me-2 text-primary"></i>
                                    <a href="{{ route('clients.show', $prescription->client->id) }}" class="text-decoration-none">
                                        {{ $prescription->client->full_name }}
                                    </a>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Médecin prescripteur</h6>
                                <p class="mb-0">
                                    <i class="fas fa-user-md me-2 text-success"></i>
                                    {{ $prescription->doctor_name }}
                                </p>
                            </div>
                            
                            @if($prescription->doctor_speciality)
                                <div class="mb-3">
                                    <h6 class="fw-bold text-muted mb-2">Spécialité</h6>
                                    <p class="mb-0">
                                        <i class="fas fa-stethoscope me-2 text-info"></i>
                                        {{ $prescription->doctor_speciality }}
                                    </p>
                                </div>
                            @endif
                            
                            @if($prescription->doctor_phone)
                                <div class="mb-0">
                                    <h6 class="fw-bold text-muted mb-2">Téléphone du médecin</h6>
                                    <p class="mb-0">
                                        <i class="fas fa-phone me-2 text-warning"></i>
                                        <a href="tel:{{ $prescription->doctor_phone }}" class="text-decoration-none">{{ $prescription->doctor_phone }}</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($prescription->medical_notes)
                        <div class="alert alert-info border-0" style="border-radius: 10px;">
                            <strong><i class="fas fa-notes-medical me-1"></i>Notes médicales:</strong>
                            <p class="mb-0 mt-2">{{ $prescription->medical_notes }}</p>
                        </div>
                    @endif

                    @if($prescription->pharmacist_notes)
                        <div class="alert alert-secondary border-0" style="border-radius: 10px;">
                            <strong><i class="fas fa-user-md me-1"></i>Notes du pharmacien:</strong>
                            <p class="mb-0 mt-2">{{ $prescription->pharmacist_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($prescription->client->allergies)
                <div class="alert alert-danger border-0 mb-4" style="border-radius: 15px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
                    <strong><i class="fas fa-exclamation-triangle me-1"></i>Allergies connues du client:</strong>
                    <p class="mb-0 mt-2">{{ $prescription->client->allergies }}</p>
                </div>
            @endif

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
                                    <th class="border-0 fw-semibold" style="color: #336699;">Progression</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription->prescriptionItems as $item)
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-pills text-white small"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $item->product_name }}</strong>
                                                    @if($item->product && $item->product->dosage)
                                                        <br><small class="text-muted">{{ $item->product->dosage }}</small>
                                                    @endif
                                                    @if($item->duration_days)
                                                        <br><small class="text-info">Durée: {{ $item->duration_days }} jour(s)</small>
                                                    @endif
                                                    @if(!$item->hasValidProduct())
                                                        <br><small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Produit non disponible</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0 text-center">
                                            <span class="badge bg-primary rounded-pill">{{ $item->quantity_prescribed }}</span>
                                        </td>
                                        <td class="border-0 text-center">
                                            <span class="badge {{ $item->isFullyDelivered() ? 'bg-success' : ($item->isPartiallyDelivered() ? 'bg-warning' : 'bg-secondary') }} rounded-pill">
                                                {{ $item->quantity_delivered }}
                                            </span>
                                        </td>
                                        <td class="border-0">
                                            <strong class="text-primary">{{ $item->dosage_instructions }}</strong>
                                            @if($item->instructions)
                                                <br><small class="text-muted">{{ $item->instructions }}</small>
                                            @endif
                                        </td>
                                        <td class="border-0">
                                            <div class="progress mb-1" style="height: 20px; border-radius: 10px;">
                                                <div class="progress-bar {{ $item->isFullyDelivered() ? 'bg-success' : 'bg-warning' }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $item->delivery_percentage }}%"
                                                     aria-valuenow="{{ $item->delivery_percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $item->delivery_percentage }}%
                                                </div>
                                            </div>
                                            @if($item->remaining_quantity > 0)
                                                <small class="text-muted">Reste: {{ $item->remaining_quantity }}</small>
                                            @else
                                                <small class="text-success"><i class="fas fa-check-circle me-1"></i>Complet</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('prescriptions.print', $prescription->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;" target="_blank">
                            <i class="fas fa-print me-1"></i> Imprimer l'ordonnance
                        </a>
                        
                        {{-- Edit button - only for non-completed and non-expired prescriptions --}}
                        @if(!in_array($prescription->status, ['completed', 'expired']))
                            <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-edit me-1"></i> Modifier
                            </a>
                        @endif
                        
                        {{-- Deliver button - only for non-completed and non-expired prescriptions --}}
                        @if($prescription->status !== 'completed' && !$prescription->isExpired())
                            <a href="{{ route('prescriptions.deliver', $prescription->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-pills me-1"></i> Délivrer médicaments
                            </a>
                        @endif
                        
                        <a href="{{ route('clients.show', $prescription->client->id) }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                            <i class="fas fa-user me-1"></i> Voir le client
                        </a>
                        
                        {{-- DELETE BUTTON --}}
                        @if(auth()->user()->canDeletePrescription($prescription))
                            <button type="button" class="btn text-white fw-semibold" onclick="confirmPrescriptionDelete({{ $prescription->id }}, '{{ $prescription->prescription_number }}')" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-trash me-1"></i> Supprimer l'ordonnance
                            </button>
                        @else
                            @php
                                $restrictionReason = auth()->user()->getDeletionRestrictionReason($prescription);
                            @endphp
                            @if($restrictionReason)
                                <button type="button" class="btn btn-outline-danger fw-semibold" disabled title="{{ $restrictionReason }}" style="border-radius: 10px; padding: 12px;">
                                    <i class="fas fa-lock me-1"></i> {{ $restrictionReason }}
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informations client -->
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

          <!-- Contact rapide - Visible only to administrators -->
@if(($prescription->client->phone || $prescription->doctor_phone) && auth()->user()->isAdmin())
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3" style="color: #336699;">
                <i class="fas fa-phone-alt me-2"></i>
                Contact rapide
            </h6>
            <div class="d-grid gap-2">
                @if($prescription->client->phone)
                    <a href="tel:{{ $prescription->client->phone }}" class="btn btn-outline-success btn-sm fw-semibold" style="border-radius: 10px;">
                        <i class="fas fa-phone me-1"></i> Appeler le client
                    </a>
                @endif
                @if($prescription->doctor_phone)
                    <a href="tel:{{ $prescription->doctor_phone }}" class="btn btn-outline-primary btn-sm fw-semibold" style="border-radius: 10px;">
                        <i class="fas fa-user-md me-1"></i> Appeler le médecin
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deletePrescriptionModal" tabindex="-1" aria-labelledby="deletePrescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" id="deletePrescriptionModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="deletePrescriptionContent">
                    <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'ordonnance <strong id="prescriptionNumberToDelete"></strong> ?</p>
                    <div id="deletePrescriptionWarnings" class="alert alert-warning border-0" style="display: none; border-radius: 10px;">
                        <ul id="prescriptionWarningsList" class="mb-0"></ul>
                    </div>
                    <div id="prescriptionStockImpact" class="alert alert-info border-0" style="display: none; border-radius: 10px;">
                        <strong>Impact sur le stock :</strong>
                        <ul id="prescriptionStockList" class="mb-0 mt-2"></ul>
                    </div>
                    <div id="deletePrescriptionError" class="alert alert-danger border-0" style="display: none; border-radius: 10px;"></div>
                    <div id="deletePrescriptionLoading" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-2">Vérification des dépendances...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                <button type="button" id="confirmPrescriptionDeleteBtn" class="btn text-white" onclick="executePrescriptionDelete()" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                    <i class="fas fa-trash me-1"></i>Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>

<!-- HIDDEN DELETE FORM -->
<form id="deletePrescriptionForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .modal-content {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .progress-bar {
        transition: width 0.6s ease;
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
</style>
@endsection

@section('scripts')
<script>
let currentPrescriptionIdToDelete = null;
let canDeletePrescription = false;
const baseUrl = '{{ url('/') }}';

function confirmPrescriptionDelete(prescriptionId, prescriptionNumber) {
    currentPrescriptionIdToDelete = prescriptionId;
    
    // Reset modal content
    document.getElementById('prescriptionNumberToDelete').textContent = prescriptionNumber;
    document.getElementById('deletePrescriptionWarnings').style.display = 'none';
    document.getElementById('prescriptionStockImpact').style.display = 'none';
    document.getElementById('deletePrescriptionError').style.display = 'none';
    document.getElementById('deletePrescriptionLoading').style.display = 'block';
    document.getElementById('confirmPrescriptionDeleteBtn').disabled = true;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('deletePrescriptionModal'));
    modal.show();
    
    // Check dependencies
    checkPrescriptionDependencies(prescriptionId);
}

function checkPrescriptionDependencies(prescriptionId) {
    fetch(`${baseUrl}/prescriptions/${prescriptionId}/dependencies`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('deletePrescriptionLoading').style.display = 'none';
            
            if (data.error) {
                showPrescriptionDeleteError(data.message || 'Erreur lors de la vérification');
                return;
            }
            
            canDeletePrescription = data.can_delete;
            
            // Show warnings if any
            if (data.warnings && data.warnings.length > 0) {
                const warningsList = document.getElementById('prescriptionWarningsList');
                warningsList.innerHTML = '';
                data.warnings.forEach(warning => {
                    const li = document.createElement('li');
                    li.textContent = warning;
                    warningsList.appendChild(li);
                });
                document.getElementById('deletePrescriptionWarnings').style.display = 'block';
            }
            
            // Show stock impact if any
            if (data.stock_impact && data.stock_impact.length > 0) {
                const stockList = document.getElementById('prescriptionStockList');
                stockList.innerHTML = '';
                data.stock_impact.forEach(impact => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${impact.product_name}</strong>: +${impact.quantity_to_restore} (${impact.current_stock} → ${impact.new_stock})`;
                    stockList.appendChild(li);
                });
                document.getElementById('prescriptionStockImpact').style.display = 'block';
            }
            
            // Enable/disable delete button
            const deleteBtn = document.getElementById('confirmPrescriptionDeleteBtn');
            if (canDeletePrescription) {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Supprimer définitivement';
            } else {
                deleteBtn.disabled = true;
                deleteBtn.innerHTML = '<i class="fas fa-lock me-1"></i>Suppression non autorisée';
            }
        })
        .catch(error => {
            console.error('Error checking dependencies:', error);
            document.getElementById('deletePrescriptionLoading').style.display = 'none';
            showPrescriptionDeleteError('Erreur lors de la vérification des dépendances');
        });
}

function showPrescriptionDeleteError(message) {
    const errorDiv = document.getElementById('deletePrescriptionError');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    document.getElementById('confirmPrescriptionDeleteBtn').disabled = true;
}

function executePrescriptionDelete() {
    if (!canDeletePrescription || !currentPrescriptionIdToDelete) {
        return;
    }
    
    // Disable button and show loading
    const deleteBtn = document.getElementById('confirmPrescriptionDeleteBtn');
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Suppression...';
    
    // Set form action and submit
    const form = document.getElementById('deletePrescriptionForm');
    form.action = `${baseUrl}/prescriptions/${currentPrescriptionIdToDelete}`;
    form.submit();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.parentNode) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endsection