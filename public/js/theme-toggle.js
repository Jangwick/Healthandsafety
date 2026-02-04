// Theme Toggle JavaScript
class ThemeManager {
    constructor() {
        this.themes = ['system', 'light', 'dark'];
        this.currentTheme = this.getStoredTheme() || 'system';
        this.init();
    }

    init() {
        this.applyTheme(this.currentTheme);
        this.setupEventListeners();
        this.updateActiveButton();
    }

    getStoredTheme() {
        return localStorage.getItem('theme');
    }

    setStoredTheme(theme) {
        localStorage.setItem('theme', theme);
    }

    applyTheme(theme) {
        const root = document.documentElement;
        
        if (theme === 'system') {
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            root.setAttribute('data-theme', systemTheme);
        } else {
            root.setAttribute('data-theme', theme);
        }
        
        this.currentTheme = theme;
        this.setStoredTheme(theme);
        this.updateActiveButton();
        this.updateHeaderIcon();
    }

    updateHeaderIcon() {
        const singleToggle = document.getElementById('themeToggleBtn');
        if (singleToggle) {
            const icon = singleToggle.querySelector('i');
            if (icon) {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }
        }
    }

    setupEventListeners() {
        // Theme toggle buttons (multi-button setup)
        const themeButtons = document.querySelectorAll('.theme-toggle .theme-toggle-btn');
        themeButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const theme = e.currentTarget.getAttribute('data-theme');
                this.applyTheme(theme);
            });
        });

        // Single toggle button (usually in header)
        const singleToggle = document.getElementById('themeToggleBtn');
        if (singleToggle) {
            singleToggle.addEventListener('click', () => {
                const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
                this.applyTheme(newTheme);
            });
        }

        // Listen for system theme changes
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', () => {
            if (this.currentTheme === 'system') {
                this.applyTheme('system');
            }
        });
    }

    updateActiveButton() {
        const themeButtons = document.querySelectorAll('.theme-toggle-btn');
        themeButtons.forEach(button => {
            const buttonTheme = button.getAttribute('data-theme');
            if (buttonTheme === this.currentTheme) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

    getCurrentTheme() {
        return this.currentTheme;
    }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Make it globally accessible
window.ThemeManager = ThemeManager;
