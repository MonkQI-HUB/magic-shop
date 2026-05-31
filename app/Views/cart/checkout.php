<?= view('templates/header', ['title' => 'Carrito - Magic Shop']) ?>

<main class="container" style="margin-top: 40px; margin-bottom: 80px;">
    <h2 class="section-title">Tu Carrito</h2>
    
    <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 32px;">
        <?php if (!empty($cart['items'])): ?>
            <table style="width: 100%; border-collapse: collapse; text-align: left; margin-bottom: 32px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--color-border); text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: var(--color-text-secondary);">
                        <th style="padding-bottom: 16px;">Producto</th>
                        <th style="padding-bottom: 16px;">Precio</th>
                        <th style="padding-bottom: 16px; text-align: center;">Cantidad</th>
                        <th style="padding-bottom: 16px; text-align: right;">Total</th>
                        <th style="padding-bottom: 16px; text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    foreach ($cart['items'] as $item): 
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $grand_total += $subtotal;
                    ?>
                            <td style="padding: 16px 0; display: flex; align-items: center; gap: 16px;">
                                <?php
                                $imgSrc = $item['imagen_url'];
                                if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                                    $imgSrc = base_url($imgSrc);
                                }
                                ?>
                                <img src="<?= esc($imgSrc) ?>" alt="<?= esc($item['nombre_producto']) ?>" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid var(--color-border);" onerror="this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=400';">
                                <span style="font-weight: 700;"><?= esc($item['nombre_producto']) ?></span>
                            </td>
                            <td style="padding: 16px 0;">$<?= number_format($item['precio'], 2) ?></td>
                            <td style="padding: 16px 0; text-align: center;">
                                <input type="number" value="<?= $item['cantidad'] ?>" min="1" style="width: 60px; padding: 6px; border: 1px solid var(--color-border); text-align: center;" onchange="updateQuantity(<?= $item['id_producto'] ?>, this.value)">
                            </td>
                            <td style="padding: 16px 0; text-align: right; font-weight: 700;">$<?= number_format($subtotal, 2) ?></td>
                            <td style="padding: 16px 0; text-align: center;">
                                <button type="button" style="color: var(--color-error); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;" onclick="removeFromCart(<?= $item['id_producto'] ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-top: 1px solid var(--color-border); padding-top: 32px;">
                <div style="max-width: 400px;">
                    <p style="font-size: 14px; color: var(--color-text-secondary); line-height: 1.6;">
                        * El inventario de los productos en tu carrito está sujeto a disponibilidad y confirmación inmediata en bodega al momento de procesar la orden.
                    </p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 14px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-secondary); margin-bottom: 8px;">Total del Pedido</p>
                    <p style="font-size: 32px; font-family: var(--font-headline); color: var(--color-primary); margin-bottom: 24px;">$<?= number_format($grand_total, 2) ?></p>
                    
                    <?php if (session()->get('logged_in')): ?>
                        <form action="<?= base_url('cart/checkout') ?>" method="POST" id="checkout-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-primary" style="width: 250px;">Confirmar y Pagar</button>
                        </form>
                    <?php else: ?>
                        <div style="background-color: var(--color-surface-dim); padding: 16px 24px; text-align: center;">
                            <p style="font-size: 14px; margin-bottom: 12px;">Debes iniciar sesión para finalizar tu pedido.</p>
                            <a href="<?= base_url('login') ?>" class="btn-primary" style="width: 200px;">Iniciar Sesión</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 48px 0;">
                <p style="font-size: 16px; color: var(--color-text-secondary); margin-bottom: 24px;">Tu carrito de compras está vacío.</p>
                <a href="<?= base_url() ?>" class="btn-primary">Explorar Colección</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?= view('templates/footer') ?>
