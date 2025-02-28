<?php


include "../includes/config.php";



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {

    $id = intval($_POST["id"]);

    
    $sql = "SELECT * FROM viajes WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $viaje = $result->fetch_assoc();

    echo json_encode($viaje);

}