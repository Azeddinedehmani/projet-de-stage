{{-- resources/views/layouts/sidebar.blade.php - Version corrigée sans conflits --}}
<div class="pharmacia-sidebar p-3" style="background: linear-gradient(180deg, #336699 0%, #4a90e2 100%); box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);">
    <!-- Logo and Brand Section -->
    <div class="text-center mb-4 pb-3 border-bottom border-light border-opacity-25">
        <div class="pharmacia-logo-container mb-3">
            <div class="pharmacia-logo-circle mx-auto mb-3" style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2); border: 3px solid rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px);">
                <img src="{{ asset('images/logo.png') }}" alt="PHARMACIA Logo" class="img-fluid" style="max-width: 50px; max-height: 50px;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <i class="fas fa-pills fa-2x" style="display: none; color: white;"></i>
            </div>
        </div>
        <h3 class="my-0 text-white fw-bold" style="font-family: 'Poppins', sans-serif; letter-spacing: 2px; font-size: 1.5rem;">PHARMACIA</h3>
        <small class="text-white-50 d-block mt-1" style="font-family: 'Rubik', sans-serif; font-weight: 300;">Système de Gestion</small>
    </div>
    
    <!-- User Profile Section -->
    <div class="pharmacia-user-profile mb-4 pb-3 border-bottom border-light border-opacity-25">
        <div class="d-flex align-items-center p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 15px; backdrop-filter: blur(5px);">
            <div class="pharmacia-user-avatar me-3" style="width: 50px; height: 50px; background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="rounded-circle" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <i class="fas fa-user fa-lg text-white"></i>
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-white" style="font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                <small class="text-white-50 d-flex align-items-center">
                    <span class="badge bg-light text-dark rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                        {{ Auth::user()->role === 'responsable' ? 'Responsable' : 'Pharmacien' }}
                    </span>
                </small>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="pharmacia-navigation-menu">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}" 
                   href="{{ Auth::user()->role === 'responsable' ? route('admin.dashboard') : route('pharmacist.dashboard') }}"
                   data-nav-item="dashboard">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span>Tableau de bord</span>
                </a>
            </li>
            
            <!-- Inventory -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('inventory*') ? 'active' : '' }}" 
                   href="{{ route('inventory.index') }}"
                   data-nav-item="inventory">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-pills"></i>
                    </div>
                    <span>Inventaire</span>
                </a>
            </li>
            
            <!-- Sales -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('sales*') ? 'active' : '' }}" 
                   href="{{ route('sales.index') }}"
                   data-nav-item="sales">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <span>Ventes</span>
                </a>
            </li>
            
            <!-- Clients -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('clients*') ? 'active' : '' }}" 
                   href="{{ route('clients.index') }}"
                   data-nav-item="clients">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <span>Clients</span>
                </a>
            </li>
            
            <!-- Prescriptions -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('prescriptions*') ? 'active' : '' }}" 
                   href="{{ route('prescriptions.index') }}"
                   data-nav-item="prescriptions">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-file-prescription"></i>
                    </div>
                    <span>Ordonnances</span>
                    @php
                        try {
                            $pendingCount = \App\Models\Prescription::where('status', 'pending')->count();
                            $expiringCount = \App\Models\Prescription::where('status', 'active')
                                ->where('expiry_date', '<=', now()->addDays(7))
                                ->count();
                            $totalAlerts = $pendingCount + $expiringCount;
                        } catch (\Exception $e) {
                            $totalAlerts = 0;
                        }
                    @endphp
                    @if($totalAlerts > 0)
                        <span class="pharmacia-notification-badge badge rounded-pill ms-auto">
                            {{ $totalAlerts }}
                        </span>
                    @endif
                </a>
            </li>
            
            <!-- Admin Only Sections -->
            @if(Auth::user()->role === 'responsable')
            
            <!-- Suppliers -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('suppliers*') ? 'active' : '' }}" 
                   href="{{ route('suppliers.index') }}"
                   data-nav-item="suppliers">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-truck"></i>
                    </div>
                    <span>Fournisseurs</span>
                    @php
                        try {
                            $inactiveSuppliers = \App\Models\Supplier::where('active', false)->count();
                        } catch (\Exception $e) {
                            $inactiveSuppliers = 0;
                        }
                    @endphp
                    @if($inactiveSuppliers > 0)
                        <span class="pharmacia-warning-badge badge rounded-pill ms-auto">
                            {{ $inactiveSuppliers }}
                        </span>
                    @endif
                </a>
            </li>
            
            <!-- Purchases -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('purchases*') ? 'active' : '' }}" 
                   href="{{ route('purchases.index') }}"
                   data-nav-item="purchases">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span>Achats</span>
                    @php
                        try {
                            $pendingPurchases = \App\Models\Purchase::where('status', 'pending')->count();
                            $overduePurchases = \App\Models\Purchase::where('expected_date', '<', now())
                                ->where('status', '!=', 'completed')
                                ->count();
                            $totalPurchaseAlerts = $pendingPurchases + $overduePurchases;
                        } catch (\Exception $e) {
                            $totalPurchaseAlerts = 0;
                        }
                    @endphp
                    @if($totalPurchaseAlerts > 0)
                        <span class="pharmacia-info-badge badge rounded-pill ms-auto">
                            {{ $totalPurchaseAlerts }}
                        </span>
                    @endif
                </a>
            </li>
            
            <!-- Reports -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('rapports*') ? 'active' : '' }}" 
                   href="{{ route('reports.index') }}"
                   data-nav-item="reports">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Rapports</span>
                </a>
            </li>
            
            <!-- Notifications -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('notifications*') ? 'active' : '' }}" 
                   href="{{ route('notifications.index') }}"
                   data-nav-item="notifications">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-bell"></i>
                    </div>
                    <span>Notifications</span>
                    @php
                        try {
                            $unreadNotifications = auth()->user()->unreadNotifications()->count();
                        } catch (\Exception $e) {
                            $unreadNotifications = 0;
                        }
                    @endphp
                    @if($unreadNotifications > 0)
                        <span class="pharmacia-notification-badge badge rounded-pill ms-auto">
                            {{ $unreadNotifications }}
                        </span>
                    @endif
                </a>
            </li>
            
            <!-- Administration Section -->
            <li class="nav-item mt-4 mb-3">
                <div class="d-flex align-items-center px-3 mb-2">
                    <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.2);"></div>
                    <span class="px-3 text-white-50 text-uppercase small fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Administration</span>
                    <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.2);"></div>
                </div>
            </li>
            
            <!-- User Management -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" 
                   href="{{ route('admin.users.index') }}"
                   data-nav-item="users">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <span>Gestion utilisateurs</span>
                    @php
                        try {
                            $inactiveUsers = \App\Models\User::where('is_active', false)->count();
                            $passwordChangeRequired = \App\Models\User::where('force_password_change', true)->count();
                            $userAlerts = $inactiveUsers + $passwordChangeRequired;
                        } catch (\Exception $e) {
                            $userAlerts = 0;
                        }
                    @endphp
                    @if($userAlerts > 0)
                        <span class="pharmacia-warning-badge badge rounded-pill ms-auto">
                            {{ $userAlerts }}
                        </span>
                    @endif
                </a>
            </li>
            
            <!-- Activity Logs -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('admin/activity-logs*') ? 'active' : '' }}" 
                   href="{{ route('admin.activity-logs') }}"
                   data-nav-item="activity-logs">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-history"></i>
                    </div>
                    <span>Logs d'activité</span>
                </a>
            </li>
            
            <!-- System Settings -->
            <li class="nav-item mb-1">
                <a class="pharmacia-nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings') }}"
                   data-nav-item="settings">
                    <div class="pharmacia-nav-icon me-3">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <span>Paramètres système</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    
    <!-- Logout Button -->
    <div class="mt-auto pt-4">
        <form method="POST" action="{{ route('logout') }}" id="pharmacia-logout-form">
            @csrf
            <button type="submit" class="btn w-100 pharmacia-logout-btn">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </button>
        </form>
    </div>
    
    <!-- Footer Info -->
    <div class="text-center mt-3 pt-3 border-top border-light border-opacity-25">
        <small class="text-white-50 d-block" style="font-size: 0.7rem;">
            © {{ date('Y') }} PHARMACIA
        </small>
        <small class="text-white-50" style="font-size: 0.65rem;">
            Version 1.0.0
        </small>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* Base sidebar styling avec préfixe pour éviter les conflits */
