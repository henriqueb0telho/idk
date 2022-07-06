<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "azoreshub";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "<title>Por favor recarregue a página - AzoresHUB AlertSystem</title><h2 style='font-family: Poppins, sans-serif'>Não foi possível conectar à base de dados</h2><span style='font-family: Poppins, sans-serif'>Erro: ".mysqli_connect_error();
  }
?>
