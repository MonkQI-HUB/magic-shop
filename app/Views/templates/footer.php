    <footer>
        <div class="container footer-container">
            <div>
                <h3 class="footer-title">MAGIC SHOP</h3>
                <p>Cosméticos de lujo y cuidado personal diseñados bajo una curaduría editorial impecable y exclusiva.</p>
            </div>
            <div>
                <h3 class="footer-title">Explorar</h3>
                <ul class="footer-links">
                    <li><a href="<?= base_url() ?>">Catálogo</a></li>
                    <li><a href="<?= base_url('cart') ?>">Ver Carrito</a></li>
                </ul>
            </div>
            <div>
                <h3 class="footer-title">Seguridad</h3>
                <p>Transacciones encriptadas de forma segura de extremo a extremo.</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Magic Shop Cosmetics. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- SweetAlert2 JS Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Global application scripts -->
    <script src="<?= base_url('js/app.js') ?>"></script>
    
    <!-- Cart script to dynamically update quantities and badges -->
    <script src="<?= base_url('js/cart.js') ?>"></script>

    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= esc(session()->getFlashdata('success')) ?>',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= esc(session()->getFlashdata('error')) ?>',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>
</body>
</html>
