<?php
// Include config file
require_once "db/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $nome_err = $password_hashed = "";
$CURRENT_TIMESTAMP = "CURRENT_TIMESTAMP";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate username
    echo '<script>alert("chegou - validade username")</script>';
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduza um nome de utilizador.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "O nome de utilizador pode conter apenas letras, números e <i>underscrores</i>.";
    } else{
        // Prepare a select statement
        echo '<script>alert("chegou - prepare statment")</script>';
        $sql = "SELECT id FROM utilizadores WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            echo '<script>alert("chegou - bind variable 1")</script>';
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            echo '<script>alert("chegou - set parameters")</script>';
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            echo '<script>alert("chegou - execute statment")</script>';
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                echo '<script>alert("chegou - store result")</script>';
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Já existe uma conta com este nome de utilizador.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops1! Algo correu mal. Tente novamente.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    echo '<script>alert("chegou - validade password")</script>';
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduz uma password.";     
    } elseif(strlen(trim($_POST["password"])) < 4){
        $password_err = "A password necessita de pelo menos 4 carateres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    echo '<script>alert("chegou - validadete confirm password")</script>';
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirma a palavra-passe.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "As palavras-passes não coincidem.";
        }
    }
    
    if (empty(trim($_POST['nome']))){
        $login_err = "Introduza um nome";
    } else {
        $nome = trim($_POST['nome']);
    }
    
    // Check input errors before inserting in database
    echo '<script>alert("chegou - check input")</script>';
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($nome_err)){
        
        
        // Prepare an insert statement
        echo '<script>alert("chegou - prepare insert statment")</script>';
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        $sql = "INSERT INTO `utilizadores` (`id`, `username`, `password`, `nome`, `created_at`, `cargo`) VALUES (NULL, '$username', '$password_hashed', '$nome', CURRENT_TIMESTAMP, 'Aluno')";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            echo '  <script>alert("chegou - bind variables")</script>';
            mysqli_stmt_bind_param($stmt, "ssss" , $id,$username, $password_hashed, $nome, $cargo, $CURRENT_TIMESTAMP);
            
            // Set parameters
            echo '<script>alert("chegou - set parametres")</script>';
            $param_username = $username;
            $param_nome = $nome;

            
            // Attempt to execute the prepared statement
            echo '<script>alert("chegou - execute statment")</script>';
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops2! Algo correu mal. Tente novamente.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AzoresHUB - Criar conta</title>
    <link rel="stylesheet" href="/srv/style_login.css">
</head>
<body>
    <div class="div-form">
        <img src="/img/logo2.png" class="logo" alt="">
        <h3 class="titulo">Criar conta</h3>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        } elseif (empty($login_err) && !empty($password_err) && !empty($username_err)) {
            echo '<div class="alert alert-danger">Introduza um nome de utilizador e uma password</div>';
        } elseif (empty($login_err) && !empty($password_err) && empty($username_err)) {
            echo '<div class="alert alert-danger">'.$password_err.'</div>';
        } elseif (empty($login_err) && empty($password_err) && !empty($username_err)) {
            echo '<div class="alert alert-danger">'.$username_err.'</div>';
        }
        
        if (!empty($confirm_password_err)) {
            $desactivate_link = true;
            echo '<div class="alert alert-danger">'.$confirm_password_err.'</div>';
        } else {
            $desactivate_link = false;
        }

        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="group">
                <label for="username">Nome de Utilizador</label>
                <input type="text" id="username" name="username" placeholder="Nome de utilizador" class="<?php if (!empty($username_err)){ echo 'invalid'; } ?>">

                <label for="password">Palavra-passe</label>
                <input type="password" id="password" name="password" placeholder="Palavra-passe" class="<?php if (!empty($password_err)){ echo 'invalid'; } ?>">
                
                <label for="password">Confirma a Palavra-passe</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirma a Palavra-passe" class="<?php if (!empty($password_err)){ echo 'invalid'; } ?>">

                <label for="nome">Nome Completo (Sem iniciais)</label>
                <input type="text" id="nome" name="nome" placeholder="Nome completo" class="<?php if (!empty($nome_err)){ echo 'invalid'; } ?>">

                <input type="submit" id="login_btn" value="Entrar">
            </div>
        </form>
        <?php if (empty($confirm_password_err) && empty($password_err) && empty($username_err) && empty($nome_err)): ?>
            <p class="register-txt">Já tens uma conta? <br><a class="register-link" href="/srv/login">Inicia Sessão!</a></p>
        <?php endif;?>
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
</body>
</html>