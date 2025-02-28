<?php
include "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_viaje = $_POST["fecha_viaje"];
    $origen_direccion = $_POST["origen_direccion"];
    $origen_comuna = $_POST["origen_comuna"];
    $origen_contacto = $_POST["origen_contacto"];
    $destino_direccion = $_POST["destino_direccion"];
    $destino_comuna = $_POST["destino_comuna"];
    $destino_contacto = $_POST["destino_contacto"];
    $usuario_ejecutivo = $_POST["usuario_ejecutivo"];
    $usuario_solicitante = $_POST["usuario_solicitante"];
    $valor = intval($_POST["valor"]); // Asegurar que es un número entero

    // Validación de campos vacíos
    if (empty($fecha_viaje) || empty($origen_direccion) || empty($origen_comuna) || empty($origen_contacto) || empty($destino_direccion) || empty($destino_comuna) || empty($destino_contacto) || empty($usuario_ejecutivo) || empty($usuario_solicitante) || empty($valor)) {
        echo "Error: Campos vacíos";
        exit;
    }

    // Preparación de consulta
    $sql = "INSERT INTO viajes (fecha_viaje, origen_direccion, origen_comuna, origen_contacto, destino_direccion, destino_comuna, destino_contacto, usuario_ejecutivo, usuario_solicitante, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssssi", $fecha_viaje, $origen_direccion, $origen_comuna, $origen_contacto, $destino_direccion, $destino_comuna, $destino_contacto, $usuario_ejecutivo, $usuario_solicitante, $valor);
        
        if ($stmt->execute()) {
            echo "Viaje agregado correctamente";
        } else {
            echo "Error en la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Error: Solicitud no válida";
}
?>