<?php
    $conn = mysqli_connect("localhost", "root", "", "inventio_chat");

    if(!$conn){
        echo "Erro ao completar a ligação com o servidor MySQL<br>Resposta do servidor: " . mysqli_connect_error();
    }
?>