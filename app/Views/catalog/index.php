<?= view('templates/header', ['title' => 'Catálogo - Magic Shop']) ?>

<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Aura Luxury Editorial</h1>
        <p>Curaduría exclusiva de cosméticos de alta eficacia y estética premium. Descubre el arte del cuidado personal.</p>
    </div>
</section>

<main class="container">
    <h2 class="section-title">Nuestra Colección</h2>
    
    <div class="product-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <?php
                        $imgSrc = $p['imagen_url'];
                        if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                            $imgSrc = base_url($imgSrc);
                        }
                        ?>
                        <img src="<?= esc($imgSrc) ?>" alt="<?= esc($p['nombre_producto']) ?>" class="product-image" onerror="this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=400';">
                        <?php if ($p['stock'] <= 0): ?>
                            <span class="badge badge-sale">Agotado</span>
                        <?php elseif ($p['stock'] <= 5): ?>
                            <span class="badge badge-new">¡Pocas Unidades!</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?= esc($p['categoria'] ?? 'Cosmético') ?></span>
                        <h3 class="product-name"><?= esc($p['nombre_producto']) ?></h3>
                        <div class="product-meta">
                            <span class="product-price">$<?= number_format($p['precio'], 2) ?></span>
                            <span class="product-stock <?= $p['stock'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                <?= $p['stock'] > 0 ? "Stock: {$p['stock']}" : 'Sin inventario' ?>
                            </span>
                        </div>
                        <?php if ($p['stock'] > 0): ?>
                            <button class="btn-add-to-cart" onclick="addToCart(<?= $p['id_producto'] ?>)">
                                Añadir al Carrito
                            </button>
                        <?php else: ?>
                            <button class="btn-add-to-cart btn-disabled" disabled>
                                Agotado
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-products">
                <p>No se encontraron cosméticos disponibles en este momento. Vuelva a consultar más tarde.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?= view('templates/footer') ?>
