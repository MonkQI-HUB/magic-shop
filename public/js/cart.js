// Magic Shop - Cart Operations

function updateCartBadge() {
    fetch(getAbsoluteUrl('cart/get'))
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                var badge = document.getElementById('cart-badge-count');
                if (badge) {
                    badge.innerText = data.cart.total_items;
                }
            }
        })
        .catch(err => console.error('Error fetching cart:', err));
}

function addToCart(id_producto) {
    var formData = new FormData();
    formData.append('id_producto', id_producto);
    formData.append('cantidad', 1);

    fetch(getAbsoluteUrl('cart/add'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Añadido!',
                text: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
            updateCartBadge();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Inventario insuficiente',
                text: data.message,
                confirmButtonText: 'Entendido'
            });
        }
    })
    .catch(err => {
        console.error('Error adding to cart:', err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al añadir el producto.',
            confirmButtonText: 'Cerrar'
        });
    });
}

function removeFromCart(id_producto) {
    var formData = new FormData();
    formData.append('id_producto', id_producto);

    fetch(getAbsoluteUrl('cart/remove'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        }
    })
    .catch(err => console.error('Error removing product:', err));
}

function updateQuantity(id_producto, newQty) {
    if (newQty <= 0) return;
    
    var formData = new FormData();
    formData.append('id_producto', id_producto);
    formData.append('cantidad', newQty);

    fetch(getAbsoluteUrl('cart/update'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No disponible',
                text: data.message,
                confirmButtonText: 'Entendido'
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(err => console.error('Error updating quantity:', err));
}

// Initial badge check
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();

    // Check if checkout form exists and hook confirmation
    var checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirmar Compra',
                text: '¿Seguro que deseas enviar tus datos y procesar la compra?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar compra',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    checkoutForm.submit();
                }
            });
        });
    }
});
