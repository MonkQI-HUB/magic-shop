<?= view('templates/header', ['title' => 'Gestión de Catálogo - Admin']) ?>

<main class="container" style="margin-top: 40px; margin-bottom: 80px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h2 class="section-title" style="margin-bottom: 0; text-align: left;">Catálogo de Productos</h2>
        <button class="btn-primary" onclick="showAddForm()">Añadir Producto</button>
    </div>

    <!-- Product Table -->
    <div style="background-color: var(--color-surface); border: 1px solid var(--color-border); padding: 32px; margin-bottom: 48px;">
        <table class="responsive-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-border); text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: var(--color-text-secondary);">
                    <th style="padding-bottom: 16px;">Imagen</th>
                    <th style="padding-bottom: 16px;">Nombre</th>
                    <th style="padding-bottom: 16px;">Categoría</th>
                    <th style="padding-bottom: 16px;">Precio</th>
                    <th style="padding-bottom: 16px; text-align: center;">Stock</th>
                    <th style="padding-bottom: 16px; text-align: center;">Acciones</th>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                        <tr style="border-bottom: 1px solid var(--color-surface-dim);" id="product-row-<?= $p['id_producto'] ?>">
                            <td style="padding: 16px 0;" data-label="Imagen">
                                <?php
                                $imgSrc = $p['imagen_url'];
                                if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                                    $imgSrc = base_url($imgSrc);
                                }
                                ?>
                                <img src="<?= esc($imgSrc) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid var(--color-border);" onerror="this.src='https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=400';">
                            </td>
                            <td style="padding: 16px 0; font-weight: 700;" data-label="Nombre"><?= esc($p['nombre_producto']) ?></td>
                            <td style="padding: 16px 0; color: var(--color-text-secondary);" data-label="Categoría"><?= esc($p['categoria'] ?: 'General') ?></td>
                            <td style="padding: 16px 0; font-weight: 700;" data-label="Precio">$<?= number_format($p['precio'], 2) ?></td>
                            <td style="padding: 16px 0; text-align: center;" data-label="Stock">
                                <span style="padding: 4px 8px; background-color: <?= $p['stock'] > 5 ? 'var(--color-surface-dim)' : 'var(--color-error)' ?>; color: <?= $p['stock'] > 5 ? 'var(--color-text-primary)' : '#ffffff' ?>; font-weight: 700;">
                                    <?= $p['stock'] ?>
                                </span>
                            </td>
                            <td class="admin-actions-cell" data-label="Acciones">
                                <button class="btn-secondary" style="padding: 6px 12px; font-size: 11px;" onclick='showEditForm(<?= json_encode($p) ?>)'>Editar</button>
                                <button class="btn-primary" style="padding: 6px 12px; font-size: 11px; background-color: var(--color-error); border-color: var(--color-error);" onclick="deleteProduct(<?= $p['id_producto'] ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 32px; color: var(--color-text-secondary);">No hay productos registrados en el catálogo.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Modal (Embedded simple Overlay) -->
    <div id="product-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div class="form-container" style="margin: 0; position: relative;">
            <button onclick="closeModal()" style="position: absolute; top: 16px; right: 16px; font-size: 20px; font-weight: 700;">&times;</button>
            <h3 class="form-title" id="modal-title">Añadir Producto</h3>

            <form id="product-form" action="<?= base_url('admin/catalog/add') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_producto" id="modal-id_producto">

                <div class="form-group">
                    <label class="form-label" for="modal-nombre">Nombre del Producto</label>
                    <input type="text" name="nombre_producto" id="modal-nombre" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal-categoria">Categoría</label>
                    <input type="text" name="categoria" id="modal-categoria" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal-precio">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" id="modal-precio" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal-stock">Inventario (Stock)</label>
                    <input type="number" name="stock" id="modal-stock" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal-imagen" id="modal-imagen-label">Foto del Producto</label>
                    <input type="file" name="imagen" id="modal-imagen" class="form-input" accept="image/*" required>
                    <small style="display: block; margin-top: 4px; color: var(--color-text-secondary);" id="modal-imagen-help"></small>
                </div>

                <div class="form-action" style="flex-direction: row; gap: 16px;">
                    <button type="submit" class="btn-primary" style="flex: 1;">Guardar</button>
                    <button type="button" class="btn-secondary" style="flex: 1;" onclick="closeModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Load Admin JS Script -->
<script src="<?= base_url('js/admin.js') ?>"></script>
<script>
    function showAddForm() {
        document.getElementById('modal-title').innerText = 'Añadir Producto';
        document.getElementById('product-form').action = '<?= base_url('admin/catalog/add') ?>';
        document.getElementById('modal-id_producto').value = '';
        document.getElementById('modal-nombre').value = '';
        document.getElementById('modal-categoria').value = '';
        document.getElementById('modal-precio').value = '';
        document.getElementById('modal-stock').value = '';

        // Configurar input file para agregar
        var imgInput = document.getElementById('modal-imagen');
        imgInput.value = '';
        imgInput.required = true;
        document.getElementById('modal-imagen-help').innerText = 'Selecciona una imagen en formato JPG, PNG, GIF o WEBP.';

        document.getElementById('product-modal').style.display = 'flex';
    }

    function showEditForm(product) {
        document.getElementById('modal-title').innerText = 'Editar Producto';
        document.getElementById('product-form').action = '<?= base_url('admin/catalog/edit') ?>/' + product.id_producto;
        document.getElementById('modal-id_producto').value = product.id_producto;
        document.getElementById('modal-nombre').value = product.nombre_producto;
        document.getElementById('modal-categoria').value = product.categoria;
        document.getElementById('modal-precio').value = product.precio;
        document.getElementById('modal-stock').value = product.stock;

        // Configurar input file para editar (hacerlo opcional)
        var imgInput = document.getElementById('modal-imagen');
        imgInput.value = '';
        imgInput.required = false;
        document.getElementById('modal-imagen-help').innerText = 'Dejar en blanco para mantener la imagen actual.';

        document.getElementById('product-modal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('product-modal').style.display = 'none';
    }
</script>

<?= view('templates/footer') ?>