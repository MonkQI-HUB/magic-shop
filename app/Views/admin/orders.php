<?= view('templates/header', ['title' => 'Control de Pedidos - Admin']) ?>

<main class="container" style="margin-top: 40px; margin-bottom: 80px;">
    <h2 class="section-title" style="text-align: left; margin-bottom: 40px;">Control de Pedidos</h2>

    <!-- Orders Table -->
    <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 32px;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-border); text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: var(--color-text-secondary);">
                    <th style="padding-bottom: 16px;">ID Pedido</th>
                    <th style="padding-bottom: 16px;">Cliente</th>
                    <th style="padding-bottom: 16px;">Fecha</th>
                    <th style="padding-bottom: 16px;">Total</th>
                    <th style="padding-bottom: 16px; text-align: center;">Estado</th>
                    <th style="padding-bottom: 16px; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $o): ?>
                        <tr style="border-bottom: 1px solid var(--color-surface-dim);">
                            <td style="padding: 16px 0; font-weight: 700;" data-label="ID Pedido">#<?= $o['id_pedido'] ?></td>
                            <td style="padding: 16px 0; font-weight: 700;" data-label="Cliente"><?= esc($o['nombre']) ?> <?= esc($o['apellido']) ?></td>
                            <td style="padding: 16px 0; color: var(--color-text-secondary);" data-label="Fecha"><?= $o['fecha_pedido'] ?></td>
                            <td style="padding: 16px 0; font-weight: 700; color: var(--color-primary);" data-label="Total">$<?= number_format($o['total'], 2) ?></td>
                            <td style="padding: 16px 0; text-align: center;" data-label="Estado">
                                <form action="<?= base_url('admin/orders/update-status/' . $o['id_pedido']) ?>" method="POST" style="display: inline-block;">
                                    <?= csrf_field() ?>
                                    <select name="estado" style="padding: 6px; border: 1px solid var(--color-border); font-family: var(--font-body); font-weight: 700;" onchange="this.form.submit()">
                                        <option value="Pendiente" <?= $o['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="Procesando" <?= $o['estado'] == 'Procesando' ? 'selected' : '' ?>>Procesando</option>
                                        <option value="Enviado" <?= $o['estado'] == 'Enviado' ? 'selected' : '' ?>>Enviado</option>
                                        <option value="Completado" <?= $o['estado'] == 'Completado' ? 'selected' : '' ?>>Completado</option>
                                        <option value="Cancelado" <?= $o['estado'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                </form>
                            </td>
                            <td style="padding: 16px 0; text-align: center;" data-label="Acciones">
                                <button class="btn-secondary" style="padding: 6px 12px; font-size: 11px;" onclick="viewOrderDetails(<?= $o['id_pedido'] ?>)">Ver Detalles</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 32px; color: var(--color-text-secondary);">No se han realizado pedidos en la tienda aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Order Details Modal -->
    <div id="details-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 48px; max-width: 600px; width: 90%; position: relative;">
            <button onclick="closeDetailsModal()" style="position: absolute; top: 16px; right: 16px; font-size: 20px; font-weight: 700;">&times;</button>
            <h3 class="form-title" style="margin-bottom: 24px;" id="details-modal-title">Detalles del Pedido</h3>
            
            <div id="details-container" style="max-height: 300px; overflow-y: auto; margin-bottom: 32px;">
                <!-- Dynamically loaded details -->
            </div>
            
            <div style="text-align: right;">
                <button type="button" class="btn-secondary" onclick="closeDetailsModal()">Cerrar</button>
            </div>
        </div>
    </div>
</main>

<script>
function viewOrderDetails(id) {
    document.getElementById('details-modal-title').innerText = 'Detalles del Pedido #' + id;
    var container = document.getElementById('details-container');
    container.innerHTML = '<p style="text-align: center; padding: 16px;">Cargando detalles...</p>';
    document.getElementById('details-modal').style.display = 'flex';

    fetch(getAbsoluteUrl('admin/orders/details/' + id))
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                var html = '<table style="width:100%; border-collapse: collapse; text-align:left;">';
                html += '<tr style="border-bottom: 1px solid var(--color-border); font-size:11px; text-transform:uppercase; color:var(--color-text-secondary);">';
                html += '<th style="padding-bottom:12px;">Producto</th><th style="padding-bottom:12px; text-align:center;">Qty</th><th style="padding-bottom:12px; text-align:right;">Subtotal</th></tr>';
                
                data.details.forEach(item => {
                    var sub = item.precio_unitario * item.cantidad;
                    html += '<tr style="border-bottom: 1px solid var(--color-surface-dim);">';
                    html += '<td style="padding: 12px 0; display:flex; align-items:center; gap:12px;">';
                    html += '<img src="' + item.imagen_url + '" style="width:40px; height:40px; object-fit:cover; border:1px solid var(--color-border);" onerror="this.src=\'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=400\';">';
                    html += '<span style="font-weight:700;">' + item.nombre_producto + '</span></td>';
                    html += '<td style="padding: 12px 0; text-align:center;">' + item.cantidad + '</td>';
                    html += '<td style="padding: 12px 0; text-align:right; font-weight:700;">$' + sub.toFixed(2) + '</td>';
                    html += '</tr>';
                });
                
                html += '</table>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p style="text-align:center; padding:16px; color:var(--color-error);">No se pudieron cargar los detalles.</p>';
            }
        })
        .catch(err => {
            console.error('Error fetching details:', err);
            container.innerHTML = '<p style="text-align:center; padding:16px; color:var(--color-error);">Error de red.</p>';
        });
}

function closeDetailsModal() {
    document.getElementById('details-modal').style.display = 'none';
}
</script>

<?= view('templates/footer') ?>
