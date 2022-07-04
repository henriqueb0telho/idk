<?php
error_reporting(0);
ini_set('display_errors', 0);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'azoreshub');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    echo "<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados</h2><span style='font-family: Poppins, sans-serif'>Erro: " . mysqli_connect_error();
    die("<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados</h2><span style='font-family: Poppins, sans-serif'>Erro: " . mysqli_connect_error());
}

?>