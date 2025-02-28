<?php
include "../includes/config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
    } else {
        echo "Error: ID no definido";
        exit;
    }

    $fecha_viaje = $_POST["fecha_viaje"];
    $origen_direccion = $_POST["origen_direccion"];
    $origen_comuna = $_POST["origen_comuna"];
    $origen_contacto = $_POST["origen_contacto"];
    $destino_direccion = $_POST["destino_direccion"];
    $destino_comuna = $_POST["destino_comuna"];
    $destino_contacto = $_POST["destino_contacto"];
    $usuario_ejecutivo = $_POST["usuario_ejecutivo"];
    $usuario_solicitante = $_POST["usuario_solicitante"];
    $valor = intval($_POST["valor"]);

    $sql = "UPDATE viajes SET fecha_viaje = ?, origen_direccion = ?, origen_comuna = ?, origen_contacto = ?, destino_direccion = ?, destino_comuna = ?, destino_contacto = ?, usuario_ejecutivo = ?, usuario_solicitante = ?, valor = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $fecha_viaje, $origen_direccion, $origen_comuna, $origen_contacto, $destino_direccion, $destino_comuna, $destino_contacto, $usuario_ejecutivo, $usuario_solicitante, $valor, $id);

    if($stmt->execute()){
        echo "Viaje actualizado correctamente";
    }else{
        echo "Error al actualizar viaje";
    }
} else {
    echo "Error: Solicitud no válida";
}
?>