<?php
session_start();

echo "Nome: " . $_SESSION['nome'] . "<br>Logado: ";
echo $_SESSION['loggedin'] . "<br>ID: ";
echo $_SESSION['id'] . "<br> Username: ";
echo $_SESSION['username'] . "<br>Data de criação: ";
echo $_SESSION['created_at'] . "<br>Cargo: ";
echo $_SESSION['cargo'] . "<br>Id unico:";
echo $_SESSION['id_unico'] . "<br>";
    

?>