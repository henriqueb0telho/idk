<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Olá, <b><?php preg_match_all('/\s\w/', $_SESSION["nome"], $matches, PREG_SET_ORDER); echo ucwords(strtok($_SESSION['nome'], " ")); echo " ";
    $i = 1;
     while (!empty($matches[$i][0])){
        $iniciais = str_replace(' ', '', htmlspecialchars(ucwords($matches[$i-1][0])));
        echo $iniciais;
        $i = $i + 1;
    }
    htmlspecialchars(ucwords($matches[0][0])); echo ". "; $split = explode(" ", $_SESSION['nome']); echo ucwords($split[count($split)-1]);
?></b> Bem-vindo ao AzoresHUB.</h1>
    <p>
        <a href="reset-password" class="btn btn-warning">Alterar Palavra-passe</a>
        <a href="logout" class="btn btn-danger ml-3">Terminar Sessão</a>
    </p>
</body>
</html>