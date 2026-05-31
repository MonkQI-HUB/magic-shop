// Magic Shop - Admin Interceptors

function deleteProduct(id) {
    Swal.fire({
        title: '¿Eliminar producto?',
        text: 'Esta acción no se puede deshacer y fallará si el producto ya está asociado a pedidos.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ba1a1a'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(getAbsoluteUrl('admin/catalog/delete/' + id))
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            var row = document.getElementById('product-row-' + id);
                            if (row) row.remove();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo eliminar',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(err => {
                    console.error('Error deleting product:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error de red.',
                        confirmButtonText: 'Aceptar'
                    });
                });
        }
    });
}
