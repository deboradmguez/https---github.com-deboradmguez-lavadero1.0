<?php
require_once "db.php";

if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE dni = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }

    $stmt->close();
}

$conn->close();
?>
