<?php
/**
 * Reusable Admin Header Component - Improved Design
 * Include this file in your pages: <?php include 'sidebar/admin-header.php'; ?>
 * 
 * Features:
 * - Responsive menu toggle
 * - Notification and message icons with badges (outlined style)
 * - User profile with avatar and info
 * - Dark mode support
 * - Clean, modern design
 */
?>

<!-- Admin Header Component -->
<header class="admin-header">
    <div class="admin-header-left">
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search...">
        </div>
    </div>
    
    <div class="admin-header-right">
        <div class="header-actions">
            <!-- Theme Toggle -->
            <div class="notification-item">
                <button class="notification-btn theme-toggle-btn" id="themeToggleBtn" aria-label="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
            
            <div class="notification-item">
                <button class="notification-btn" aria-label="Notifications" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                </button>
                
                <!-- Notification Modal (Inside Item) -->
                <div class="notification-modal" id="notificationModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Notifications</h3>
                            <button class="modal-close" onclick="closeModal('notificationModal')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="notificationModalBody">
                            <div style="padding: 2rem; text-align: center; color: var(--text-secondary-1);">
                                <i class="fas fa-spinner fa-spin fa-2x"></i>
                                <p style="margin-top: 1rem;">Loading notifications...</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="/notifications" class="view-all-link">View All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="notification-item">
                <button class="notification-btn" aria-label="Messages" id="messageBtn">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge">5</span>
                </button>

                <!-- Message Modal (Inside Item) -->
                <div class="notification-modal" id="messageModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Messages</h3>
                            <button class="modal-close" onclick="closeModal('messageModal')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Existing message items... -->
                            <div style="padding: 2rem; text-align: center; color: var(--text-secondary-1);">
                                <i class="fas fa-comment-dots fa-2x"></i>
                                <p style="margin-top: 1rem;">Inbox functionality coming soon.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="view-all-link">View All Messages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="header-divider"></div>
        
        <div class="user-profile" id="userProfileBtn">
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'Admin User') ?></div>
                <div class="user-role"><?= htmlspecialchars($_SESSION['user']['role'] ?? 'Administrator') ?></div>
            </div>
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['full_name'] ?? 'Admin User') ?>&background=4c8a89&color=fff&size=128" alt="User Avatar" class="avatar-img">
            </div>
            <i class="fas fa-chevron-down dropdown-icon"></i>

            <!-- User Profile Dropdown (Inside Item) -->
            <div class="user-profile-dropdown" id="userProfileDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-user-info">
                        <div class="dropdown-user-avatar">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['full_name'] ?? 'Admin User') ?>&background=4c8a89&color=fff&size=128" alt="User Avatar">
                        </div>
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-name"><?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'Admin User') ?></div>
                            <div class="dropdown-user-email"><?= htmlspecialchars($_SESSION['user']['email'] ?? 'admin@example.com') ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="dropdown-body">
                    <a href="/profile" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                    <a href="/settings" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
                
                <div class="dropdown-footer">
                    <a href="/logout" class="dropdown-item logout-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>



