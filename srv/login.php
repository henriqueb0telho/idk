<?php
// Initialize the session
session_start();
if (isset($_GET['url'])){
    $url = $_GET['url'];
} else {
    $url = "";
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /");
    exit;
}
 
// Include config file
require_once "db/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduza um nome de utilizador.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduza uma password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, nome, created_at, cargo, id_unico FROM utilizadores WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $nome, $data, $cargo, $id_unico);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["nome"] = $nome;                            
                            $_SESSION["created_at"] = $data;    
                            $_SESSION['id_unico'] = $id_unico;                        
                            $_SESSION["cargo"] = $cargo;      
                            preg_match_all('/\s\w/', $nome, $matches, PREG_SET_ORDER);
                            $mdl = "";
                            $i = 1;
                            while (!empty($matches[$i][0])){
                                $iniciais = str_replace(' ', '', htmlspecialchars(ucwords($matches[$i-1][0])));
                                $mdl = $mdl . $iniciais;
                                $i = $i + 1;
                            }
                            $split = explode(" ", $nome); 
                            $_SESSION["nome_abreviado"] = ucwords(strtok($nome, " ")) . " " . $iniciais . ". " . ucwords($split[count($split)-1]) ;
                            

                            // Redirect user to welcome page
                            if ($url !== "") {
                                header("Location: ".$url);
                            } else { 
                                header("location: /admin");
                            }

                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Esta password é incorreta. Tente novamente.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Esta conta não existe ou está bloqueada.";
                }
            } else{
                echo "Oops! Algo correu mal. Tente novamente.";
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
    <title>AzoresHUB - Login</title>
    <link rel="stylesheet" href="/srv/style_login.css">
</head>
<body>
    <div class="div-form">
        <img src="/img/logo2.png" class="logo" alt="">
        <h3 class="titulo">Login</h3>
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

         

        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="group">
                <label for="username">Nome de Utilizador</label>
                <input style="width: 95%;" type="text" id="username" name="username" placeholder="Nome de utilizador" value="<?php echo $username; ?>" class="<?php if (!empty($username_err)){ echo 'invalid'; } ?>">

                <label for="password">Palavra-passe</label>
                <input type="password" style="width: 95%;" id="password" name="password" placeholder="Palavra-passe" class="<?php if (!empty($password_err)){ echo 'invalid'; } ?>">

                <input type="submit" id="login_btn" value="Entrar">
            </div>
        </form>
        <p class="register-txt">Ainda não tens uma conta? <br><a class="register-link" href="/srv/register">Cria uma aqui!</a></p>
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