<?php
error_reporting(0);
ini_set('display_errors', 0);

$ip = "localhost";
$user = "root";
$psw = "";
$dbname = "azoreshub";


// Create connection
$conn = new mysqli($ip, $user, $psw, $dbname);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
  die("<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados</h2><span style='font-family: Poppins, sans-serif'>Erro: " . $conn->connect_error);
}

$mysqli = new mysqli($ip, $user, $psw, $dbname);
$mysqli->set_charset("utf8mb4");

// Check connection
if ($mysqli->connect_error) {
  die("<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados</h2><span style='font-family: Poppins, sans-serif'>Erro: " . $mysqli->connect_error);
}
header('Content-Type: text/html; charset=UTF-8');
?>