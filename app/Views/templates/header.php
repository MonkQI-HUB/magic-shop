<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Magic Shop Cosmetics') ?></title>
    <!-- Stitch Design DNA Modular CSS Sheets -->
    <link rel="stylesheet" href="<?= base_url('css/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/forms.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/catalog.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/alerts.css') ?>">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Helper global para resolución de URLs relativas en AJAX -->
    <script>
        const BASE_URL = '<?= base_url() ?>';
        function getAbsoluteUrl(path) {
            let cleanPath = path.startsWith('/') ? path.substring(1) : path;
            let cleanBase = BASE_URL.endsWith('/') ? BASE_URL : BASE_URL + '/';
            return cleanBase + cleanPath;
        }
    </script>
</head>
<body>
    <header>
        <div class="container header-container">
            <a href="<?= base_url() ?>" class="logo">MAGIC SHOP</a>
            
            <!-- Botón del menú móvil -->
            <button class="mobile-nav-toggle" aria-label="Abrir menú" onclick="toggleMobileMenu(this)">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-links" id="nav-links-menu">
                <li><a href="<?= base_url() ?>" class="<?= (current_url() == base_url() || current_url() == base_url('catalog')) ? 'active' : '' ?>">Catálogo</a></li>
                <?php if (session()->get('logged_in')): ?>
                    <?php if (session()->get('id_rol') == 2): ?>
                        <li><a href="<?= base_url('admin/dashboard') ?>" class="<?= (strpos(current_url(), 'admin') !== false) ? 'active' : '' ?>">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('logout') ?>">Salir</a></li>
                <?php else: ?>
                    <li><a href="<?= base_url('login') ?>" class="<?= (current_url() == base_url('login')) ? 'active' : '' ?>">Entrar</a></li>
                    <li><a href="<?= base_url('register') ?>" class="<?= (current_url() == base_url('register')) ? 'active' : '' ?>">Registrarse</a></li>
                <?php endif; ?>
            </ul>
            <div class="header-actions">
                <?php if (session()->get('logged_in')): ?>
                    <span class="user-greeting">Hola, <strong><?= esc(session()->get('nombre')) ?></strong></span>
                <?php endif; ?>
                <a href="<?= base_url('cart') ?>" class="cart-icon">
                    🛒
                    <span class="cart-badge" id="cart-badge-count">0</span>
                </a>
            </div>
        </div>
    </header>

    <script>
        function toggleMobileMenu(button) {
            button.classList.toggle('active');
            const menu = document.getElementById('nav-links-menu');
            if (menu) {
                menu.classList.toggle('active');
            }
        }
    </script>
