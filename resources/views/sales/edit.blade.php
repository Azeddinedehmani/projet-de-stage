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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Modifier la vente {{ $sale->sale_number }}</h2>
                    <small class="text-muted">Modification des informations de la vente</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('sales.show', $sale->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour à la vente
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
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
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-pills me-2" style="color: #336699;"></i>
                        Produits vendus
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Produit</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Quantité</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Prix unitaire</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleItems as $item)
                                    <tr class="{{ $item->product ? '' : 'deleted-product-row' }}">
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                @if($item->product)
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-pills text-white small"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $item->product->name }}</strong>
                                                        @if($item->product->dosage)
                                                            <br><small class="text-muted">{{ $item->product->dosage }}</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-trash text-white small"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="text-danger fst-italic">{{ $item->product_name ?? 'Produit supprimé' }}</strong>
                                                        <br><small class="text-danger">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Ce produit a été supprimé de l'inventaire
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-secondary rounded-pill">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end border-0">
                                            <strong class="text-success">{{ number_format($item->unit_price, 2) }} €</strong>
                                        </td>
                                        <td class="text-end border-0">
                                            <span class="badge bg-success rounded-pill fs-6">{{ number_format($item->total_price, 2) }} €</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white;">
                                    <th colspan="3" class="text-end border-0" style="font-size: 1.1rem;">Total:</th>
                                    <th class="text-end border-0" style="font-size: 1.3rem;">{{ number_format($sale->total_amount, 2) }} €</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="alert alert-info border-0 mt-4" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-3 fa-lg"></i>
                            <div>
                                <strong>Information importante :</strong><br>
                                Les produits vendus ne peuvent pas être modifiés après la création de la vente. 
                                Seuls le statut de paiement et les notes peuvent être mis à jour.
                                @if($sale->saleItems->whereNull('product')->count() > 0)
                                    <br><br>
                                    <span style="color: #fff3cd;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <strong>Attention :</strong> Certains produits de cette vente ont été supprimés de l'inventaire.
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="updateForm">
                @csrf
                @method('PUT')
                
                <!-- Informations de la vente -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                            Informations de la vente
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted mb-2">Numéro de vente</h6>
                            <p class="mb-0 fs-5">{{ $sale->sale_number }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted mb-2">Date et heure</h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar me-2 text-primary"></i>{{ $sale->sale_date->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted mb-2">Vendeur</h6>
                            <p class="mb-0">
                                <i class="fas fa-user-tie me-2 text-primary"></i>{{ $sale->user->name }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted mb-2">Client</h6>
                            <p class="mb-0">
                                @if($sale->client)
                                    <i class="fas fa-user me-2 text-info"></i>{{ $sale->client->full_name }}
                                @else
                                    <span class="text-muted fst-italic">Client anonyme</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-0">
                            <h6 class="fw-bold text-muted mb-2">Mode de paiement</h6>
                            <p class="mb-0">
                                <i class="fas fa-credit-card me-2 text-success"></i>{{ ucfirst($sale->payment_method) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modifier le statut -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-edit me-2" style="color: #336699;"></i>
                            Modifier le statut
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="payment_status" class="form-label fw-semibold">
                                <i class="fas fa-money-check-alt me-1" style="color: #336699;"></i>
                                Statut du paiement <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" 
                                    id="payment_status" name="payment_status" required
                                    style="border-radius: 10px; border: 2px solid #e9ecef;">
                                <option value="paid" {{ old('payment_status', $sale->payment_status) == 'paid' ? 'selected' : '' }}>
                                    ✅ Payé
                                </option>
                                <option value="pending" {{ old('payment_status', $sale->payment_status) == 'pending' ? 'selected' : '' }}>
                                    ⏳ En attente
                                </option>
                                <option value="failed" {{ old('payment_status', $sale->payment_status) == 'failed' ? 'selected' : '' }}>
                                    ❌ Échoué
                                </option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Affichage du statut actuel -->
                            <div class="mt-2">
                                <small class="text-muted">Statut actuel: </small>
                                <span class="badge rounded-pill {{ $sale->payment_status == 'paid' ? 'bg-success' : ($sale->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ ucfirst($sale->payment_status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-1" style="color: #336699;"></i>
                                Notes
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="4" 
                                      placeholder="Ajoutez des notes sur cette vente..."
                                      style="border-radius: 10px; border: 2px solid #e9ecef;">{{ old('notes', $sale->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-cogs me-2" style="color: #336699;"></i>
                            Actions
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn text-white fw-semibold" id="updateBtn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-save me-2"></i> Mettre à jour la vente
                            </button>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 10px; padding: 12px;">
                                <i class="fas fa-times me-2"></i> Annuler les modifications
                            </a>
                            <hr class="my-3">
                            <a href="{{ route('sales.print', $sale->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;" target="_blank">
                                <i class="fas fa-print me-2"></i> Imprimer la facture
                            </a>
                        </div>
                    </div>
                </div>
            </form>
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
    
    /* Styles pour les lignes de produits supprimés */
    .deleted-product-row {
        background: rgba(220, 53, 69, 0.05) !important;
        border-left: 3px solid #dc3545 !important;
    }
    
    /* Animation pour les alertes */
    .alert {
        animation: slideInDown 0.5s ease;
    }
    
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Amélioration de l'accessibilité */
    .btn:focus {
        outline: 2px solid #336699;
        outline-offset: 2px;
    }
    
    .btn:focus:not(:focus-visible) {
        outline: none;
    }
    
    /* Styles pour les badges */
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .col-md-8, .col-md-4 {
            margin-bottom: 20px;
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .btn {
            padding: 10px 16px;
            font-size: 14px;
        }
        
        .card-body {
            padding: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .d-grid .btn {
            font-size: 0.9rem;
            padding: 10px;
        }
        
        .card-body {
            padding: 12px;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        .table th,
        .table td {
            padding: 8px 4px;
            font-size: 0.8rem;
        }
    }
    
    /* Animation pour les cartes */
    .card {
        border: none !important;
        border-radius: 15px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Animation pour les boutons */
    .btn {
        position: relative;
        overflow: hidden;
    }
    
    .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.3s, height 0.3s;
    }
    
    .btn:active::after {
        width: 120%;
        height: 120%;
    }
    
    /* Styles pour les tableaux */
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 12px;
    }
    
    .table td {
        border-top: 1px solid #dee2e6;
        font-size: 0.875rem;
        padding: 12px;
        vertical-align: middle;
    }
    
    /* Amélioration des bordures */
    .border-0 {
        border: none !important;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar pour les tableaux */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #336699 0%, #4a90e2 100%);
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #2c5282 0%, #3182ce 100%);
    }
    
    /* Amélioration de la lisibilité */
    .table td {
        line-height: 1.4;
    }
    
    /* Animation pour les nouveaux éléments */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateForm');
    const updateBtn = document.getElementById('updateBtn');
    const paymentStatusSelect = document.getElementById('payment_status');
    
    // Animation pour le changement de statut
    paymentStatusSelect.addEventListener('change', function() {
        const statusBadge = document.querySelector('.badge:last-of-type');
        if (statusBadge) {
            statusBadge.style.transform = 'scale(1.1)';
            statusBadge.style.transition = 'transform 0.2s ease';
            
            setTimeout(() => {
                statusBadge.style.transform = 'scale(1)';
            }, 200);
        }
    });
    
    // Gestion de la soumission du formulaire
    updateForm.addEventListener('submit', function(e) {
        // Animation de loading
        updateBtn.disabled = true;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mise à jour en cours...';
        updateBtn.style.background = 'linear-gradient(135deg, #6c757d 0%, #495057 100%)';
        
        // Confirmer la modification si le statut change
        const originalStatus = '{{ $sale->payment_status }}';
        const newStatus = paymentStatusSelect.value;
        
        if (originalStatus !== newStatus) {
            const confirmMessage = `Êtes-vous sûr de vouloir changer le statut de "${originalStatus}" vers "${newStatus}" ?`;
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                // Restaurer le bouton
                updateBtn.disabled = false;
                updateBtn.innerHTML = '<i class="fas fa-save me-2"></i> Mettre à jour la vente';
                updateBtn.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                return false;
            }
        }
    });
    
    // Validation en temps réel
    const requiredFields = ['payment_status'];
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', validateForm);
        }
    });
    
    function validateForm() {
        const isValid = requiredFields.every(fieldId => {
            const field = document.getElementById(fieldId);
            return field && field.value.trim() !== '';
        });
        
        updateBtn.disabled = !isValid;
        if (!isValid) {
            updateBtn.style.background = 'linear-gradient(135deg, #6c757d 0%, #495057 100%)';
        } else {
            updateBtn.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
        }
    }
    
    // Animation pour les cartes au chargement
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animation pour les alertes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            alert.style.transition = 'all 0.3s ease';
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        }, 100);
    });
    
    // Amélioration des boutons avec effet ripple
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Animation au survol des lignes du tableau
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';});
    });
    
    // Tooltip pour les badges
    const badges = document.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Animation smooth pour le scroll
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Amélioration de l'accessibilité
    const focusableElements = document.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #336699';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
    
    // Gestion des erreurs réseau
    window.addEventListener('online', function() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x';
        alert.style.zIndex = '9999';
        alert.innerHTML = '<i class="fas fa-wifi me-2"></i>Connexion rétablie';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });
    
    window.addEventListener('offline', function() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-warning position-fixed top-0 start-50 translate-middle-x';
        alert.style.zIndex = '9999';
        alert.innerHTML = '<i class="fas fa-wifi-slash me-2"></i>Connexion perdue';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    });
    
    // Auto-save des modifications (optionnel)
    const notesField = document.getElementById('notes');
    if (notesField) {
        let autoSaveTimeout;
        notesField.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Sauvegarder automatiquement les notes en local storage
                localStorage.setItem('sales_edit_notes_' + '{{ $sale->id }}', this.value);
                
                // Afficher un indicateur de sauvegarde
                const indicator = document.createElement('small');
                indicator.className = 'text-muted';
                indicator.innerHTML = '<i class="fas fa-check me-1"></i>Sauvegardé localement';
                indicator.style.opacity = '0';
                
                const label = this.previousElementSibling;
                label.appendChild(indicator);
                
                // Animation d'apparition
                setTimeout(() => {
                    indicator.style.transition = 'opacity 0.3s ease';
                    indicator.style.opacity = '1';
                }, 10);
                
                // Disparition après 2 secondes
                setTimeout(() => {
                    indicator.style.opacity = '0';
                    setTimeout(() => {
                        if (indicator.parentNode) {
                            indicator.remove();
                        }
                    }, 300);
                }, 2000);
            }, 1000);
        });
        
        // Restaurer les notes sauvegardées au chargement
        const savedNotes = localStorage.getItem('sales_edit_notes_' + '{{ $sale->id }}');
        if (savedNotes && savedNotes !== notesField.value) {
            const confirmRestore = confirm('Des modifications non sauvegardées ont été trouvées. Voulez-vous les restaurer ?');
            if (confirmRestore) {
                notesField.value = savedNotes;
            }
        }
    }
    
    // Validation du formulaire avant soumission
    updateForm.addEventListener('submit', function(e) {
        // Supprimer les données sauvegardées localement après soumission réussie
        localStorage.removeItem('sales_edit_notes_' + '{{ $sale->id }}');
    });
    
    // Alerte avant de quitter la page avec des modifications non sauvegardées
    let formModified = false;
    const formElements = updateForm.querySelectorAll('input, select, textarea');
    formElements.forEach(element => {
        const originalValue = element.value;
        element.addEventListener('input', function() {
            formModified = this.value !== originalValue;
        });
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter cette page ?';
            return e.returnValue;
        }
    });
    
    // Marquer le formulaire comme non modifié lors de la soumission
    updateForm.addEventListener('submit', function() {
        formModified = false;
    });
});