<script>
// Admin Header functionality
document.addEventListener('DOMContentLoaded', function() {
    // --- Dynamic Notifications Logic ---
    
    function fetchNotifications() {
        fetch('/notifications/unread')
            .then(response => response.json())
            .then(data => {
                updateNotificationUI(data.notifications || []);
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    function updateNotificationUI(notifications) {
        const badge = document.getElementById('notificationBadge');
        const body = document.getElementById('notificationModalBody');
        if (!badge || !body) return;
        
        // Update Badge
        if (notifications.length > 0) {
            badge.textContent = notifications.length;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }

        // Update Modal Content
        if (notifications.length === 0) {
            body.innerHTML = `
                <div style="padding: 3rem 2rem; text-align: center; color: var(--text-secondary-1);">
                    <i class="fas fa-bell-slash fa-3x" style="opacity: 0.2; margin-bottom: 1rem;"></i>
                    <p style="font-weight: 600;">No unread notifications</p>
                </div>
            `;
            return;
        }

        body.innerHTML = notifications.map(notif => `
            <div class="notification-item" data-id="${notif.id}" onclick="markAsRead(${notif.id}, '${notif.link || '#'}')" style="cursor: pointer;">
                <div class="notification-icon" style="background: ${getNotificationColor(notif.type)}20; color: ${getNotificationColor(notif.type)}; border: 1px solid ${getNotificationColor(notif.type)}30;">
                    <i class="${notif.icon || 'fas fa-info-circle'}"></i>
                </div>
                <div class="notification-details">
                    <div class="notification-title">${notif.title}</div>
                    <div class="notification-text">${notif.message}</div>
                    <div class="notification-time">${timeAgo(new Date(notif.created_at))}</div>
                </div>
                <div class="status-dot" style="background: ${getNotificationColor(notif.type)}"></div>
            </div>
        `).join('');
    }

    function getNotificationColor(type) {
        switch(type) {
            case 'success': return '#10b981';
            case 'warning': return '#f59e0b';
            case 'error': return '#ef4444';
            default: return '#3b82f6'; // info
        }
    }

    window.markAsRead = function(id, link) {
        fetch('/notifications/mark-read?id=' + id)
            .then(() => {
                fetchNotifications();
                if (link && link !== '#') {
                    window.location.href = link;
                }
            });
    };

    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " years ago";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " months ago";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " days ago";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " hours ago";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " minutes ago";
        return Math.floor(seconds) + " seconds ago";
    }

    // Initial Fetch
    fetchNotifications();
    setInterval(fetchNotifications, 30000); // Check every 30s

    // --- Original UI Functionality ---
    
    // Theme Toggle Logic
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = themeToggleBtn ? themeToggleBtn.querySelector('i') : null;
    
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    updateThemeIcon(currentTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function() {
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }

    function updateThemeIcon(theme) {
        if (!themeIcon) return;
        if (theme === 'dark') {
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        } else {
            themeIcon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    // Menu Toggle
    const menuToggle = document.getElementById('menuToggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            if (typeof window.sidebarToggle === 'function') {
                window.sidebarToggle();
            }
        });
    }

    // Generic Modal Toggling
    const notificationBtns = document.querySelectorAll('.admin-header .notification-btn');
    notificationBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const ariaLabel = this.getAttribute('aria-label');
            
            if (ariaLabel === 'Notifications') {
                toggleModal('notificationModal', this);
                closeModal('messageModal');
            } else if (ariaLabel === 'Messages') {
                toggleModal('messageModal', this);
                closeModal('notificationModal');
            }
        });
    });

    function toggleModal(modalId, btn) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('show')) {
            modal.classList.remove('show');
            btn.classList.remove('active');
        } else {
            modal.classList.add('show');
            btn.classList.add('active');
            // Close other elements
            const userProfileDropdown = document.getElementById('userProfileDropdown');
            if (userProfileDropdown) userProfileDropdown.classList.remove('show');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('show');
        const btn = document.querySelector(`.notification-btn[aria-label="${modalId.replace('Modal', 's')}"]`);
        if (btn) btn.classList.remove('active');
    }

    // User Profile Dropdown
    const userProfileBtn = document.getElementById('userProfileBtn');
    const userProfileDropdown = document.getElementById('userProfileDropdown');
    
    if (userProfileBtn && userProfileDropdown) {
        userProfileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            userProfileDropdown.classList.toggle('show');
            userProfileBtn.classList.toggle('active');
            // Close other modals
            const notificationModal = document.getElementById('notificationModal');
            const messageModal = document.getElementById('messageModal');
            if (notificationModal) notificationModal.classList.remove('show');
            if (messageModal) messageModal.classList.remove('show');
        });

        userProfileDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Close all when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.notification-modal') && !e.target.closest('.notification-btn')) {
            document.querySelectorAll('.notification-modal').forEach(m => m.classList.remove('show'));
            document.querySelectorAll('.notification-btn').forEach(b => b.classList.remove('active'));
        }
        if (!e.target.closest('#userProfileDropdown') && !e.target.closest('#userProfileBtn')) {
            if (userProfileDropdown) userProfileDropdown.classList.remove('show');
            if (userProfileBtn) userProfileBtn.classList.remove('active');
        }
    });

    // Make utility functions global
    window.closeModal = function(id) { 
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('show');
        const btnId = id === 'notificationModal' ? 'notificationBtn' : (id === 'messageModal' ? 'messageBtn' : null);
        if (btnId) {
            const btn = document.getElementById(btnId);
            if (btn) btn.classList.remove('active');
        }
    };
});
</script>
