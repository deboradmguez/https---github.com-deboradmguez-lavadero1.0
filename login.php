<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        $contraseña_hasheada_md5 = $user['contrasena']; // Obtener la contraseña hasheada de la base de datos
        echo "Contraseña hasheada en la base de datos: " . $contraseña_hasheada_md5 . "<br>"; // Depuración

        // Hashear la contraseña ingresada con MD5 para compararla con la contraseña hasheada en la base de datos
        $contraseña_ingresada_md5 = md5($contraseña);

        if ($contraseña_ingresada_md5 === $contraseña_hasheada_md5) {
            // Iniciar sesión
            $_SESSION['idusuario'] = $user['idusuario'];
            $_SESSION['usuario'] = $user['usuario'];
            header("Location: welcome.php"); // Redirigir a la página de bienvenida
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "No se encontró un usuario con ese nombre";
    }

    $stmt->close();
}

$conn->close();