<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'LGU Health & Safety') ?></title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/admin-header.css">
    <link rel="stylesheet" href="/css/buttons.css">
    <link rel="stylesheet" href="/css/hero.css">
    <link rel="stylesheet" href="/css/sidebar-footer.css">
    <link rel="stylesheet" href="/css/cards.css">
    <link rel="stylesheet" href="/css/datatables.css">
    <link rel="stylesheet" href="/css/forms.css">
    <link rel="stylesheet" href="/css/textfield.css">
    <link rel="stylesheet" href="/css/message-modal.css">
    <link rel="stylesheet" href="/css/message-content-modal.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'system';
            const html = document.documentElement;
            if (savedTheme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
            } else {
                html.setAttribute('data-theme', savedTheme);
            }
        })();
    </script>
</head>
<body>
    <!-- Include Sidebar Component -->
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <!-- Include Admin Header Component -->
    <?php include __DIR__ . '/../partials/admin-header.php'; ?>
    
    <div class="main-content">
        <div class="main-container">
            <div class="title">
                <?php if (isset($breadcrumb)): ?>
                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <ol class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">Home</a></li>
                            <?php foreach ($breadcrumb as $label => $link): ?>
                                <li class="breadcrumb-item"><a href="<?= $link ?>" class="breadcrumb-link"><?= $label ?></a></li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>
                <?php endif; ?>
                <h1><?= htmlspecialchars($pageHeading ?? 'Dashboard') ?></h1>
            </div>
            
            <div class="sub-container">
                <div class="page-content">
                    <?= $content ?? '' ?>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/../partials/admin-footer.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="/js/theme-toggle.js"></script>
    <script src="/js/mobile-menu.js"></script>
</body>
</html>
