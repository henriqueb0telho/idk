<?php
$host = 'azoreshub.ga';
$user = 'azrhub_web';
$password = 'web';
$database = 'azrhub_azoreshub';
$mysqli = new mysqli();
$mysqli->connect($host, $user, $password, $database);
if (mysqli_connect_errno()) {
    exit("<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados <i>AZRHUB_AZORESHUB</i></h2><span style='font-family: Poppins, sans-serif'>Erro: " . mysqli_connect_error());
}

?>