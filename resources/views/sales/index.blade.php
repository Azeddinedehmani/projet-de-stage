@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                    <i class="fas fa-cash-register text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Gestion des ventes</h2>
                    <small class="text-muted">Suivi et gestion des transactions</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('sales.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-plus me-1"></i> Nouvelle vente
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

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Total des ventes</h6>
                            <h4 class="mb-0">{{ number_format($totalSales ?? 0, 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-euro-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Nombre de ventes</h6>
                            <h4 class="mb-0">{{ $salesCount ?? 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Vente moyenne</h6>
                            <h4 class="mb-0">{{ number_format($averageSale ?? 0, 2) }} €</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title opacity-75">Aujourd'hui</h6>
                            <h4 class="mb-0">{{ isset($sales) ? $sales->where('sale_date', '>=', today())->count() : 0 }}</h4>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(33, 37, 41, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-day fa-2x" style="color: #212529;"></i>
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
            <form action="{{ route('sales.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label fw-semibold">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="N° vente, client..." value="{{ request('search') }}"
                           style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-2">
                    <label for="payment_status" class="form-label fw-semibold">Statut paiement</label>
                    <select class="form-select" id="payment_status" name="payment_status" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Tous</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Payé</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Échoué</option>
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
                    <label for="has_prescription" class="form-label fw-semibold">Ordonnance</label>
                    <select class="form-select" id="has_prescription" name="has_prescription" style="border-radius: 10px; border: 2px solid #e9ecef;">
                        <option value="">Toutes</option>
                        <option value="yes" {{ request('has_prescription') == 'yes' ? 'selected' : '' }}>Avec</option>
                        <option value="no" {{ request('has_prescription') == 'no' ? 'selected' : '' }}>Sans</option>
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

    <!-- Liste des ventes -->
    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-list me-2" style="color: #336699;"></i>
                Liste des ventes ({{ isset($sales) ? $sales->total() : 0 }})
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="border-0 fw-semibold" style="color: #336699;">N° Vente</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Client</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Vendeur</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Produits</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Montant</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Paiement</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Ordonnance</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Date</th>
                            <th class="border-0 fw-semibold" style="color: #336699;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales ?? [] as $sale)
                            <tr>
                                <td class="border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 32px; height: 32px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-receipt text-white small"></i>
                                        </div>
                                        <strong>{{ $sale->sale_number ?? 'N/A' }}</strong>
                                    </div>
                                </td>
                                <td class="border-0">
                                    @if($sale->client)
                                        <span class="fw-medium">{{ $sale->client->full_name }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Client anonyme</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @if($sale->user)
                                        <span class="fw-medium">{{ $sale->user->name }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Utilisateur supprimé</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <small>
                                        @if($sale->saleItems && $sale->saleItems->count() > 0)
                                            @foreach($sale->saleItems->take(2) as $item)
                                                @if($item->product)
                                                    {{ $item->product->name }}
                                                    @if($item->quantity > 1) ({{ $item->quantity }}) @endif
                                                @else
                                                    <span class="text-muted">Produit supprimé</span>
                                                @endif
                                                @if(!$loop->last), @endif
                                            @endforeach
                                            @if($sale->saleItems->count() > 2)
                                                <br><span class="text-muted">+{{ $sale->saleItems->count() - 2 }} autres</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Aucun produit</span>
                                        @endif
                                    </small>
                                </td>
                                <td class="border-0">
                                    <strong class="text-success" title="TVA: {{ number_format($sale->tax_rate, 1) }}%">
                                        {{ number_format($sale->total_amount ?? 0, 2) }} €
                                    </strong>
                                    <br><small class="text-muted">TVA: {{ number_format($sale->tax_rate, 1) }}%</small>
                                    @if($sale->discount_amount > 0)
                                        <br><small class="text-info">Remise: -{{ number_format($sale->discount_amount, 2) }} €</small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    @php
                                        $statusClass = match($sale->payment_status ?? 'unknown') {
                                            'paid' => 'bg-success',
                                            'pending' => 'bg-warning text-dark',
                                            'failed' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill">
                                        {{ ucfirst($sale->payment_status ?? 'Inconnu') }}
                                    </span>
                                    <br><small class="text-muted">{{ ucfirst($sale->payment_method ?? 'N/A') }}</small>
                                </td>
                                <td class="border-0">
                                    @if($sale->has_prescription)
                                        <span class="badge bg-success rounded-pill">Oui</span>
                                        @if($sale->prescription_number)
                                            <br><small class="text-muted">{{ $sale->prescription_number }}</small>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Non</span>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <span class="fw-medium">{{ $sale->sale_date ? $sale->sale_date->format('d/m/Y H:i') : 'N/A' }}</span>
                                    @if($sale->sale_date && $sale->sale_date < now()->subDays(7))
                                        <br><small class="text-muted">Ancienne</small>
                                    @endif
                                </td>
                                <td class="border-0">
                                    <div class="action-buttons d-flex flex-wrap gap-1">
                                        <!-- Bouton Voir -->
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm" 
                                           style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Bouton Imprimer -->
                                        <a href="{{ route('sales.print', $sale->id) }}" class="btn btn-sm" 
                                           style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                           target="_blank" title="Imprimer la facture">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        
                                        <!-- Bouton Modifier -->
                                        @if($sale->payment_status !== 'paid' || (Auth::check() && Auth::user()->isAdmin()))
                                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm" 
                                               style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                               title="Modifier la vente">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        
                                        <!-- Bouton Supprimer - seulement pour les admins et ventes récentes -->
                                        @if($sale->sale_date && $sale->sale_date >= now()->subDays(7) && Auth::check() && Auth::user()->isAdmin())
                                            <button type="button" class="btn btn-sm" 
                                                    style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px;" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $sale->id }}" 
                                                    title="Supprimer la vente">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 border-0">
                                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="fas fa-inbox fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Aucune vente trouvée</h5>
                                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($sales) && $sales->hasPages())
            <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                {{ $sales->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modals de suppression (placés à la fin pour éviter les conflits) -->
@if(isset($sales))
    @foreach($sales as $sale)
        @if($sale->sale_date && $sale->sale_date >= now()->subDays(7) && Auth::check() && Auth::user()->isAdmin())
            <!-- Modal de confirmation de suppression -->
            <div class="modal fade" id="deleteModal{{ $sale->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $sale->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="border-radius: 15px; border: none;">
                        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $sale->id }}">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Confirmer la suppression
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning border-0" style="border-radius: 10px;">
                                <strong><i class="fas fa-exclamation-triangle me-1"></i>Attention!</strong>
                                Cette action est irréversible.
                            </div>
                            <p>Êtes-vous sûr de vouloir supprimer la vente <strong>{{ $sale->sale_number }}</strong>?</p>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white;">
                                            <strong>Informations de la vente</strong>
                                        </div>
                                        <div class="card-body">
                                            <ul class="mb-0">
                                                <li><strong>Date :</strong> {{ $sale->sale_date->format('d/m/Y H:i') }}</li>
                                                <li><strong>Montant :</strong> {{ number_format($sale->total_amount, 2) }} € (TVA: {{ number_format($sale->tax_rate, 1) }}%)</li>
                                                <li><strong>Client :</strong> {{ $sale->client ? $sale->client->full_name : 'Anonyme' }}</li>
                                                <li><strong>Vendeur :</strong> {{ $sale->user->name }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
                                            <strong>Conséquences</strong>
                                        </div>
                                        <div class="card-body">
                                            <ul class="mb-0 text-danger">
                                                <li>La vente sera définitivement supprimée</li>
                                                <li>Le stock des produits sera restauré</li>
                                                <li>Les données ne pourront pas être récupérées</li>
                                                <li>Cette action sera tracée dans les logs</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($sale->saleItems && $sale->saleItems->count() > 0)
                                <div class="card">
                                    <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                        <strong>Produits qui seront remis en stock</strong>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0">
                                                <thead style="background: #f8f9fa;">
                                                    <tr>
                                                        <th style="color: #336699;">Produit</th>
                                                        <th class="text-center" style="color: #336699;">Quantité à remettre</th>
                                                        <th class="text-center" style="color: #336699;">Stock actuel</th>
                                                        <th class="text-center" style="color: #336699;">Nouveau stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sale->saleItems as $item)
                                                        <tr>
                                                            <td>{{ $item->product ? $item->product->name : 'Produit supprimé' }}</td>
                                                            <td class="text-center">
                                                                <span class="badge bg-warning text-dark">{{ $item->quantity }}</span>
                                                            </td>
                                                            <td class="text-center">{{ $item->product ? $item->product->stock_quantity : 'N/A' }}</td>
                                                            <td class="text-center">
                                                                @if($item->product)
                                                                    <strong class="text-success" style="font-size: 1.1rem;">
                                                                        {{ $item->product->stock_quantity + $item->quantity }}
                                                                    </strong>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Annuler</button>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display: inline;" 
                                  onsubmit="return confirm('Êtes-vous absolument certain de vouloir supprimer cette vente ? Cette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn text-white" 
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 10px;">
                                    <i class="fas fa-trash me-1"></i>Supprimer définitivement
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif
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
        transform: scale(1.002);
        transition: all 0.2s ease;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #336699;
        box-shadow: 0 0 0 0.2rem rgba(51, 102, 153, 0.25);
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
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
    
    /* Styles spéciaux pour l'affichage des montants avec TVA */
    .amount-tooltip {
        position: relative;
        cursor: help;
    }
    
    .amount-tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.9);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        white-space: nowrap;
        z-index: 1000;
        opacity: 0;
        animation: fadeInTooltip 0.3s ease forwards;
        pointer-events: none;
    }
    
    .amount-tooltip:hover::before {
        content: '';
        position: absolute;
        bottom: 110%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        opacity: 0;
        animation: fadeInTooltip 0.3s ease forwards;
    }
    
    @keyframes fadeInTooltip {
        from { 
            opacity: 0; 
            transform: translateX(-50%) translateY(5px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(-50%) translateY(0); 
        }
    }
    
    /* Styles pour les informations de TVA */
    .tax-info {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .discount-info {
        font-size: 0.75rem;
        color: #17a2b8;
        font-weight: 500;
    }
    
    /* Animation pour les cartes statistiques */
    .stats-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }
    
    .stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .stats-card:hover::before {
        left: 100%;
    }
    
    /* Styles pour les boutons d'action */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        align-items: center;
        justify-content: flex-start;
    }
    
    .action-buttons .btn {
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.875rem;
        min-width: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .action-buttons .btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Effet de ondulation pour les boutons */
    .action-buttons .btn::after {
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
    
    .action-buttons .btn:active::after {
        width: 120%;
        height: 120%;
    }
    
    /* Styles pour les modals améliorés */
    .modal-header {
        border-bottom: none;
        position: relative;
    }
    
    .modal-footer {
        border-top: none;
        padding-top: 0;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
    }
    
    .modal.fade .modal-dialog {
        transition: transform 0.4s ease-out, opacity 0.4s ease-out;
        transform: translate(0, -50px) scale(0.9);
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0) scale(1);
    }
    
    /* Styles pour les tableaux dans les modals */
    .modal .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 12px 8px;
        background: rgba(248, 249, 250, 0.8);
    }
    
    .modal .table td {
        border-top: 1px solid #dee2e6;
        font-size: 0.875rem;
        padding: 12px 8px;
        vertical-align: middle;
    }
    
    .modal .table-sm th,
    .modal .table-sm td {
        padding: 8px 6px;
        font-size: 0.8rem;
    }
    
    /* Animation pour les alertes */
    .alert {
        animation: slideInDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
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
    .btn:focus,
    .form-control:focus,
    .form-select:focus {
        outline: 2px solid #336699;
        outline-offset: 2px;
    }
    
    .btn:focus:not(:focus-visible) {
        outline: none;
    }
    
    /* Styles pour les badges de statut */
    .badge {
        position: relative;
        overflow: hidden;
    }
    
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
    
    /* Responsive pour les petits écrans */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 15px;
        }
        
        .action-buttons {
            justify-content: center;
            gap: 2px;
        }
        
        .action-buttons .btn {
            flex: 1;
            min-width: 35px;
            padding: 6px 8px;
            font-size: 0.8rem;
        }
        
        .table-responsive {
            font-size: 0.875rem;
            border-radius: 10px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-body {
            padding: 20px 15px;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .form-control,
        .form-select {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
    }
    
    @media (max-width: 576px) {
        .row.g-3 > * {
            margin-bottom: 10px;
        }
        
        .col-md-1 {
            width: 100%;
        }
        
        .action-buttons .btn {
            min-width: 32px;
            padding: 4px 6px;
        }
        
        .stats-card .card-body {
            padding: 15px;
        }
        
        .stats-card h4 {
            font-size: 1.3rem;
        }
        
        .stats-card h6 {
            font-size: 0.8rem;
        }
    }
    
    /* Animation de chargement pour les cartes */
    .card-loading {
        position: relative;
        overflow: hidden;
    }
    
    .card-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    /* Styles pour les tooltips personnalisés */
    [data-tooltip] {
        position: relative;
        cursor: help;
    }
    
    [data-tooltip]:hover::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.9);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        white-space: nowrap;
        z-index: 1000;
        opacity: 0;
        animation: fadeInTooltip 0.3s ease forwards;
        pointer-events: none;
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
    
    /* Styles pour l'état de chargement */
    .loading {
        opacity: 0.6;
        pointer-events: none;
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
        z-index: 1000;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
        
        .modal-content {
            background: rgba(33, 37, 41, 0.95);
            color: #f8f9fa;
        }
        
        .alert {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    }
    
    /* Styles pour l'impression */
    @media print {
        .btn,
        .action-buttons,
        .modal,
        .alert,
        .card-header,
        .card-footer {
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
    
    /* Animations avancées */
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            transform: translate3d(0,0,0);
        }
        40%, 43% {
            animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
            transform: translate3d(0, -30px, 0);
        }
        70% {
            animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
            transform: translate3d(0, -15px, 0);
        }
        90% {
            transform: translate3d(0,-4px,0);
        }
    }
    
    .bounce-on-hover:hover {
        animation: bounce 1s;
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
    
    /* Styles pour les éléments interactifs */
    .interactive-element {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .interactive-element:hover {
        transform: translateY(-2px);
    }
    
    .interactive-element:active {
        transform: translateY(0);
    }
    
    /* Performance optimizations */
    .card,
    .btn,
    .badge,
    .alert {
        will-change: transform;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
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
    
    /* Correction spécifique pour les boutons d'action */
    .action-buttons .btn-group {
        display: none; /* Cache l'ancien btn-group pour éviter les conflits */
    }
    
    /* Styles pour garantir l'alignement correct des boutons */
    .action-buttons {
        min-height: 40px;
        align-items: center;
    }
    
    /* Correction pour éviter que les modals se chevauchent */
    .modal {
        z-index: 1055;
    }
    
    .modal-backdrop {
        z-index: 1050;
    }
    
    /* Styles pour les confirmations de suppression */
    .btn[data-bs-toggle="modal"] {
        cursor: pointer;
    }
    
    .btn[data-bs-toggle="modal"]:hover {
        opacity: 0.9;
    }
    
    /* Styles supplémentaires pour la cohérence */
    .stats-card .card-body {
        position: relative;
        z-index: 1;
    }
    
    /* Amélioration des transitions pour mobile */
    @media (max-width: 768px) {
        .btn {
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            transform: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card:hover {
            transform: translateY(-3px) scale(1.01);
        }
    }
    
    /* Styles pour la gestion des erreurs */
    .error-state {
        opacity: 0.5;
        pointer-events: none;
    }
    
    .success-state {
        border: 2px solid #28a745;
        background: rgba(40, 167, 69, 0.05);
    }
    
    /* Animation pour les nouveaux éléments */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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
    
    /* Amélioration de la lisibilité */
    .table td {
        vertical-align: middle;
        line-height: 1.4;
    }
    
    /* Styles pour les actions en lot */
    .bulk-actions {
        background: rgba(51, 102, 153, 0.05);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid rgba(51, 102, 153, 0.1);
    }
    
    /* Correction finale pour les boutons alignés */
    .action-buttons .btn {
        margin: 0;
    }
    
    .action-buttons .btn + .btn {
        margin-left: 0;
    }
</style>
@endsection