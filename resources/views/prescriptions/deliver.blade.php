@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-pills text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Délivrance - {{ $prescription->prescription_number }}</h2>
                    <small class="text-muted">Délivrer les médicaments prescrits</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour à l'ordonnance
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

    <form action="{{ route('prescriptions.process-delivery', $prescription->id) }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <!-- Informations patient -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-user me-2"></i>Informations patient
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="fs-5">{{ $prescription->client->full_name }}</strong>
                                </div>
                                @if($prescription->client->date_of_birth)
                                    <div class="mb-2">
                                        <i class="fas fa-birthday-cake me-2 text-primary"></i>
                                        Âge: {{ $prescription->client->age }} ans
                                    </div>
                                @endif
                                @if($prescription->client->phone)
                                    <div class="mb-2">
                                        <i class="fas fa-phone me-2 text-success"></i>
                                        <a href="tel:{{ $prescription->client->phone }}" class="text-decoration-none">{{ $prescription->client->phone }}</a>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Médecin:</strong> {{ $prescription->doctor_name }}
                                </div>
                                @if($prescription->doctor_speciality)
                                    <div class="mb-2">
                                        <i class="fas fa-stethoscope me-2 text-info"></i>
                                        {{ $prescription->doctor_speciality }}
                                    </div>
                                @endif
                                <div class="mb-2">
                                    <i class="fas fa-calendar me-2 text-warning"></i>
                                    <strong>Date:</strong> {{ $prescription->prescription_date->format('d/m/Y') }}
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-calendar-times me-2 {{ $prescription->isAboutToExpire() ? 'text-warning' : 'text-muted' }}"></i>
                                    <strong>Expire le:</strong> 
                                    <span class="{{ $prescription->isAboutToExpire() ? 'text-warning' : '' }}">
                                        {{ $prescription->expiry_date->format('d/m/Y') }}
                                        @if($prescription->isAboutToExpire())
                                            ({{ $prescription->expiry_date->diffInDays(now()) }} jour(s) restant(s))
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @if($prescription->client->allergies)
                            <div class="alert alert-danger border-0 mt-3 mb-0" style="border-radius: 10px;">
                                <strong><i class="fas fa-exclamation-triangle me-1"></i>ALLERGIES CONNUES:</strong>
                                {{ $prescription->client->allergies }}
                            </div>
                        @endif

                        @if($prescription->medical_notes)
                            <div class="alert alert-info border-0 mt-3 mb-0" style="border-radius: 10px;">
                                <strong><i class="fas fa-notes-medical me-1"></i>Notes médicales:</strong>
                                {{ $prescription->medical_notes }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Médicaments à délivrer -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-pills me-2" style="color: #336699;"></i>
                            Médicaments à délivrer
                        </h5>
                        <button type="button" class="btn btn-sm" id="autoFillBtn" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; border-radius: 8px;">
                            <i class="fas fa-magic me-1"></i>Remplir automatiquement
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Médicament</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Prescrit</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Déjà délivré</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Reste à délivrer</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité à délivrer</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Stock disponible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $hasDeliverableItems = false; @endphp
                                    @foreach($prescription->prescriptionItems as $item)
                                        @php
                                            $maxDeliverable = min($item->remaining_quantity, $item->product ? $item->product->stock_quantity : 0);
                                            $isDeliverable = $item->hasValidProduct() && $item->remaining_quantity > 0 && $item->product->stock_quantity > 0;
                                            if ($isDeliverable) $hasDeliverableItems = true;
                                        @endphp
                                        <tr class="{{ !$item->hasValidProduct() ? 'table-danger' : ($item->product && $item->product->stock_quantity < $item->remaining_quantity ? 'table-warning' : '') }}">
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
                                                        <br><strong class="text-info">{{ $item->dosage_instructions }}</strong>
                                                        @if($item->instructions)
                                                            <br><small class="text-muted">{{ $item->instructions }}</small>
                                                        @endif
                                                        @if($item->duration_days)
                                                            <br><small class="text-success">Durée: {{ $item->duration_days }} jour(s)</small>
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
                                                <span class="badge bg-secondary rounded-pill">{{ $item->quantity_delivered }}</span>
                                            </td>
                                            <td class="border-0 text-center">
                                                <strong class="badge {{ $item->remaining_quantity > 0 ? 'bg-warning' : 'bg-success' }} rounded-pill">
                                                    {{ $item->remaining_quantity }}
                                                </strong>
                                            </td>
                                            <td class="border-0 text-center">
                                                @if($item->remaining_quantity > 0 && $item->hasValidProduct())
                                                    <input type="hidden" name="items[{{ $loop->index }}][item_id]" value="{{ $item->id }}">
                                                    <input type="number" 
                                                           class="form-control text-center quantity-input" 
                                                           name="items[{{ $loop->index }}][quantity_to_deliver]" 
                                                           value="{{ $maxDeliverable }}"
                                                           min="0" 
                                                           max="{{ $maxDeliverable }}"
                                                           data-max="{{ $item->remaining_quantity }}"
                                                           data-stock="{{ $item->product ? $item->product->stock_quantity : 0 }}"
                                                           data-product-name="{{ $item->product_name }}"
                                                           style="width: 80px; border-radius: 8px; border: 2px solid #e9ecef;"
                                                           {{ !$isDeliverable ? 'disabled' : '' }}>
                                                @elseif($item->remaining_quantity == 0)
                                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i>Complet</span>
                                                @else
                                                    <span class="text-muted">Non disponible</span>
                                                @endif
                                            </td>
                                            <td class="border-0">
                                                @if($item->hasValidProduct())
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge {{ $item->product->stock_quantity < $item->remaining_quantity ? 'bg-danger' : ($item->product->stock_quantity > 0 ? 'bg-success' : 'bg-danger') }} rounded-pill me-2">
                                                            {{ $item->product->stock_quantity }}
                                                        </span>
                                                        @if($item->product->isLowStock())
                                                            <i class="fas fa-exclamation-triangle text-warning" title="Stock faible"></i>
                                                        @endif
                                                    </div>
                                                    @if($item->product->stock_quantity < $item->remaining_quantity)
                                                        <small class="text-danger">Stock insuffisant!</small>
                                                    @elseif($item->product->stock_quantity == 0)
                                                        <small class="text-danger">En rupture de stock</small>
                                                    @endif
                                                @else
                                                    <span class="text-danger">Produit supprimé</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(!$hasDeliverableItems)
                        <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                            <div class="alert alert-warning border-0 mb-0" style="border-radius: 10px;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Aucun médicament ne peut être délivré actuellement (stock insuffisant ou produits non disponibles).
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-notes-medical me-2" style="color: #336699;"></i>
                            Notes du pharmacien
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <textarea class="form-control" name="pharmacist_notes" rows="4" 
                                      placeholder="Notes sur la délivrance, conseils au patient..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef;">{{ old('pharmacist_notes', $prescription->pharmacist_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-clipboard-list me-2" style="color: #336699;"></i>
                            Résumé de la délivrance
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div id="deliverySummary">
                            <p class="text-muted">Sélectionnez les quantités à délivrer pour voir le résumé.</p>
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
                            @if($hasDeliverableItems)
                                <button type="submit" class="btn text-white fw-semibold" id="deliverBtn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                                    <i class="fas fa-pills me-1"></i> Enregistrer la délivrance
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary fw-semibold" disabled title="Aucun médicament délivrable" style="border-radius: 10px; padding: 12px;">
                                    <i class="fas fa-lock me-1"></i> Aucune délivrance possible
                                </button>
                            @endif
                            <a href="{{ route('prescriptions.show', $prescription->id) }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px;">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                            <a href="{{ route('prescriptions.print', $prescription->id) }}" class="btn btn-outline-primary fw-semibold" target="_blank" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                                <i class="fas fa-print me-1"></i> Imprimer l'ordonnance
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
    
    .badge {
        font-size: 0.75rem;
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
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
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const deliverBtn = document.getElementById('deliverBtn');
    const autoFillBtn = document.getElementById('autoFillBtn');
    
    // Update delivery summary when quantities change
    function updateDeliverySummary() {
        const summary = document.getElementById('deliverySummary');
        let totalItems = 0;
        let deliveryItems = [];
        
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            if (quantity > 0) {
                totalItems += quantity;
                deliveryItems.push({
                    name: input.dataset.productName,
                    quantity: quantity
                });
            }
        });
        
        if (totalItems > 0) {
            let html = `<h6 class="text-success mb-3">Délivrance prévue:</h6>`;
            html += `<ul class="list-unstyled">`;
            deliveryItems.forEach(item => {
                html += `<li class="mb-2"><strong>${item.name}:</strong> <span class="badge bg-primary rounded-pill">${item.quantity}</span></li>`;
            });
            html += `</ul>`;
            html += `<div class="alert alert-success border-0" style="border-radius: 10px;"><strong>Total: ${totalItems} médicament(s)</strong></div>`;
            summary.innerHTML = html;
        } else {
            summary.innerHTML = '<p class="text-muted">Aucun médicament sélectionné pour délivrance.</p>';
        }
    }
    
    // Validate quantities and update summary
    quantityInputs.forEach(input => {
        input.addEventListener('input', function() {
            const max = parseInt(this.getAttribute('max'));
            const value = parseInt(this.value) || 0;
            const stock = parseInt(this.dataset.stock);
            const maxPrescribed = parseInt(this.dataset.max);
            
            if (value > max) {
                this.value = max;
                if (stock < maxPrescribed) {
                    alert(`Quantité ajustée au stock disponible: ${stock}`);
                } else {
                    alert(`Quantité ajustée au maximum prescrit: ${maxPrescribed}`);
                }
            }
            
            updateDeliverySummary();
        });
        
        input.addEventListener('change', updateDeliverySummary);
    });
    
    // Auto-fill button functionality
    if (autoFillBtn) {
        autoFillBtn.addEventListener('click', function() {
            quantityInputs.forEach(input => {
                if (!input.disabled) {
                    const max = parseInt(input.getAttribute('max'));
                    input.value = max;
                }
            });
            updateDeliverySummary();
        });
    }
    
    // Initial summary update
    updateDeliverySummary();
    
    // Delivery confirmation
    if (deliverBtn) {
        deliverBtn.addEventListener('click', function(e) {
            const quantities = [];
            let hasQuantities = false;
            
            quantityInputs.forEach(input => {
                const quantity = parseInt(input.value) || 0;
                if (quantity > 0) {
                    hasQuantities = true;
                    quantities.push({
                        product: input.dataset.productName,
                        quantity: quantity
                    });
                }
            });
            
            if (!hasQuantities) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins une quantité à délivrer.');
                return;
            }
            
            let confirmMessage = 'Confirmer la délivrance des médicaments suivants ?\n\n';
            quantities.forEach(item => {
                confirmMessage += `• ${item.product}: ${item.quantity}\n`;
            });
            
            const confirm = window.confirm(confirmMessage);
            if (!confirm) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection