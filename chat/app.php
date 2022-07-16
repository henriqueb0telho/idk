<?php
session_start();

$domain = $_SERVER['HTTP_HOST'];

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: http://$domain/srv/login?url=http://$domain/chat");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AzoresHUB - Chat</title>
    <link rel="stylesheet" href="/srv/chat-assets/resources/css/main.css">
</head>
<body>
    <div class="menu">
        <div class="item first">1</div>
        <div class="item">2</div>
        <div class="item">3</div>
        <div class="item">4</div>
    </div>
    <div class="barra-lateral">
        <h2 class="titulo first">Conversas</h2>
        <hr style="height: .1px; background-color: #323232; border: 1px solid #323232; border-radius: 10px;">
        <div class="item first">1</div>
        <div class="item">2</div>
        <div class="item">3</div>
        <div class="item">4</div>
        <div class="item">5</div>
    </div>
</body>