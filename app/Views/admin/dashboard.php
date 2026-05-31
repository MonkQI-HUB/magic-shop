<?= view('templates/header', ['title' => 'Admin Dashboard - Magic Shop']) ?>

<main class="container" style="margin-top: 40px; margin-bottom: 80px;">
    <h2 class="section-title" style="text-align: left; margin-bottom: 40px;">Panel de Administración</h2>

    <!-- Admin KPI Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 48px;">
        <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 32px; text-align: center;">
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-secondary); margin-bottom: 8px;">Ventas Totales</p>
            <p style="font-size: 32px; font-family: var(--font-headline); color: var(--color-primary);">$<?= number_format($totalSales ?? 0.00, 2) ?></p>
        </div>
        <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 32px; text-align: center;">
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-secondary); margin-bottom: 8px;">Pedidos Totales</p>
            <p style="font-size: 32px; font-family: var(--font-headline); color: var(--color-text-primary);"><?= $totalOrders ?? 0 ?></p>
        </div>
        <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 32px; text-align: center;">
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-secondary); margin-bottom: 8px;">Clientes Registrados</p>
            <p style="font-size: 32px; font-family: var(--font-headline); color: var(--color-text-primary);"><?= $totalCustomers ?? 0 ?></p>
        </div>
        <div style="background-color: var(--color-surface); border: 1px solid <?= ($lowStock ?? 0) > 0 ? 'var(--color-error)' : 'var(--color-border)' ?>; padding: 32px; text-align: center;">
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-secondary); margin-bottom: 8px;">Alertas de Stock Bajo</p>
            <p style="font-size: 32px; font-family: var(--font-headline); color: <?= ($lowStock ?? 0) > 0 ? 'var(--color-error)' : 'var(--color-text-primary)' ?>;"><?= $lowStock ?? 0 ?></p>
        </div>
    </div>

    <!-- Quick Navigation Links -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
        <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 40px; text-align: center;">
            <h3 class="footer-title" style="color: var(--color-text-primary); font-size: 24px; margin-bottom: 16px;">Gestión de Catálogo</h3>
            <p style="color: var(--color-text-secondary); margin-bottom: 24px; font-size: 14px;">Añada nuevos cosméticos, edite precios, administre descripciones y actualice niveles de stock.</p>
            <a href="<?= base_url('admin/catalog') ?>" class="btn-primary">Ver Catálogo</a>
        </div>
        
        <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 40px; text-align: center;">
            <h3 class="footer-title" style="color: var(--color-text-primary); font-size: 24px; margin-bottom: 16px;">Control de Pedidos</h3>
            <p style="color: var(--color-text-secondary); margin-bottom: 24px; font-size: 14px;">Administre la cola de pedidos de los clientes, visualice facturas detalladas y actualice estados de despacho.</p>
            <a href="<?= base_url('admin/orders') ?>" class="btn-primary">Ver Pedidos</a>
        </div>
    </div>
</main>

<?= view('templates/footer') ?>
