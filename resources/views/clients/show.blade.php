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
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">{{ $client->full_name }}</h2>
                    <small class="text-muted">
                        <span class="badge {{ $client->active ? 'bg-success' : 'bg-secondary' }} rounded-pill me-2">
                            {{ $client->active ? 'Actif' : 'Inactif' }}
                        </span>
                        Client depuis {{ $client->created_at->format('M Y') }}
                        @if($client->allergies)
                            <span class="badge bg-warning text-dark rounded-pill ms-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>Allergies
                            </span>
                        @endif
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('clients.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px 0 0 12px; padding: 12px 20px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                <a href="{{ route('clients.edit', $client->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                    <i class="fas fa-edit me-1"></i> Modifier
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

    <div class="row">
        <div class="col-md-8">
            <!-- Informations principales -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #336699;"></i>
                        Informations personnelles
                    </h5>
                    <span class="badge {{ $client->active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                        {{ $client->active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Nom complet</h6>
                                <p class="mb-0 fs-5">{{ $client->full_name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Email</h6>
                                <p class="mb-0">
                                    @if($client->email)
                                        <i class="fas fa-envelope me-2 text-info"></i>
                                        <a href="mailto:{{ $client->email }}" class="text-decoration-none">{{ $client->email }}</a>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Téléphone</h6>
                                <p class="mb-0">
                                    @if($client->phone)
                                        <i class="fas fa-phone me-2 text-success"></i>
                                        <a href="tel:{{ $client->phone }}" class="text-decoration-none">{{ $client->phone }}</a>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Date de naissance</h6>
                                <p class="mb-0">
                                    @if($client->date_of_birth)
                                        <i class="fas fa-birthday-cake me-2 text-primary"></i>
                                        {{ $client->date_of_birth->format('d/m/Y') }}
                                        @if($client->age)
                                            <span class="badge bg-primary rounded-pill ms-2">{{ $client->age }} ans</span>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Non renseignée</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Numéro d'assurance</h6>
                                <p class="mb-0">
                                    @if($client->insurance_number)
                                        <i class="fas fa-id-card me-2 text-warning"></i>
                                        {{ $client->insurance_number }}
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Ville</h6>
                                <p class="mb-0">
                                    @if($client->city)
                                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                        {{ $client->city }}
                                        @if($client->postal_code)
                                            ({{ $client->postal_code }})
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Non renseignée</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-muted mb-2">Créé le</h6>
                                <p class="mb-0">{{ $client->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Dernière modification</h6>
                                <p class="mb-0">{{ $client->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($client->address)
                        <hr class="my-4">
                        <div>
                            <h6 class="fw-bold text-muted mb-2">Adresse complète</h6>
                            <p class="mb-0 bg-light p-3 rounded" style="border-radius: 10px;">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $client->address }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact d'urgence -->
            @if($client->emergency_contact_name || $client->emergency_contact_phone)
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-phone-alt me-2" style="color: #336699;"></i>
                            Contact d'urgence
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-2">Nom du contact</h6>
                                <p class="mb-0">{{ $client->emergency_contact_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-2">Téléphone d'urgence</h6>
                                <p class="mb-0">
                                    @if($client->emergency_contact_phone)
                                        <i class="fas fa-phone me-2 text-danger"></i>
                                        <a href="tel:{{ $client->emergency_contact_phone }}" class="text-decoration-none">{{ $client->emergency_contact_phone }}</a>
                                    @else
                                        <span class="text-muted fst-italic">Non renseigné</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informations médicales -->
            @if($client->allergies || $client->medical_notes)
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-notes-medical me-2" style="color: #336699;"></i>
                            Informations médicales
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($client->allergies)
                            <div class="mb-3">
                                <h6 class="fw-bold text-danger mb-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Allergies connues
                                </h6>
                                <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded" style="border-radius: 10px;">
                                    {{ $client->allergies }}
                                </div>
                            </div>
                        @endif
                        
                        @if($client->medical_notes)
                            <div class="mb-0">
                                <h6 class="fw-bold text-muted mb-2">Notes médicales</h6>
                              <p class="mb-0 bg-light p-3 rounded" style="border-radius: 10px;">
                                    <i class="fas fa-sticky-note me-2 text-primary"></i>{{ $client->medical_notes }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Ventes récentes -->
            @if(isset($recentSales) && $recentSales->count() > 0)
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-cash-register me-2" style="color: #336699;"></i>
                            Ventes récentes ({{ $recentSales->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">N° Vente</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Produits</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Montant</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Date</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSales as $sale)
                                        <tr>
                                            <td class="border-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-receipt text-white small"></i>
                                                    </div>
                                                    <strong>{{ $sale->sale_number }}</strong>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <small>
                                                    @foreach($sale->saleItems->take(2) as $item)
                                                        {{ $item->product->name }}
                                                        @if($item->quantity > 1) ({{ $item->quantity }}) @endif
                                                        @if(!$loop->last), @endif
                                                    @endforeach
                                                    @if($sale->saleItems->count() > 2)
                                                        <br><span class="text-muted">+{{ $sale->saleItems->count() - 2 }} autres</span>
                                                    @endif
                                                </small>
                                            </td>
                                            <td class="border-0">
                                                <strong class="text-success">{{ number_format($sale->total_amount, 2) }} €</strong>
                                            </td>
                                            <td class="border-0">{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                            <td class="border-0">
                                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none;" title="Voir la vente">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(($client->sales->count() ?? 0) > $recentSales->count())
                        <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                            <a href="{{ route('sales.index', ['client' => $client->id]) }}" class="btn btn-primary">
                                <i class="fas fa-history me-1"></i>
                                Voir toutes les ventes ({{ $client->sales->count() }})
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <!-- Statistiques -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <h4 class="mb-1 fw-bold text-success">{{ number_format($client->total_spent ?? 0, 2) }} €</h4>
                            <small class="text-muted">Total dépensé</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-1 fw-bold text-primary">{{ $client->sales->count() ?? 0 }}</h4>
                            <small class="text-muted">Nombre de ventes</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold text-muted mb-2">Dernière visite</h6>
                        <p class="mb-0">
                            @if($client->sales->first())
                                <i class="fas fa-calendar me-2 text-info"></i>
                                {{ $client->sales->first()->sale_date->format('d/m/Y à H:i') }}
                            @else
                                <span class="text-muted fst-italic">Aucune visite</span>
                            @endif
                        </p>
                    </div>
                    
                    @php
                        $avgSpent = $client->sales->count() > 0 ? $client->total_spent / $client->sales->count() : 0;
                    @endphp
                    <div class="mb-0">
                        <h6 class="fw-bold text-muted mb-2">Panier moyen</h6>
                        <p class="mb-0">
                            <i class="fas fa-shopping-cart me-2 text-warning"></i>
                            <strong class="text-warning">{{ number_format($avgSpent, 2) }} €</strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sales.create', ['client_id' => $client->id]) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-cash-register me-1"></i> Nouvelle vente
                        </a>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-edit me-1"></i> Modifier les informations
                        </a>
                        @if($client->sales->count() > 0)
                            <a href="{{ route('sales.index', ['client' => $client->id]) }}" class="btn btn-outline-primary fw-semibold" style="border-radius: 10px; border: 2px solid #336699; padding: 12px;">
                                <i class="fas fa-history me-1"></i> Historique des ventes
                            </a>
                        @endif
                        <a href="{{ route('prescriptions.create', ['client_id' => $client->id]) }}" class="btn btn-outline-success fw-semibold" style="border-radius: 10px; border: 2px solid #28a745; padding: 12px;">
                            <i class="fas fa-file-prescription me-1"></i> Nouvelle ordonnance
                        </a>
                        <button type="button" class="btn text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteModal" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-trash me-1"></i> Supprimer le client
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contact rapide -->
            @if($client->phone || $client->email || $client->emergency_contact_phone)
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #336699;">
                            <i class="fas fa-phone-alt me-2"></i>
                            Contact rapide
                        </h6>
                        <div class="d-grid gap-2">
                            @if($client->phone)
                                <a href="tel:{{ $client->phone }}" class="btn btn-outline-success btn-sm fw-semibold" style="border-radius: 10px;">
                                    <i class="fas fa-phone me-1"></i> Appeler client
                                </a>
                            @endif
                            @if($client->email)
                                <a href="mailto:{{ $client->email }}" class="btn btn-outline-primary btn-sm fw-semibold" style="border-radius: 10px;">
                                    <i class="fas fa-envelope me-1"></i> Envoyer un email
                                </a>
                            @endif
                            @if($client->emergency_contact_phone)
                                <a href="tel:{{ $client->emergency_contact_phone }}" class="btn btn-outline-danger btn-sm fw-semibold" style="border-radius: 10px;">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Contact d'urgence
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Alertes médicales -->
            @if($client->allergies)
                <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #856404;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Alerte médicale
                        </h6>
                        <div class="alert alert-warning border-0 mb-0" style="border-radius: 10px;">
                            <strong>Allergies connues :</strong><br>
                            {{ $client->allergies }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning border-0" style="border-radius: 10px;">
                    <strong><i class="fas fa-exclamation-triangle me-1"></i>Attention!</strong>
                    Cette action est irréversible.
                </div>
                <p>Êtes-vous sûr de vouloir supprimer le client <strong>{{ $client->full_name }}</strong>?</p>
                <p><strong>Conséquences :</strong></p>
                <ul>
                    <li>Le client sera définitivement supprimé</li>
                    <li>L'historique des ventes sera conservé</li>
                    <li>Cette action ne peut pas être annulée</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                        <i class="fas fa-trash me-1"></i>Supprimer définitivement
                    </button>
                </form>
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