.pharmacia-sidebar {
    height: 100vh;
    max-height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    width: 280px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    flex-direction: column;
}

.pharmacia-sidebar::-webkit-scrollbar {
    width: 6px;
}

.pharmacia-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.pharmacia-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.pharmacia-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Logo animations avec préfixe */
.pharmacia-logo-circle {
    animation: pharmacia-logo-pulse 3s ease-in-out infinite;
}

@keyframes pharmacia-logo-pulse {
    0%, 100% {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        transform: scale(1);
    }
    50% {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
        transform: scale(1.05);
    }
}

.pharmacia-logo-container {
    position: relative;
}

.pharmacia-logo-container::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: radial-gradient(circle at center, rgba(79, 172, 254, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    animation: pharmacia-logo-glow 4s ease-in-out infinite;
}

@keyframes pharmacia-logo-glow {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.1);
    }
}

/* Navigation links styling avec préfixe */
.pharmacia-nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    padding: 12px 16px;
    margin: 2px 0;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-decoration: none !important;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    font-weight: 500;
}

.pharmacia-nav-link:hover {
    background: rgba(255, 255, 255, 0.15) !important;
    color: white !important;
    transform: translateX(5px);
    text-decoration: none !important;
}

.pharmacia-nav-link.active {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.pharmacia-nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s;
}

