<?= view('templates/header', ['title' => 'Entrar - Magic Shop']) ?>

<div class="container">
    <div class="form-container">
        <h2 class="form-title">Iniciar Sesión</h2>
        
        <form action="<?= base_url('login') ?>" method="POST" id="login-form">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo_electronico" id="correo_electronico" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-input" required>
            </div>
            
            <div class="form-action">
                <button type="submit" class="btn-primary">Iniciar Sesión</button>
            </div>
            
            <p class="form-link">¿No tienes cuenta? <a href="<?= base_url('register') ?>">Créala aquí</a></p>
        </form>
    </div>
</div>

<?= view('templates/footer') ?>
