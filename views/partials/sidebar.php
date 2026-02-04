<?php
/**
 * Reusable Sidebar Component
 * Include this file in your pages where you want a sidebar: <?php include 'sidebar/sidebar.php'; ?>
 * 
 * Features:
 * - Responsive design with mobile toggle
 * - Admin-style navigation
 * - Collapsible sections
 * - Dark mode support
 * - Multiple layout options
 */
?>

<!-- Sidebar Component -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <img src="/images/logo.svg" alt="" class="logo-img">
            </div>
            <span class="brand-name">H&S LGU</span>
        </div>
    </div>
    
    <div class="sidebar-content">
        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <!-- Main Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-section-title">Main</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="/dashboard" class="sidebar-link <?= $requestUri === '/dashboard' || $requestUri === '/' ? 'active' : '' ?>">
                            <i class="fas fa-th-large"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="/establishments" class="sidebar-link <?= str_starts_with($requestUri, '/establishments') ? 'active' : '' ?>">
                            <i class="fas fa-building"></i>
                            <span>Establishments</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="/inspections" class="sidebar-link <?= str_starts_with($requestUri, '/inspections') ? 'active' : '' ?>">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Inspections</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Compliance Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-section-title">Compliance</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="/violations" class="sidebar-link <?= str_starts_with($requestUri, '/violations') ? 'active' : '' ?>">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Violations</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="/certificates" class="sidebar-link <?= str_starts_with($requestUri, '/certificates') ? 'active' : '' ?>">
                            <i class="fas fa-certificate"></i>
                            <span>Certificates</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Admin Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-section-title">Admin</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="/users" class="sidebar-link <?= str_starts_with($requestUri, '/users') ? 'active' : '' ?>">
                            <i class="fas fa-users"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="/settings" class="sidebar-link <?= str_starts_with($requestUri, '/settings') ? 'active' : '' ?>">
                            <i class="fas fa-cog"></i>
                            <span>System Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Actions Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-section-title">Actions</h3>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="/logout" class="sidebar-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>

<!-- Sidebar Overlay for mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    // Toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('sidebar-open');
        sidebarOverlay.classList.toggle('sidebar-overlay-open');
        document.body.classList.toggle('sidebar-open');
    }
    
    // Close sidebar
    function closeSidebar() {
        sidebar.classList.remove('sidebar-open');
        sidebarOverlay.classList.remove('sidebar-overlay-open');
        document.body.classList.remove('sidebar-open');
    }

    // Expose functions globally so other scripts
    // can trigger the sidebar without duplicating logic.
    window.sidebarToggle = toggleSidebar;
    window.sidebarClose = closeSidebar;
    
    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('sidebar-open')) {
            closeSidebar();
        }
    });
    
    // Handle submenu toggles
    const submenuToggles = document.querySelectorAll('.sidebar-submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            const icon = this.querySelector('.submenu-icon');
            
            if (submenu) {
                const isOpen = submenu.classList.contains('sidebar-submenu-open');
                submenu.classList.toggle('sidebar-submenu-open');
                this.classList.toggle('active', !isOpen);
                
                // Toggle icon based on new state
                if (icon) {
                    if (submenu.classList.contains('sidebar-submenu-open')) {
                        // Now open - show up chevron
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    } else {
                        // Now closed - show down chevron
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                }
            }
        });
    });
    
    // Auto-open submenu if it contains active item
    const activeLinks = document.querySelectorAll('.sidebar-submenu .sidebar-link.active');
    activeLinks.forEach(activeLink => {
        const submenu = activeLink.closest('.sidebar-submenu');
        const toggle = submenu ? submenu.previousElementSibling : null;
        
        if (submenu && toggle && toggle.classList.contains('sidebar-submenu-toggle')) {
            submenu.classList.add('sidebar-submenu-open');
            toggle.classList.add('active');
            
            const icon = toggle.querySelector('.submenu-icon');
            if (icon) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }
    });
});
</script>
