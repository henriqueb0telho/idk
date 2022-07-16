<?php
session_start();

$domain = $_SERVER['HTTP_HOST'];?>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):?>
    <body style="font-family: 'Poppins', sans-serif;">
        <h1>Está a ser redirecionado</h1>
        <p>Caso não seja redirecionado, clique<?php header("Location: app");?> <a style="color: #000;" href="app">aqui</a></p>
        <!-- <meta http-equiv="refresh" content="0; app" /> -->
    </body>
<?php else:?>
    <?php header("Location: http://$domain/srv/login?url=http://$domain/chat");?>
<?php endif;?>