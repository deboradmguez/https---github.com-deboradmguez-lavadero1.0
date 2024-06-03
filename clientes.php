<?php
require_once "db.php";

$sql = "SELECT * FROM clientes";
$resultado = $conn->query($sql);
$clientes = [];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $clientes[] = $row;
    }
}

// Cerrar conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" />
    <title>Clientes</title>
</head>

<body>
    <!-----------------------------BARRA DE NAVEGACIÓN--------------------------------------->
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img class="logo img-fluid" style="width: 70px; height: 50px" src="logo.png" alt="">
                <a class="navbar-brand ms-2" href="#"></a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="welcome.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="clientes.php">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Estadísticas</a>
                    </li>
                </ul>
            </div>
            <a href="logout.php" class="btn btn-danger ms-2">Cerrar Sesión</a>
        </div>
    </nav>

    <!-----------------------------lista con los nombres--------------------------------------->
    <div class="container mt-2">
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarCliente">Añadir Cliente</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Lista de Clientes</h2>
                <ul class="list-group list-group-flush clientes-lista" id="listaClientes">
                    <?php foreach ($clientes as $cliente) : ?>
                        <li class="list-group-item list-group-item-action" data-dni="<?php echo $cliente['dni']; ?>">
                            <span class="cliente-nombre"><?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-6 cliente-detalle" id="detalleCliente">
                <h2>Detalles del Cliente</h2>
                <p id="detalleDNI"></p>
                <p id="detalleNombre"></p>
                <p id="detalleApellido"></p>
                <p id="detalleTelefono"></p>
                <div class="cliente-acciones">
                    <button class="btn btn-warning ms-2 btn-modificar" data-bs-toggle="modal" data-bs-target="#modalModificarCliente">Modificar</button>
                    <button class="btn btn-danger ms-2 btn-eliminar">Eliminar</button>
                </div>
            </div>
        </div>



        <!-- Modal para el registro de clientes -->
        <div class="modal fade" id="modalRegistrarCliente" tabindex="-1" aria-labelledby="modalRegistrarClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistrarClienteLabel">Registrar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="guardar_cliente.php" method="POST">
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" maxlength="8" pattern="\d{8}" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para modificar cliente -->
        <div class="modal fade" id="modalModificarCliente" tabindex="-1" aria-labelledby="modalModificarClienteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalModificarClienteLabel">Modificar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formModificarCliente" action="modificar_cliente.php" method="POST">
                            <div class="mb-3">
                                <label for="modificarDni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="modificarDni" name="dni" maxlength="8" required>
                            </div>
                            <div class="mb-3">
                                <label for="modificarNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="modificarNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="modificarApellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="modificarApellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="modificarTelefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="modificarTelefono" name="telefono" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="scrip.js"></script>
</body>

</html>