.pharmacia-nav-link:hover::before {
    left: 100%;
}

.pharmacia-nav-link.active::after {
    content: '';
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 20px;
    background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 2px;
    box-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
}

/* Navigation icons avec préfixe */
.pharmacia-nav-icon {
    width: 35px;
    height: 35px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Badge styles avec préfixe */
.pharmacia-notification-badge {
    background: linear-gradient(45deg, #ff6b6b 0%, #ee5a52 100%) !important;
    color: white !important;
    font-size: 0.7rem;
    padding: 4px 8px;
    animation: pharmacia-pulse 2s infinite;
}

.pharmacia-warning-badge {
    background: linear-gradient(45deg, #ffc107 0%, #ffb300 100%) !important;
    color: #212529 !important;
    font-size: 0.7rem;
    padding: 4px 8px;
}

.pharmacia-info-badge {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%) !important;
    color: white !important;
    font-size: 0.7rem;
    padding: 4px 8px;
}

@keyframes pharmacia-pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* User profile styling avec préfixe */
.pharmacia-user-profile:hover .pharmacia-user-avatar {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

/* Logout button avec préfixe */
.pharmacia-logout-btn {
    background: rgba(255, 255, 255, 0.1) !important;
    color: white !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    border-radius: 12px;
    padding: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.pharmacia-logout-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    border-color: rgba(255, 255, 255, 0.5) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    color: white !important;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .pharmacia-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        position: fixed;
        z-index: 1050;
        width: 280px;
        height: 100vh;
    }
    
    .pharmacia-sidebar.show {
        transform: translateX(0);
    }
    
    .pharmacia-nav-link {
        padding: 10px 14px;
        font-size: 0.9rem;
    }
    
    .pharmacia-nav-icon {
        width: 30px;
        height: 30px;
    }
}

/* Enhanced accessibility */
.pharmacia-nav-link:focus {
    outline: 2px solid rgba(255, 255, 255, 0.5) !important;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .pharmacia-sidebar {
        display: none !important;
    }
}

/* Smooth transitions for all interactive elements */
.pharmacia-nav-link,
.pharmacia-logout-btn,
.pharmacia-user-avatar,
.pharmacia-logo-circle {
    will-change: transform;
}

/* Assurez-vous que le contenu principal ne soit pas masqué */
.content-wrapper {
    margin-left: 280px;
    transition: margin-left 0.3s ease;
}

@media (max-width: 768px) {
    .content-wrapper {
        margin-left: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced navigation interaction avec préfixe
    const pharmaciaNavLinks = document.querySelectorAll('.pharmacia-nav-link');
    
    pharmaciaNavLinks.forEach(link => {
        // Add click feedback
        link.addEventListener('click', function(e) {
            // Add loading state for better UX
            if (!this.classList.contains('active')) {
                this.style.opacity = '0.7';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 300);
            }
        });
        
        // Keyboard navigation support
        link.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Mobile sidebar toggle (if mobile toggle button exists)
    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('.pharmacia-sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    }
    
    // Smooth logout with confirmation
    const logoutForm = document.getElementById('pharmacia-logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Optional: Add confirmation dialog
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                // Add loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Déconnexion...';
                submitBtn.disabled = true;
                
                // Submit form after brief delay for UX
                setTimeout(() => {
                    this.submit();
                }, 500);
            }
        });
    }
    
    // Badge animation on hover avec préfixe
    const pharmaciaBadges = document.querySelectorAll('.pharmacia-notification-badge, .pharmacia-warning-badge, .pharmacia-info-badge');
    pharmaciaBadges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Performance optimization: Lazy load heavy animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, { threshold: 0.1 });
    
    // Observe animated elements avec préfixe
    document.querySelectorAll('.pharmacia-logo-circle, .pharmacia-user-avatar').forEach(el => {
        observer.observe(el);
    });
    
    // Accessibility: Announce page changes to screen readers
    const currentPage = document.querySelector('.pharmacia-nav-link.active');
    if (currentPage) {
        const pageTitle = currentPage.querySelector('span').textContent;
        // Create live region for screen readers
        const liveRegion = document.createElement('div');
        liveRegion.setAttribute('aria-live', 'polite');
        liveRegion.setAttribute('aria-atomic', 'true');
        liveRegion.className = 'sr-only';
        liveRegion.textContent = `Page actuelle : ${pageTitle}`;
        document.body.appendChild(liveRegion);
    }
});
</script>