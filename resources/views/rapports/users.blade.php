@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e8 100%); margin: -20px; padding: 20px;">
    <!-- Header Section -->
    <div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(51, 102, 153, 0.3);">
                <i class="fas fa-users text-white fa-lg"></i>
            </div>
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif; color: #2c3e50;">Rapport des utilisateurs</h2>
                <small class="text-muted">Analyse de l'activité et des performances des utilisateurs</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn text-white fw-semibold me-2" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-1"></i> Retour aux rapports
            </a>
            <a href="{{ route('reports.users.pdf', request()->query()) }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 15px rgba(51, 102, 153, 0.3); transition: all 0.3s ease;">
                <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
            </a>
        </div>
    </div>
</div>
    <!-- Filtres de période -->
    <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-calendar-alt me-2" style="color: #336699;"></i>
                Période d'analyse
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.users') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="date_from" class="form-label fw-semibold">Date de début</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $dateFrom }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-4">
                    <label for="date_to" class="form-label fw-semibold">Date de fin</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $dateTo }}" style="border-radius: 10px; border: 2px solid #e9ecef;">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn w-100 text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                        <i class="fas fa-search me-1"></i> Analyser
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-2 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <h4 class="mb-0">{{ $totalUsers }}</h4>
                    <small class="opacity-75">Total utilisateurs</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <h4 class="mb-0">{{ $activeUsers }}</h4>
                    <small class="opacity-75">Utilisateurs actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <h4 class="mb-0">{{ $adminUsers }}</h4>
                    <small class="opacity-75">Administrateurs</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #212529; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <h4 class="mb-0">{{ $pharmacistUsers }}</h4>
                    <small class="opacity-75">Pharmaciens</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background:linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <h4 class="mb-0">{{ $usersNeedingPasswordChange }}</h4>
                    <small class="opacity-75">MDP à changer</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center">
                    <h4 class="mb-0">{{ number_format(($activeUsers / max($totalUsers, 1)) * 100, 1) }}%</h4>
                    <small class="opacity-75">Taux d'activité</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Top utilisateurs par activité -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2" style="color: #336699;"></i>
                        Top utilisateurs par activité sur la période
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($topUsersByActivity->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Utilisateur</th>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Rôle</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Actions</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Jours actifs</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Dernière connexion</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsersByActivity as $user)
                                        <tr class="border-0">
                                            <td class="border-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%);">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        <br><small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0">
                                                <span class="badge {{ $user->role === 'responsable' ? 'bg-danger' : 'bg-primary' }} rounded-pill">
                                                    {{ $user->role === 'responsable' ? 'Admin' : 'Pharmacien' }}
                                                </span>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-info rounded-pill">{{ $user->activity_count }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-success rounded-pill">{{ $user->active_days }}</span>
                                            </td>
                                            <td class="text-center border-0">
                                                @if($user->last_login_at)
                                                    <small class="fw-medium">{{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}</small>
                                                @else
                                                    <small class="text-muted">Jamais</small>
                                                @endif
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-users fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucune activité utilisateur</h5>
                            <p class="text-muted">Aucune activité utilisateur pour cette période</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Évolution mensuelle de l'activité -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                        Évolution de l'activité (12 derniers mois)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="activityChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Actions les plus fréquentes -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-list me-2" style="color: #336699;"></i>
                        Actions les plus fréquentes
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($topActions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="border-0 fw-semibold" style="color: #336699;">Action</th>
                                        <th class="border-0 fw-semibold text-center" style="color: #336699;">Nombre</th>
                                        <th class="border-0 fw-semibold text-end" style="color: #336699;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalActions = $topActions->sum('count'); @endphp
                                    @foreach($topActions as $action)
                                        <tr class="border-0">
                                            <td class="border-0">
                                                @switch($action->action)
                                                    @case('login')
                                                        <i class="fas fa-sign-in-alt text-success me-2"></i>Connexion
                                                        @break
                                                    @case('logout')
                                                        <i class="fas fa-sign-out-alt text-secondary me-2"></i>Déconnexion
                                                        @break
                                                    @case('create')
                                                        <i class="fas fa-plus text-primary me-2"></i>Création
                                                        @break
                                                    @case('update')
                                                        <i class="fas fa-edit text-warning me-2"></i>Modification
                                                        @break
                                                    @case('delete')
                                                        <i class="fas fa-trash text-danger me-2"></i>Suppression
                                                        @break
                                                    @case('view')
                                                        <i class="fas fa-eye text-info me-2"></i>Consultation
                                                        @break
                                                    @default
                                                        <i class="fas fa-cog text-muted me-2"></i>{{ ucfirst($action->action) }}
                                                @endswitch
                                            </td>
                                            <td class="text-center border-0">
                                                <span class="badge bg-secondary rounded-pill">{{ $action->count }}</span>
                                            </td>
                                            <td class="text-end border-0">
                                                <span class="fw-bold">{{ $totalActions > 0 ? number_format(($action->count / $totalActions) * 100, 1) : 0 }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="mb-0 text-muted">Aucune action pour cette période</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Connexions récentes -->
            <div class="card mb-4 border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Connexions récentes
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentLogins->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentLogins->take(10) as $login)
                                <div class="list-group-item border-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 fw-bold">{{ $login->user->name ?? 'Utilisateur supprimé' }}</h6>
                                        <small class="fw-medium">{{ $login->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            <i class="fas fa-globe me-1"></i>{{ $login->ip_address ?? 'IP inconnue' }}
                                        </small>
                                    </p>
                                    @if($login->user_agent)
                                        <small class="text-muted">
                                            {{ substr($login->user_agent, 0, 50) }}{{ strlen($login->user_agent) > 50 ? '...' : '' }}
                                        </small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($recentLogins->count() > 10)
                            <div class="card-footer border-0 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                                <small class="text-muted fw-medium">
                                    Et {{ $recentLogins->count() - 10 }} autres connexions...
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-sign-in-alt fa-2x mb-2 text-muted"></i>
                            <p class="mb-0 text-muted">Aucune connexion récente</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-bolt me-2" style="color: #336699;"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn text-white fw-semibold" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-users me-2"></i>
                            Gestion des utilisateurs
                        </a>
                        
                        <a href="{{ route('admin.users.create') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-user-plus me-2"></i>
                            Ajouter un utilisateur
                        </a>
                        
                        <a href="{{ route('admin.activity-logs') }}" class="btn text-white fw-semibold" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-history me-2"></i>
                            Logs d'activité complets
                        </a>
                        
                        <a href="{{ route('admin.users.index', ['status' => 'inactive']) }}" class="btn text-dark fw-semibold" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="fas fa-user-times me-2"></i>
                            Utilisateurs inactifs
                        </a>
                    </div>
                </div>
                <div class="card-footer border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 0 0 15px 15px;">
                    <small class="text-muted fw-medium">
                        <i class="fas fa-info-circle me-1"></i>
                        Période analysée : {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance des ventes -->
    @if($salesPerformance->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2" style="color: #336699;"></i>
                        Performance des ventes par utilisateur
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Utilisateur</th>
                                    <th class="border-0 fw-semibold" style="color: #336699;">Rôle</th>
                                    <th class="border-0 fw-semibold text-center" style="color: #336699;">Nb ventes</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">CA total</th>
                                    <th class="border-0 fw-semibold text-end" style="color: #336699;">Panier moyen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesPerformance as $user)
                                    <tr class="border-0">
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px; background: linear-gradient(180deg, #336699 0%, #4a90e2 100%);">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    <br><small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <span class="badge {{ $user->role === 'responsable' ? 'bg-danger' : 'bg-primary' }} rounded-pill">
                                                {{ $user->role === 'responsable' ? 'Admin' : 'Pharmacien' }}
                                            </span>
                                        </td>
                                        <td class="text-center border-0">
                                            <span class="badge bg-info rounded-pill">{{ $user->sales_count }}</span>
                                        </td>
                                        <td class="text-end border-0">
                                            <strong style="color: #28a745;">{{ number_format($user->total_sales_amount, 2) }} €</strong>
                                        </td>
                                        <td class="text-end border-0">
                                            {{ number_format($user->average_sale_amount, 2) }} €
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background-color: #f8f9fa;">
                                <tr>
                                    <th colspan="2" class="border-0 fw-bold">Total</th>
                                    <th class="text-center border-0 fw-bold">{{ $salesPerformance->sum('sales_count') }}</th>
                                    <th class="text-end border-0 fw-bold">{{ number_format($salesPerformance->sum('total_sales_amount'), 2) }} €</th>
                                    <th class="text-end border-0 fw-bold">
                                        {{ $salesPerformance->sum('sales_count') > 0 ? number_format($salesPerformance->sum('total_sales_amount') / $salesPerformance->sum('sales_count'), 2) : '0.00' }} €
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Analyse détaillée -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-pie me-2" style="color: #336699;"></i>
                        Analyse de la répartition
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);">
                                @php
                                    $adminPercentage = $totalUsers > 0 ? ($adminUsers / $totalUsers) * 100 : 0;
                                @endphp
                                <h4 class="text-danger fw-bold">{{ number_format($adminPercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">Administrateurs</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                @php
                                    $pharmacistPercentage = $totalUsers > 0 ? ($pharmacistUsers / $totalUsers) * 100 : 0;
                                @endphp
                                <h4 class="fw-bold" style="color: #336699;">{{ number_format($pharmacistPercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">Pharmaciens</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c8 100%);">
                                @php
                                    $activePercentage = $totalUsers > 0 ? ($activeUsers / $totalUsers) * 100 : 0;
                                @endphp
                                <h4 class="text-success fw-bold">{{ number_format($activePercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">Utilisateurs actifs</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3" style="border-radius: 10px !important; background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);">
                                @php
                                    $passwordChangePercentage = $totalUsers > 0 ? ($usersNeedingPasswordChange / $totalUsers) * 100 : 0;
                                @endphp
                                <h4 class="text-warning fw-bold">{{ number_format($passwordChangePercentage, 1) }}%</h4>
                                <small class="text-muted fw-medium">MDP à changer</small>
                            </div>
                        </div>
                    </div>
                </div>
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
        border: none !important;
    }
    
    .text-primary {
        color: #336699 !important;
    }
    
    .bg-primary {
        background: linear-gradient(180deg, #336699 0%, #4a90e2 100%) !important;
    }
    
    .fw-semibold {
        font-weight: 600;
    }
    
    .fw-bold {
        font-weight: 700;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    .form-control, .form-select {
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .form-control:hover, .form-select:hover {
        border-color: #336699;
        box-shadow: 0 2px 8px rgba(51, 102, 153, 0.1);
    }
    
    .form-label {
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    /* Amélioration des badges */
    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }
    
    /* Amélioration des list-group-item */
    .list-group-item {
        background: transparent !important;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background: linear-gradient(135deg, rgba(51, 102, 153, 0.05) 0%, rgba(74, 144, 226, 0.05) 100%) !important;
        transform: translateX(5px);
    }
    
    .list-group-item:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* Effet glassmorphism pour les cartes */
    .card {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Animation pour les avatars */
    .rounded-circle {
        transition: all 0.3s ease;
    }
    
    .rounded-circle:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 4px 15px rgba(51, 102, 153, 0.4);
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .row .col-md-2 {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique d'évolution de l'activité mensuelle
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    const monthlyData = @json($userActivityByMonth);
    
    new Chart(activityCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => {
                const [year, month] = item.month.split('-');
                return new Date(year, month - 1).toLocaleDateString('fr-FR', { 
                    year: 'numeric', 
                    month: 'short' 
                });
            }),
            datasets: [{
                label: 'Total d\'activités',
                data: monthlyData.map(item => item.activity_count),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }, {
                label: 'Utilisateurs actifs',
                data: monthlyData.map(item => item.active_users),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.1,
                yAxisID: 'y1',
                borderWidth: 3,
                pointBackgroundColor: 'rgb(34, 197, 94)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Évolution de l\'activité utilisateur',
                    font: {
                        family: 'Poppins',
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#2c3e50'
                },
                legend: {
                    labels: {
                        font: {
                            family: 'Rubik',
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#2c3e50',
                    bodyColor: '#2c3e50',
                    borderColor: '#336699',
                    borderWidth: 2,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Nombre d\'activités',
                        font: {
                            family: 'Rubik',
                            weight: '500'
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Utilisateurs actifs',
                        font: {
                            family: 'Rubik',
                            weight: '500'
                        }
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            family: 'Rubik'
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
    
    // Animation d'entrée pour les cartes
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Effet de compteur pour les statistiques
    const statNumbers = document.querySelectorAll('.card h4');
    statNumbers.forEach(number => {
        const text = number.textContent;
        const finalValue = parseFloat(text.replace(/[^\d.,]/g, '').replace(',', '.'));
        
        if (finalValue && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 30;
            const hasPercent = text.includes('%');
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    current = finalValue;
                    clearInterval(timer);
                }
                
                if (hasPercent) {
                    number.textContent = current.toFixed(1) + '%';
                } else {
                    number.textContent = Math.floor(current);
                }
            }, 50);
        }
    });
    
    // Animation pour les badges de rôle
    const roleBadges = document.querySelectorAll('.badge.bg-danger, .badge.bg-primary');
    roleBadges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.3)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Animation pour les badges d'activité
    const activityBadges = document.querySelectorAll('.badge.bg-info, .badge.bg-success');
    activityBadges.forEach(badge => {
        const value = parseInt(badge.textContent);
        if (value > 50) { // Utilisateurs très actifs
            badge.style.animation = 'pulse-success 3s infinite';
        }
    });
    
    // Ajout des animations CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse-success {
            0%, 100% { transform: scale(1); box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
            50% { transform: scale(1.05); box-shadow: 0 0 15px rgba(40, 167, 69, 0.8); }
        }
        
        @keyframes glow-warning {
            0%, 100% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
            50% { box-shadow: 0 0 15px rgba(255, 193, 7, 0.8); }
        }
    `;
    document.head.appendChild(style);
    
    // Interaction avec les avatars d'utilisateurs
    const userAvatars = document.querySelectorAll('.rounded-circle');
    userAvatars.forEach(avatar => {
        avatar.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(45deg, #336699 0%, #4a90e2 50%, #20c997 100%)';
            this.style.transform = 'scale(1.2) rotate(10deg)';
        });
        
        avatar.addEventListener('mouseleave', function() {
            this.style.background = 'linear-gradient(180deg, #336699 0%, #4a90e2 100%)';
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });
    
    // Animation pour les connexions récentes
    const loginItems = document.querySelectorAll('.list-group-item');
    loginItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.4s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 200 + (index * 50));
        
        item.addEventListener('mouseenter', function() {
            this.style.borderLeft = '4px solid #28a745';
            this.style.paddingLeft = '1.5rem';
            this.style.backgroundColor = 'rgba(40, 167, 69, 0.05)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.borderLeft = 'none';
            this.style.paddingLeft = '1rem';
            this.style.backgroundColor = 'transparent';
        });
    });
    
    // Interaction avec les icônes d'actions
    const actionIcons = document.querySelectorAll('.fa-sign-in-alt, .fa-sign-out-alt, .fa-plus, .fa-edit, .fa-trash, .fa-eye, .fa-cog');
    actionIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.3)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Animation pour les badges de pourcentage dans l'analyse
    const percentageBadges = document.querySelectorAll('.row.text-center h4');
    percentageBadges.forEach(badge => {
        const percentage = parseFloat(badge.textContent);
        if (percentage > 80) {
            badge.style.animation = 'glow-success 3s infinite';
        } else if (percentage > 50) {
            badge.style.animation = 'glow-warning 3s infinite';
        }
    });
    
    // Effet de survol sur les cartes de statistiques principales
    const statCards = document.querySelectorAll('.row.mb-4 .card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.2)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-5px) scale(1)';
            this.style.boxShadow = '0 8px 25px rgba(51, 102, 153, 0.3)';
        });
    });
    
    // Animation des éléments au défilement
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    // Observer tous les éléments de tableau
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'all 0.6s ease';
        observer.observe(row);
    });
    
    // Effet de pulsation pour les utilisateurs nécessitant un changement de mot de passe
    const passwordChangeCard = document.querySelector('.card[style*="dc3545"]');
    if (passwordChangeCard) {
        const passwordCount = parseInt(passwordChangeCard.querySelector('h4').textContent);
        if (passwordCount > 0) {
            passwordChangeCard.style.animation = 'pulse-danger 2s infinite';
            
            // Ajout de l'animation pour les mots de passe
            const dangerStyle = document.createElement('style');
            dangerStyle.textContent = `
                @keyframes pulse-danger {
                    0%, 100% { transform: translateY(-5px) scale(1); box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3); }
                    50% { transform: translateY(-5px) scale(1.02); box-shadow: 0 12px 35px rgba(220, 53, 69, 0.5); }
                }
            `;
            document.head.appendChild(dangerStyle);
        }
    }
});
</script>
@endsection