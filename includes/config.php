<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica si el archivo .env existe
if (!file_exists(__DIR__ . '/../.env')) {
    die('.env file not found');
}

function loadEnv($path) {
    if (file_exists($path)) {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}

// Carga de variables de entorno
loadEnv(__DIR__ . '/../.env');

// Usar variables de entorno
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

//Creacion de la conexion
$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("error de conexion: " . $conn->connect_error);
}

$conn->set_charset("utf8");

