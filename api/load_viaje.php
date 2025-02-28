<?php
include "../includes/config.php";

$sql = "SELECT id,fecha_viaje, origen_direccion, origen_comuna, origen_contacto ,destino_direccion, destino_comuna , destino_contacto, usuario_ejecutivo, usuario_solicitante ,valor FROM viajes";
$result = $conn->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["data" => $data]);

$conn->close();
?>