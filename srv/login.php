<?php
require "db/config.php";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AzoresHUB - Login</title>
    <link rel="stylesheet" href="/srv/style_login.css">
</head>
<body>
    <div class="div-form">
        <img src="/img/logo2.png" class="logo" alt="">
        <h3 class="titulo">Login</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="group">
                <label for="username">Nome de Utilizador</label>
                <input type="text" id="username" name="username" placeholder="Nome de utilizador">

                <label for="password">Palavra-passe</label>
                <input type="pass" id="password" name="password" placeholder="Palavra-passe">

                <input type="submit" name="login_btn" id="login_btn" value="Entrar">
            </div>
        </form>
    </div>
    <div class="header">
        <!--Content before waves-->
        <div class="inner-header flex">
        <!-- <h1>Simple CSS Waves</h1> -->
    </div>
        
        <!--Waves Container-->
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(0,0,0,0.7" />
            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(0,0,0,0.5)" />
            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(0,0,0,0.3)" />
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#000" />
            </g>
            </svg>
        </div>
        <!--Waves end-->
        
        <!--Header ends-->
    </div>
    <!--Content starts-->
    <div class="content flex">
        <p class="text">Copyright &copy; 2022 | AzoresHUB, inc.</p>
    </div>
    <!--Content ends-->
</body>
</html>