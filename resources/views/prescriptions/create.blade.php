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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Nouvelle ordonnance</h2>
                    <small class="text-muted">Créer une nouvelle prescription médicale</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('prescriptions.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux ordonnances
            </a>
        </div>
    </div>

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

    <form action="{{ route('prescriptions.store') }}" method="POST" id="prescriptionForm">
        @csrf
        
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
                                <label for="client_id" class="form-label fw-semibold">Client <span class="text-danger">*</span></label>
                                <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required
                                        style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                    <option value="">Sélectionner un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}
                                                data-allergies="{{ $client->allergies }}">
                                            {{ $client->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="doctor_name" class="form-label fw-semibold">Nom du médecin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('doctor_name') is-invalid @enderror" 
                                       id="doctor_name" name="doctor_name" value="{{ old('doctor_name') }}" required
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
                                       id="doctor_phone" name="doctor_phone" value="{{ old('doctor_phone') }}"
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('doctor_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="doctor_speciality" class="form-label fw-semibold">Spécialité</label>
                                <input type="text" class="form-control @error('doctor_speciality') is-invalid @enderror" 
                                       id="doctor_speciality" name="doctor_speciality" value="{{ old('doctor_speciality') }}"
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
                                       id="prescription_date" name="prescription_date" value="{{ old('prescription_date', date('Y-m-d')) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('prescription_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label fw-semibold">Date d'expiration <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" name="expiry_date" value="{{ old('expiry_date', date('Y-m-d', strtotime('+3 months'))) }}" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <label for="medical_notes" class="form-label fw-semibold">Notes médicales</label>
                            <textarea class="form-control @error('medical_notes') is-invalid @enderror" 
                                      id="medical_notes" name="medical_notes" rows="3" 
                                      placeholder="Notes du médecin, recommandations spéciales..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px;">{{ old('medical_notes') }}</textarea>
                            @error('medical_notes')
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
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="product_search" class="form-label fw-semibold">Ajouter un médicament</label>
                            <select class="form-select" id="product_search" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                <option value="">Sélectionner un produit</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}"
                                            data-dosage="{{ $product->dosage }}"
                                            data-prescription="{{ $product->prescription_required ? 'true' : 'false' }}">
                                        {{ $product->name }} {{ $product->dosage ? '- ' . $product->dosage : '' }}
                                        @if($product->prescription_required)
                                            (Ordonnance requise)
                                        @else
                                            (Vente libre)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="itemsTable" style="border-radius: 10px; overflow: hidden;">
                                <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Médicament</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699; width: 100px;">Quantité</th>
                                        <th class="border-0 fw-semibold" style="color: #336699; width: 200px;">Posologie</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699; width: 100px;">Durée (jours)</th>
                                        <th class="border-0 fw-semibold" style="color: #336699; width: 200px;">Instructions</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699; width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody">
                                    <tr id="noItemsRow">
                                        <td colspan="6" class="text-center text-muted border-0 py-4">
                                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                                <i class="fas fa-pills fa-2x text-muted"></i>
                                            </div>
                                            Aucun médicament ajouté
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @error('items')
                            <div class="alert alert-danger border-0" style="border-radius: 10px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Alerte allergies client -->
                <div class="card border-0 shadow-lg mb-4" id="allergiesAlert" style="display: none; border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>Allergies connues
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <p id="allergiesText" class="mb-0"></p>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-clipboard-list me-2" style="color: #336699;"></i>
                            Résumé de l'ordonnance
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-2">
                            <strong>Client:</strong> <span id="selectedClient">Non sélectionné</span>
                        </div>
                        <div class="mb-2">
                            <strong>Médecin:</strong> <span id="selectedDoctor">Non renseigné</span>
                        </div>
                        <div class="mb-2">
                            <strong>Date:</strong> <span id="selectedDate">{{ date('d/m/Y') }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Expiration:</strong> <span id="selectedExpiry">{{ date('d/m/Y', strtotime('+3 months')) }}</span>
                        </div>
                        <div>
                            <strong>Nombre de médicaments:</strong> <span id="itemsCount" class="badge bg-primary rounded-pill">0</span>
                        </div>
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
                            <button type="submit" class="btn text-white fw-semibold" id="submitBtn" disabled
                                    style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3);">
                                <i class="fas fa-save me-1"></i> Enregistrer l'ordonnance
                            </button>
                            <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px;">
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

@section('scripts')
<script>
let itemCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    const clientSelect = document.getElementById('client_id');
    const productSearch = document.getElementById('product_search');
    const doctorName = document.getElementById('doctor_name');
    const prescriptionDate = document.getElementById('prescription_date');
    const expiryDate = document.getElementById('expiry_date');
    
    // Gérer la sélection du client
    clientSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const allergies = option.dataset.allergies;
        
        document.getElementById('selectedClient').textContent = option.text || 'Non sélectionné';
        
        // Afficher/masquer l'alerte allergies
        const allergiesAlert = document.getElementById('allergiesAlert');
        if (allergies && allergies.trim() !== '') {
            document.getElementById('allergiesText').textContent = allergies;
            allergiesAlert.style.display = 'block';
        } else {
            allergiesAlert.style.display = 'none';
        }
        
        updateSubmitButton();
    });
    
    // Mettre à jour l'affichage du médecin
    doctorName.addEventListener('input', function() {
        document.getElementById('selectedDoctor').textContent = this.value || 'Non renseigné';
    });
    
    // Mettre à jour les dates
    prescriptionDate.addEventListener('change', function() {
        if (this.value) {
            const date = new Date(this.value);
            document.getElementById('selectedDate').textContent = date.toLocaleDateString('fr-FR');
        }
    });
    
    expiryDate.addEventListener('change', function() {
        if (this.value) {
            const date = new Date(this.value);
            document.getElementById('selectedExpiry').textContent = date.toLocaleDateString('fr-FR');
        }
    });
    
    // Ajouter un médicament
    productSearch.addEventListener('change', function() {
        if (this.value) {
            const option = this.options[this.selectedIndex];
            const productData = {
                id: this.value,
                name: option.dataset.name,
                dosage: option.dataset.dosage,
                prescription: option.dataset.prescription === 'true'
            };

            addPrescriptionItem(productData);
            this.value = '';
        }
    });
    
    // Restore old values if validation failed
    @if(old('items'))
        // Restore prescription items from old input
        const oldItems = @json(old('items'));
        const productOptions = document.getElementById('product_search').options;
        
        oldItems.forEach((item, index) => {
            // Find product data from options
            for (let i = 0; i < productOptions.length; i++) {
                const option = productOptions[i];
                if (option.value == item.product_id) {
                    const productData = {
                        id: option.value,
                        name: option.dataset.name,
                        dosage: option.dataset.dosage,
                        prescription: option.dataset.prescription === 'true'
                    };
                    
                    addPrescriptionItem(productData);
                    
                    // Set the old values
                    const lastRow = document.querySelector('#itemsTableBody tr:last-child');
                    if (lastRow) {
                        const quantityInput = lastRow.querySelector('input[name*="[quantity_prescribed]"]');
                        const dosageInput = lastRow.querySelector('input[name*="[dosage_instructions]"]');
                        const durationInput = lastRow.querySelector('input[name*="[duration_days]"]');
                        const instructionsInput = lastRow.querySelector('textarea[name*="[instructions]"]');
                        
                        if (quantityInput) quantityInput.value = item.quantity_prescribed || '';
                        if (dosageInput) dosageInput.value = item.dosage_instructions || '';
                        if (durationInput) durationInput.value = item.duration_days || '';
                        if (instructionsInput) instructionsInput.value = item.instructions || '';
                    }
                    break;
                }
            }
        });
    @endif
});