// CSS pour l'effet ripple
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    /* Styles additionnels pour les transitions */
    .form-control, .form-select {
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(51, 102, 153, 0.2);
    }
    
    /* Animation pour les labels */
    .form-label {
        transition: color 0.3s ease;
    }
    
    .form-control:focus + .form-label,
    .form-select:focus + .form-label {
        color: #336699;
    }
    
    /* Amélioration des alertes */
    .alert {
        position: relative;
        overflow: hidden;
    }
    
    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        animation: alertProgress 3s ease-out;
    }
    
    @keyframes alertProgress {
        to {
            left: 100%;
        }
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .card {
            background: rgba(33, 37, 41, 0.95) !important;
            color: #f8f9fa;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .table {
            color: #f8f9fa;
        }
        
        .table thead th {
            background-color: rgba(33, 37, 41, 0.9) !important;
            color: #f8f9fa;
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .table tbody td {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .text-muted {
            color: #adb5bd !important;
        }
        
        .form-control,
        .form-select {
            background-color: rgba(33, 37, 41, 0.9);
            border-color: rgba(255, 255, 255, 0.2);
            color: #f8f9fa;
        }
        
        .form-control:focus,
        .form-select:focus {
            background-color: rgba(33, 37, 41, 0.9);
            border-color: #336699;
            color: #f8f9fa;
        }
        
        .alert {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    }
    
    /* Styles pour l'impression */
    @media print {
        .btn,
        .alert,
        .card-header,
        form {
            display: none !important;
        }
        
        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
        }
        
        .table {
            font-size: 12px;
        }
        
        .table th,
        .table td {
            padding: 4px !important;
            border: 1px solid #000 !important;
        }
        
        body {
            background: white !important;
            color: black !important;
        }
        
        .badge {
            border: 1px solid #000;
            background: white !important;
            color: black !important;
        }
    }
    
    /* Animation de pulsation pour les éléments importants */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(51, 102, 153, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(51, 102, 153, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(51, 102, 153, 0);
        }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    /* Styles pour les notifications toast */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    
    .toast {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
    }
    
    .toast-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* Amélioration des sélecteurs */
    .form-select option {
        padding: 8px 12px;
    }
    
    .form-select:hover {
        border-color: #336699;
    }
    
    /* Styles pour les états de validation */
    .is-valid {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Animation pour les changements de statut */
    .status-change {
        animation: statusChange 0.5s ease;
    }
    
    @keyframes statusChange {
        0% {
            transform: scale(1);
            background-color: #f8f9fa;
        }
        50% {
            transform: scale(1.05);
            background-color: #fff3cd;
        }
        100% {
            transform: scale(1);
            background-color: #d4edda;
        }
    }
    
    /* Amélioration de la lisibilité */
    .small-text {
        font-size: 0.875rem;
        line-height: 1.4;
    }
    
    /* Styles pour les icônes */
    .fas, .far, .fab {
        transition: all 0.2s ease;
    }
    
    .btn:hover .fas,
    .btn:hover .far,
    .btn:hover .fab {
        transform: scale(1.1);
    }
    
    /* Gestion des espaces */
    .mb-safe {
        margin-bottom: 1rem !important;
    }
    
    .mt-safe {
        margin-top: 1rem !important;
    }
    
    /* Performance optimizations */
    .card,
    .btn,
    .badge,
    .alert,
    .form-control,
    .form-select {
        will-change: transform;
    }
    
    /* Correction pour éviter les conflits */
    .btn[disabled] {
        pointer-events: none;
        opacity: 0.6;
    }
    
    /* Animation de chargement */
    .loading {
        position: relative;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #336699;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Styles finaux pour la cohérence */
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .form-control::placeholder,
    .form-select::placeholder {
        color: #6c757d;
        opacity: 0.7;
    }
    
    /* Amélioration finale des badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
        letter-spacing: 0.025em;
    }
    
    /* État focus pour l'accessibilité */
    *:focus {
        outline: 2px solid #336699;
        outline-offset: 2px;
    }
    
    *:focus:not(:focus-visible) {
        outline: none;
    }
`;
document.head.appendChild(style);
</script>
@endsection