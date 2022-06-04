<?php

// if (!isset($_GET['aristf']) && $_GET['aristf'] !== "true") {
//     header("Location: login");
// }

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Chat | Inventio - A Descoberta e Povoamento dos Açores</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="wrapper">
        <section class="form signup">
            <header>inventio - Criar conta<p class="txt-pag">A Descoberta e Povoamento dos Açores</p></header><span class="txt-pag"></span>
            
            <form action="#" enctype="multipart/form-data">
                <div class="error-txt">Isto é uma mensagem de erro</div>
                <div class="name-details">
                    <div class="field input">
                        <label>Primeiro Nome</label>
                        <input type="text" name="fname" placeholder="Primeiro Nome" required>
                    </div>
                    <div class="field input">
                        <label>Último Nome</label>
                        <input type="text" name="lname" placeholder="Último Nome" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Nome de Utilizador</label>
                    <input type="text" name="username" placeholder="Introduza o seu username" required>
                </div>
                <div class="field input">
                    <label>Palavra-Passe</label>
                    <input type="password" name="password" placeholder="Introduza a sua password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field image">
                    <label>Imagem de Perfil</label>
                    <input type="file" name="image">
                </div>
                <div class="field button">
                    <input type="submit" placeholder="Criar Conta">
                </div>
            </form>
            <div class="link">Já tens uma conta? <a href="/login">Iniciar Sessão.</a></div>
        </section>
    </div>
    <script src="js/pass-show-hide.js"></script>
    <script src="js/signup.js"></script>
</body>
</html>