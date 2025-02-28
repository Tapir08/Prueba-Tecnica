<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    
    $sql = "DELETE FROM viajes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Viaje eliminado correctamente";
    } else {
        echo "Error al eliminar el viaje";
    }

    $stmt->close();
    $conn->close();
}
?>

