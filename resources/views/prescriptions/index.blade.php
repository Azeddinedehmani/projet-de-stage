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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Gestion des ordonnances</h2>
                    <small class="text-muted">Suivi et gestion des prescriptions médicales</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('prescriptions.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-plus me-1"></i> Nouvelle ordonnance
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
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

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total ordonnances</h6>
                            <h4 class="mb-0">{{ $totalPrescriptions ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-prescription fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">En attente</h6>
                            <h4 class="mb-0">{{ $pendingCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock fa-2x" style="color: #212529;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Expire bientôt</h6>
                            <h4 class="mb-0">{{ $expiringCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
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
                            <h6 class="card-title opacity-75">Expirées</h6>
                            <h4 class="mb-0">{{ $expiredCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-times fa-2x"></i>
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
            <form action="{{ route('prescriptions.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="N° ordonnance, client, médecin..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label fw-semibold">Statut</label>
                    <select class="form-select" id="status" name="status" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="partially_delivered" {{ request('status') == 'partially_delivered' ? 'selected' : '' }}>Partiellement</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Complètement</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirée</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label fw-semibold">Date début</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label fw-semibold">Date fin</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-2">
                    <label for="expiry_filter" class="form-label fw-semibold">Expiration</label>
                    <select class="form-select" id="expiry_filter" name="expiry_filter" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Toutes</option>
                        <option value="expiring_soon" {{ request('expiry_filter') == 'expiring_soon' ? 'selected' : '' }}>Expire dans 7j</option>
                        <option value="expired" {{ request('expiry_filter') == 'expired' ? 'selected' : '' }}>Expirées</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn w-100" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des ordonnances -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Liste des ordonnances ({{ isset($prescriptions) ? $prescriptions->total() : 0 }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">N° Ordonnance</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Client</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Médecin</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Date prescription</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Date expiration</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Statut</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions ?? [] as $prescription)
                            <tr class="{{ $prescription->isExpired() ? 'table-danger' : ($prescription->isAboutToExpire() ? 'table-warning' : '') }}">
                                <td class="border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-prescription text-white small"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $prescription->prescription_number ?? 'N/A' }}</strong>
                                            @if($prescription->isAboutToExpire() && !$prescription->isExpired())
                                                <br><small class="text-warning">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Expire dans {{ $prescription->expiry_date->diffInDays(now()) }} jour(s)
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border-0">
                                    <strong>{{ $prescription->client->full_name ?? 'N/A' }}</strong>
                                    @if($prescription->client->allergies)
                                        <br><small class="text-danger">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Allergies
                                        </small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <strong>{{ $prescription->doctor_name ?? 'N/A' }}</strong>
                                    @if($prescription->doctor_speciality)
                                        <br><small class="text-muted">{{ $prescription->doctor_speciality }}</small>
                                    @endif
                                    @if($prescription->doctor_phone)
                                        <br><small><i class="fas fa-phone me-1 text-muted"></i>{{ $prescription->doctor_phone }}</small>
                                    @endif
                                </td>
                                <td class="border-0">{{ $prescription->prescription_date->format('d/m/Y') }}</td>
                                <td class="border-0">
                                    {{ $prescription->expiry_date->format('d/m/Y') }}
                                    @if($prescription->isExpired())
                                        <br><small class="text-danger">Expirée</small>
                                    @elseif($prescription->isAboutToExpire())
                                        <br><small class="text-warning">Expire bientôt</small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <span class="badge {{ $prescription->status_badge ?? 'bg-secondary' }} rounded-pill">
                                        {{ $prescription->status_label ?? 'Inconnu' }}
                                    </span>
                                </td>
                                <td class="border-0">
                                    <div class="btn-group">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none;" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Bouton Imprimer -->
                                        <a href="{{ route('prescriptions.print', $prescription->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none;" target="_blank" title="Imprimer">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        
                                        <!-- Bouton Modifier - only for non-completed and non-expired prescriptions -->
                                        @if(!in_array($prescription->status, ['completed', 'expired']))
                                            <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none;" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        
                                        <!-- Bouton Délivrer - only for non-completed and non-expired prescriptions -->
                                        @if($prescription->status !== 'completed' && !$prescription->isExpired())
                                            <a href="{{ route('prescriptions.deliver', $prescription->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none;" title="Délivrer">
                                                <i class="fas fa-pills"></i>
                                            </a>
                                        @endif

                                        <!-- Bouton Supprimer -->
                                        @if(auth()->user()->canDeletePrescription($prescription))
                                            <button type="button" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none;" onclick="confirmDelete({{ $prescription->id }}, '{{ $prescription->prescription_number }}')" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            @php
                                                $restrictionReason = auth()->user()->getDeletionRestrictionReason($prescription);
                                            @endphp
                                            @if($restrictionReason)
                                                <button type="button" class="btn btn-sm btn-outline-danger" disabled title="{{ $restrictionReason }}">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-file-prescription fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucune ordonnance trouvée</h5>
                                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($prescriptions) && $prescriptions->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $prescriptions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="deleteContent">
                    <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'ordonnance <strong id="prescriptionNumber"></strong> ?</p>
                    <div id="deleteWarnings" class="alert alert-warning border-0" style="display: none; border-radius: 10px;">
                        <ul id="warningsList" class="mb-0"></ul>
                    </div>
                    <div id="stockImpact" class="alert alert-info border-0" style="display: none; border-radius: 10px;">
                        <strong>Impact sur le stock :</strong>
                        <ul id="stockList" class="mb-0 mt-2"></ul>
                    </div>
                    <div id="deleteError" class="alert alert-danger border-0" style="display: none; border-radius: 10px;"></div>
                    <div id="deleteLoading" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-2">Vérification des dépendances...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                <button type="button" id="confirmDeleteBtn" class="btn text-white" onclick="executeDelete()" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                    <i class="fas fa-trash me-1"></i>Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>

<!-- HIDDEN DELETE FORM -->
<form id="deleteForm" method="POST" style="display: none;">
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
</style>
@endsection

@section('scripts')
<script>
let currentPrescriptionId = null;
let canDelete = false;

function confirmDelete(prescriptionId, prescriptionNumber) {
    currentPrescriptionId = prescriptionId;
    
    // Reset modal content
    document.getElementById('prescriptionNumber').textContent = prescriptionNumber;
    document.getElementById('deleteWarnings').style.display = 'none';
    document.getElementById('stockImpact').style.display = 'none';
    document.getElementById('deleteError').style.display = 'none';
    document.getElementById('deleteLoading').style.display = 'block';
    document.getElementById('confirmDeleteBtn').disabled = true;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
    
    // Check dependencies
    checkDependencies(prescriptionId);
}

function checkDependencies(prescriptionId) {
    fetch(`{{ route('prescriptions.index') }}/${prescriptionId}/dependencies`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('deleteLoading').style.display = 'none';
            
            if (data.error) {
                showError(data.message || 'Erreur lors de la vérification');
                return;
            }
            
            canDelete = data.can_delete;
            
            // Show warnings if any
            if (data.warnings && data.warnings.length > 0) {
                const warningsList = document.getElementById('warningsList');
                warningsList.innerHTML = '';
                data.warnings.forEach(warning => {
                    const li = document.createElement('li');
                    li.textContent = warning;
                    warningsList.appendChild(li);
                });
                document.getElementById('deleteWarnings').style.display = 'block';
            }
            
            // Show stock impact if any
            if (data.stock_impact && data.stock_impact.length > 0) {
                const stockList = document.getElementById('stockList');
                stockList.innerHTML = '';
                data.stock_impact.forEach(impact => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${impact.product_name}</strong>: +${impact.quantity_to_restore} (${impact.current_stock} → ${impact.new_stock})`;
                    stockList.appendChild(li);
                });
                document.getElementById('stockImpact').style.display = 'block';
            }
            
            // Enable/disable delete button
            const deleteBtn = document.getElementById('confirmDeleteBtn');
            if (canDelete) {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Supprimer définitivement';
            } else {
                deleteBtn.disabled = true;
                deleteBtn.innerHTML = '<i class="fas fa-lock me-1"></i>Suppression non autorisée';
            }
        })
        .catch(error => {
            console.error('Error checking dependencies:', error);
            document.getElementById('deleteLoading').style.display = 'none';
            showError('Erreur lors de la vérification des dépendances');
        });
}

function showError(message) {
    const errorDiv = document.getElementById('deleteError');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    document.getElementById('confirmDeleteBtn').disabled = true;
}

function executeDelete() {
    if (!canDelete || !currentPrescriptionId) {
        return;
    }
    
    // Disable button and show loading
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Suppression...';
    
    // Set form action and submit
    const form = document.getElementById('deleteForm');
    form.action = `{{ route('prescriptions.index') }}/${currentPrescriptionId}`;
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