function addPrescriptionItem(product) {
    const tbody = document.getElementById('itemsTableBody');
    const noItemsRow = document.getElementById('noItemsRow');
    
    // Supprimer la ligne "Aucun médicament"
    if (noItemsRow) {
        noItemsRow.remove();
    }

    // Vérifier si le produit existe déjà
    const existingRow = document.querySelector(`tr[data-product-id="${product.id}"]`);
    if (existingRow) {
        alert('Ce médicament est déjà dans la liste');
        return;
    }

    const row = document.createElement('tr');
    row.setAttribute('data-product-id', product.id);
    row.className = 'table-row-modern';
    row.innerHTML = `
        <td class="border-0">
            <div class="d-flex align-items-center">
                <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-pills text-white small"></i>
                </div>
                <div>
                    <strong>${product.name}</strong>
                    ${product.dosage ? '<br><small class="text-muted">' + product.dosage + '</small>' : ''}
                    ${product.prescription ? '<br><small class="text-success"><i class="fas fa-prescription-bottle me-1"></i>Ordonnance requise</small>' : '<br><small class="text-warning">Vente libre</small>'}
                </div>
            </div>
            <input type="hidden" name="items[${itemCounter}][product_id]" value="${product.id}">
        </td>
        <td class="border-0 text-center">
            <input type="number" class="form-control text-center quantity-input" name="items[${itemCounter}][quantity_prescribed]" 
                   value="1" min="1" required style="border-radius: 8px; border: 2px solid #e9ecef;">
        </td>
        <td class="border-0">
            <input type="text" class="form-control" name="items[${itemCounter}][dosage_instructions]" 
                   placeholder="Ex: 1 cp matin et soir" required style="border-radius: 8px; border: 2px solid #e9ecef;">
        </td>
        <td class="border-0 text-center">
            <input type="number" class="form-control text-center" name="items[${itemCounter}][duration_days]" 
                   min="1" placeholder="7" style="border-radius: 8px; border: 2px solid #e9ecef;">
        </td>
        <td class="border-0">
            <textarea class="form-control" name="items[${itemCounter}][instructions]" rows="2" 
                      placeholder="Instructions spéciales..." style="border-radius: 8px; border: 2px solid #e9ecef;"></textarea>
        </td>
        <td class="border-0 text-center">
            <button type="button" class="btn btn-sm" onclick="removePrescriptionItem(this)" 
                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 8px;">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;

    tbody.appendChild(row);
    itemCounter++;
    updateItemsCount();
    updateSubmitButton();
}

function removePrescriptionItem(button) {
    const row = button.closest('tr');
    row.remove();

    // Si plus de médicaments, afficher la ligne "Aucun médicament"
    const tbody = document.getElementById('itemsTableBody');
    if (tbody.children.length === 0) {
        tbody.innerHTML = `
            <tr id="noItemsRow">
                <td colspan="6" class="text-center text-muted border-0 py-4">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fas fa-pills fa-2x text-muted"></i>
                    </div>
                    Aucun médicament ajouté
                </td>
            </tr>
        `;
    }

    updateItemsCount();
    updateSubmitButton();
}

function updateItemsCount() {
    const count = document.querySelectorAll('#itemsTableBody tr[data-product-id]').length;
    document.getElementById('itemsCount').textContent = count;
}

function updateSubmitButton() {
    const hasClient = document.getElementById('client_id').value !== '';
    const hasDoctor = document.getElementById('doctor_name').value !== '';
    const hasItems = document.querySelectorAll('#itemsTableBody tr[data-product-id]').length > 0;
    const submitBtn = document.getElementById('submitBtn');
    
    submitBtn.disabled = !(hasClient && hasDoctor && hasItems);
    
    if (submitBtn.disabled) {
        submitBtn.style.background = 'linear-gradient(180deg, #6c757d 0%, #495057 100%)';
    } else {
        submitBtn.style.background = 'linear-gradient(180deg, #336699 0%, #4a90e2 100%)';
    }
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