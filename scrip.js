document.addEventListener('DOMContentLoaded', function () {
    const listaClientes = document.getElementById('listaClientes');
    const detalleCliente = document.getElementById('detalleCliente');

    listaClientes.addEventListener('click', function (event) {
        // Verifica si se hizo clic en un cliente
        if (event.target.classList.contains('cliente-nombre')) {
            const clienteSeleccionado = event.target.closest('li');

            // Oculta los detalles y botones de otros clientes
            document.querySelectorAll('.cliente-detalle').forEach(function (detalle) {
                detalle.style.display = 'none';
            });

            // Muestra los detalles y botones del cliente seleccionado
            detalleCliente.style.display = 'block';
        } else {
            // Si se hace clic fuera de un cliente, oculta los detalles y botones
            detalleCliente.style.display = 'none';
        }
    });
});

//detalles del cliente
document.addEventListener('DOMContentLoaded', function () {
    // Ver detalle del cliente
    document.querySelectorAll('.cliente-nombre').forEach(function (nombre) {
        nombre.addEventListener('click', function () {
            const dni = this.closest('li').dataset.dni;
            fetch('obtener_cliente.php?dni=' + dni)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detalleDNI').textContent = 'DNI: ' + data.dni;
                    document.getElementById('detalleNombre').textContent = 'Nombre: ' + data.nombre;
                    document.getElementById('detalleApellido').textContent = 'Apellido: ' + data.apellido;
                    document.getElementById('detalleTelefono').textContent = 'Teléfono: ' + data.telefono;

                    this.nextElementSibling.classList.toggle('d-none');
                });
        });
    });
});
// Modificar cliente
document.addEventListener('DOMContentLoaded', function() {
    // Modificar cliente
    document.querySelectorAll('.list-group-item-action').forEach(function(item) {
        item.addEventListener('click', function() {
            const dni = this.dataset.dni; // Obtener el DNI del cliente seleccionado
            fetch('obtener_cliente.php?dni=' + dni)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detalleDNI').textContent = 'DNI: ' + data.dni;
                    document.getElementById('detalleNombre').textContent = 'Nombre: ' + data.nombre;
                    document.getElementById('detalleApellido').textContent = 'Apellido: ' + data.apellido;
                    document.getElementById('detalleTelefono').textContent = 'Teléfono: ' + data.telefono;
                    document.getElementById('detalleCliente').classList.remove('d-none');
                })
                .catch(error => console.error('Error al obtener los datos del cliente:', error));
        });
    });
});



// Eliminar cliente
document.querySelectorAll('.btn-eliminar').forEach(function (button) {
    button.addEventListener('click', function () {
        const dni = this.dataset.dni;
        if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
            fetch('eliminar_cliente.php?dni=' + dni)
                .then(() => {
                    window.location.reload();
                });
        }
    });
});