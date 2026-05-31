<?= view('templates/header', ['title' => 'Registrarse - Magic Shop']) ?>

<div class="container">
    <div class="form-container">
        <h2 class="form-title">Crear Cuenta</h2>
        
        <form action="<?= base_url('register') ?>" method="POST" id="register-form">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo_electronico" id="correo_electronico" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="Mínimo 8 caracteres" required>
            </div>
            
            <div class="form-group">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="edad" class="form-label">Edad (Opcional)</label>
                <input type="number" name="edad" id="edad" class="form-input" min="1" max="120">
            </div>
            
            <div class="form-action">
                <button type="submit" class="btn-primary">Registrarse</button>
            </div>
            
            <p class="form-link">¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Inicia Sesión</a></p>
        </form>
    </div>
</div>

<script>
document.getElementById('register-form').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    if (password.length < 8) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Contraseña Corta',
            text: 'La contraseña debe tener al menos 8 caracteres.',
            confirmButtonText: 'Entendido'
        });
    }
});
</script>

<?= view('templates/footer') ?>
