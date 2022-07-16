<?php
error_reporting(0);
ini_set('display_errors', 0);

define('DB_SERVER', '_back-end.secure.azoreshub.ga');
define('DB_USERNAME', 'azrhub_web');
define('DB_PASSWORD', 'web');
define('DB_NAME', 'azrhub_azoreshub');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados</h2><span style='font-family: Poppins, sans-serif'>Erro: " . mysqli_connect_error());
}

?>
