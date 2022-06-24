<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AzoresHUB - Recursos de Servidor</title>
    <link rel="stylesheet" href="/srv/style_login.css">
</head>
<body>
    <div class="div-form">
        <img src="/img/logo2.png" class="logo" alt="">
        <h3 class="titulo">Recursos de Servidor</h3>
        <div class="group" style="margin-left: 12.5%;">
            <input onclick="loginRed()" type="button" style="cursor: pointer;" value="Login">
            <input onclick="registerRed()" type="button" style="cursor: pointer;" value="Criar Conta">
            <input onclick="mainpageRed()" type="button" style="cursor: pointer;" value="Site Principal">
            <?php session_start(); if (isset($_SESSION['loggedin'])): ?>
                <input onclick="resetpswRed()" type="button" style="cursor: pointer;" value="Alterar Password">
            <?php endif;?>
            <?php if(isset($_SESSION['cargo']) && ($_SESSION['cargo'] == "Administrador" && $_SESSION['cargo'] == "Moderador")):?>
            <input onclick="adminRed()" type="button" style="cursor: pointer;" value="Zona de Administração">
            <?php endif;?>
        </div>
        <!-- <p class="register-txt">Ainda não tens uma conta? <br><a class="register-link" href="/srv/register">Cria uma aqui!</a></p> -->
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
            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(34,34,34,0.7" />
            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(34,34,34,0.5)" />
            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(34,34,34,0.3)" />
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#222222" />
            </g>
            </svg>
        </div>
        <!--Waves end-->
        
        <!--Header ends-->
    </div>
    <!--Content starts-->
    <div class="content flex">
        <p class="text">Copyright &copy; 2022 | AzoresHUB, inc.<br><small>Feito com &hearts; por <a href="mailto:henriquebotelho250604@gmail.com" style="text-decoration: underline; color: white;">Henrique B. Oliveira</a></small></p>
    </div>
    <!--Content ends-->

    <script>
        function loginRed(){
            window.location.href = "/srv/login";
        }

        function registerRed(){
            window.location.href = "/srv/register";
        }

        function mainpageRed(){
            window.location.href = "/";
        }

        function resetpswRed(){
            window.location.href = "/srv/resetpsw";
        }

        function adminRed(){
            window.location.href = "/admin";
        }
    </script>
</body>
</html>