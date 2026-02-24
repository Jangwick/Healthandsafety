<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGU-H&S | Health and Safety Intelligence Registry</title>
    <link rel="stylesheet" href="/css/landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Sticky Navigation -->
    <nav>
        <div class="nav-brand">
            <i class="fas fa-shield-alt"></i>
            <span>LGU-H&S</span>
        </div>
        <ul class="nav-links">
            <li><a href="/" class="nav-link">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#systems" class="nav-link">Systems</a></li>
            <li><a href="#departments" class="nav-link">Departments</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
                <a href="/dashboard" class="btn btn-primary">Go to Dashboard <i class="fas fa-arrow-right"></i></a>
            <?php else: ?>
                <a href="/login" class="btn btn-ghost">Sign In</a>
                <a href="/login" class="btn btn-primary">Secure Dashboard <i class="fas fa-arrow-right"></i></a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Health & Safety Intelligence <span style="color: var(--primary-teal);">Registry</span></h1>
        <p>A unified digital platform for local government health and safety management. Streamlining inspections, monitoring compliance, and ensuring public well-being.</p>
        <div class="hero-actions">
            <a href="<?= (isset($isLoggedIn) && $isLoggedIn) ? '/dashboard' : '/login' ?>" class="btn btn-primary">
                <?= (isset($isLoggedIn) && $isLoggedIn) ? 'Back to Dashboard' : 'Get Started' ?>
            </a>
            <a href="#systems" class="btn btn-ghost">Explore Systems</a>
        </div>
    </header>

    <!-- Stats Row -->
    <section class="hero-stats">
        <div class="stat-card">
            <h2>24/7</h2>
            <p>Safety Monitoring</p>
        </div>
        <div class="stat-card">
            <h2>100%</h2>
            <p>Digital Accountability</p>
        </div>
        <div class="stat-card">
            <h2>Real-time</h2>
            <p>Intelligence Engine</p>
        </div>
        <div class="stat-card">
            <h2>Secure</h2>
            <p>Auth Protocols</p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="features" id="systems">
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-building"></i></div>
            <h3>Establishment Registry</h3>
            <p>Centralized database for all business establishments with real-time status tracking and compliance history.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-clipboard-check"></i></div>
            <h3>Intelligent Inspection</h3>
            <p>Dynamic inspection engine with digital checklists, automated scoring, and instant reporting capabilities.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-bell"></i></div>
            <h3>Push Notifications</h3>
            <p>Real-time alerts for violation updates, inspection schedules, and critical safety announcements.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
            <h3>Performance Analytics</h3>
            <p>Visual intelligence dashboard for tracking safety trends, compliance rates, and administrative productivity.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-history"></i></div>
            <h3>Audit Transparency</h3>
            <p>Immutable audit logs for all administrative actions, ensuring complete accountability and data integrity.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-id-card"></i></div>
            <h3>Secure Verification</h3>
            <p>Hierarchical access control and Two-Factor Authentication (OTP) to protect sensitive government and business data.</p>
        </div>
    </section>

    <!-- Mission/Vision/Values Section -->
    <section class="mission" id="about">
        <div class="mission-card">
            <h2>Our Mission</h2>
            <p>To provide local governments with cutting-edge technology to automate safety oversight and protect citizens through proactive data intelligence.</p>
        </div>
        <div class="mission-card">
            <h2>Our Vision</h2>
            <p>Creating safer city ecosystems where technology and governance meet to ensure architectural and health standards are never compromised.</p>
        </div>
        <div class="mission-card">
            <h2>Our Values</h2>
            <p>Transparency, Integrity, and Digital Efficiency. We believe in building trust through clear, data-driven accountability.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <h2>LGU-H&S</h2>
                <p>Advanced Health and Safety Governance Platform for Local Government Units.</p>
            </div>
            <div class="footer-col">
                <h4>Registry</h4>
                <ul>
                    <li><a href="/login">Dashboard</a></li>
                    <li><a href="/login">Establishments</a></li>
                    <li><a href="/login">Inspections</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    <li><a href="#">Guidelines</a></li>
                    <li><a href="#">Forms</a></li>
                    <li><a href="#">Safety Manuals</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Citizen Charter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 LGU Health & Safety Intelligence Registry. All rights reserved.</p>
            <div style="display: flex; gap: 20px;">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <!-- Theme Toggle -->
    <div class="theme-toggle">
        <button class="theme-btn active" id="lightTheme"><i class="fas fa-sun"></i></button>
        <button class="theme-btn" id="darkTheme"><i class="fas fa-moon"></i></button>
        <button class="theme-btn" id="systemTheme"><i class="fas fa-desktop"></i></button>
    </div>

    <script>
        // Theme Toggle Logic
        const themeBtns = document.querySelectorAll('.theme-btn');
        const html = document.documentElement;

        themeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                themeBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const theme = btn.id.replace('Theme', '');
                html.setAttribute('data-theme', theme);
                localStorage.setItem('landing-theme', theme);
            });
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('landing-theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        document.getElementById(savedTheme + 'Theme').classList.add('active');
    </script>
</body>
</html>
