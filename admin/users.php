<?php 
    require_once "config.php";
    session_start();
    header('Content-Type: text/html; charset=utf-8');
    
    $domain = $_SERVER['HTTP_HOST'];
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){    
        header("location: /srv/login?url=http://$domain/admin/users");
        exit;
    }

    if (isset($_SESSION['cargo'])) {
        if ($_SESSION['cargo'] == "Administrador") {
            
        } elseif ($_SESSION['cargo'] == "Professor") {
            
        } else {
            header("location: /erros/no_auth");
            exit;
        }
        
    } else {
        header("location: /srv/login?url=http://$domain/admin/users");
        exit;
    }

    $password_err = "";

    $carateres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; $codigo_confirm = array(); $carateresLen = strlen($carateres) - 1; for ($i = 0; $i < 8; $i++) { $n = rand(0, $carateresLen); $codigo_confirm[] = $carateres[$n];};

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['del_user'])){
        $id = $_POST['modaldel_id'];
        $user_cod = $_POST['cod_confirm'];
        $cod = $_POST['cod'];

        if ($_POST['cod_confirm'] === $cod) {
            $mysqli->query("DELETE FROM utilizadores WHERE id=$id") or die($mysqli->error);

            $_SESSION['mensagem'] = "Utilizador apagado com sucesso.";
            $_SESSION['tipomsg'] = "danger";
            header("Location: users");
            exit;
        } else {
            $_SESSION['mensagem'] = "Confirmação falhada, tente novamente.";
            $_SESSION['tipomsg'] = "danger";
            header("Location: users");
            exit;
        }

    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])){
        $password = $_POST['modaledit_password'];
        $confirm_password = $_POST['modaledit_confirmpassword'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $nome = $_POST['modaledit_nome'];
        $alcunha = $_POST['modaledit_alcunha'];
        $id = $_POST['modaledit_id'];
        $email = $_POST['modaledit_email'];
        $result = $mysqli->query("SELECT * FROM utilizadores") or die($mysqli->error);
        $row = $result->fetch_assoc();
        
            if ($nome !== $row['nome']) {
                $mysqli->query("UPDATE `utilizadores` SET `nome` = '$nome' WHERE `utilizadores`.`id` = $id");
            } 

            if ($email !== $row['email']) {
                $mysqli->query("UPDATE `utilizadores` SET `email` = '$email' WHERE `utilizadores`.`id` = $id");
            } 

            if ($nome !== $row['alcunha']) {
                $mysqli->query("UPDATE `utilizadores` SET `alcunha` = '$alcunha' WHERE `utilizadores`.`id` = $id");
            } 
    
            if ($hashed_password !== $row['password'] && $confirm_password === $password) {
                $mysqli->query("UPDATE `utilizadores` SET `password` = '$hashed_password' WHERE `utilizadores`.`id` = $id");
            } else {
                header("Location: users");
                $password_err = "is-invalid";
                echo "<script>$(document).ready(function () {
                    $('#modaledit').modal('show');
                });</script>";
            }
            $_SESSION['mensagem'] = "Utilizador editado com sucesso!";
            $_SESSION['tipomsg'] = "warning";
            header("Location: users");
            exit;

    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['novo_user'])){
        $password = $_POST['modalnovo_password'];
        $confirm_password = $_POST['modalnovo_confirmpassword'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $nome = $_POST['modalnovo_nome'];
        $username = $_POST['modalnovo_username'];

        if ($password == $confirm_password) {
            $mysqli->query("INSERT INTO `utilizadores` (`id`, `username`, `password`, `nome`, `cargo`, `created_at`) VALUES (NULL, '$username', '$hashed_password', '$nome', 'Sem Cargo que pobre', CURRENT_TIMESTAMP)");
            
            $_SESSION['mensagem'] = "Utilizador criado com sucesso!";
            $_SESSION['tipomsg'] = "success";
            header("Location: users");
            exit;
        } else {
            $_SESSION['mensagem'] = "As passwords não coincidem!";
            $_SESSION['tipomsg'] = "danger";
            header("Location: users");
            exit;
        }

    }

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilizadores - Administração</title>
    <link rel="stylesheet" href="css/users.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>

    <?php 
        require "config.php";
    ?>
    <?php
        if (isset($_SESSION['mensagem'])):
    ?>

    <div class="alert alert-<?=$_SESSION['tipomsg']?>">

    <?php 
        echo $_SESSION['mensagem'];
        unset($_SESSION['mensagem']);
    ?>
    </div>
    
    <?php endif?>
    <div class="d-flex justify-content-end text-end"  style="padding-right: 10px; padding-top:10px;">
        <p>Administrador: <span class="text-muted"  style="padding-right: 10px;"><?php echo $_SESSION['nome_abreviado'];?></span>|<button class="novobtn btn btn-link text-decoration-none">Novo Utilizador</button>|<a style="padding-left: 10px;" class=" text-decoration-none btn btn-link" href="/srv/logout">Terminar Sessão</a></p>
    </div>

    <div style="padding-left: 10%; padding-right: 10%;">
        <?php
            $result = $mysqli->query("SELECT * FROM utilizadores") or die($mysqli->error);
        ?>

        <div class="row justify-content-center align-middle" style="width: 100%;">

            <div class="input-group w-50">
                <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path></svg>
                </span>
                <input type="text" class="form-control" placeholder="Pesquisar nome..." id="inputPesquisa" name="inputPesquisa" onkeyup='pesquisaTabela()' aria-label="Pesquisar" aria-describedby="basic-addon1">
            </div>

            <table class="table table-bordered table-hover mt-4 mx-auto" id="tabela-users" data-filter-control="true" data-search-clear-button="true">
            <thead class="table-dark">    
                    <tr>
                        <th scope="col" width="5%" style="text-align: center; vertical-align: middle;">ID</th>
                        <th scope="col" width="30%" style="text-align: center; vertical-align: middle;">Nome</th>
                        <th scope="col" width="10%" style="text-align: center; vertical-align: middle;">Alcunha</th>
                        <th scope="col" width="15%" style="text-align: center; vertical-align: middle;">Username</th>
                        <th scope="col" width="15%" style="text-align: center; vertical-align: middle; display:none;">Email</th>
                        <th scope="col" width="15%" style="text-align: center; vertical-align: middle; display:none;">Data de Nascimento</th>
                        <th scope="col" width="15%" style="text-align: center; vertical-align: middle; display:none;">Cargo</th>
                        <th scope="col" width="20%" style="text-align: center; vertical-align: middle;">Data de Criação</th>
                        <th scope="col" colspan="3" style="text-align: center; vertical-align: middle;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td style="vertical-align: middle;"><?php echo $row['id'] ?></td>
                    <td style="vertical-align: middle;"><?php echo $row['nome'] ?></td>
                    <td style="vertical-align: middle;"><?php echo $row['alcunha'] ?></td>
                    <td style="vertical-align: middle;"><?php echo $row['username'] ?></td>
                    <td style="vertical-align: middle; display:none;"><?php echo $row['email'] ?></td>
                    <td style="vertical-align: middle; display:none;"><?php echo $row['datanascimento'] ?></td>
                    <td style="vertical-align: middle; display:none;"><?php echo $row['cargo'] ?></td>
                    <td style="vertical-align: middle;"><?php echo $row['created_at'] ?></td>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="infobtn btn btn-outline-dark"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-lg" viewBox="0 0 16 16"><path d="m9.708 6.075-3.024.379-.108.502.595.108c.387.093.464.232.38.619l-.975 4.577c-.255 1.183.14 1.74 1.067 1.74.72 0 1.554-.332 1.933-.789l.116-.549c-.263.232-.65.325-.905.325-.363 0-.494-.255-.402-.704l1.323-6.208Zm.091-2.755a1.32 1.32 0 1 1-2.64 0 1.32 1.32 0 0 1 2.64 0Z"/>Info</svg></button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="editbtn btn btn-outline-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>Editar</svg>Editar</button>
                    </td>
                    <td style="vertical-align: middle;" class="text-center">
                        <button class="delbtn btn btn-outline-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>Apagar</svg></button>
                    </td>
                    <?php endwhile;?>
                </tr>
                </tbody>
            </table>       
        </div>
    </div>
        

    <?php
        function pre_r( $array ) {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
        }
    ?>


     <!-- Modal Novo Utilizador -->

    <div class="modal fade" id="modalnovo" data-bs-toogle="modal" tabindex="-1" aria-labelledby="modalnovoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="users" method="POST">
                <input type="hidden" name="modalnovo_id" id="modalnovo_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalnovoLabel">Novo Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Para criar um novo utilizador preenche o formulário</p>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="modalnovo_nome" name="modalnovo_nome" placeholder="Nome">
                    <span class="invalid-feedback"></span>
                    <label for="modalnovo_nome">Nome</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="modalnovo_username" name="modalnovo_username" placeholder="Nome de Utilizador">
                    <span class="invalid-feedback"></span>
                    <label for="modalnovo_username">Nome de Utilizador</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="modalnovo_password" name="modalnovo_password" placeholder="Palavra-Passe">
                    <span class="invalid-feedback"></span>
                    <label for="modalnovo_password">Palavra-Passe</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="modalnovo_confirmpassword" name="modalnovo_confirmpassword" placeholder="Palavra-Passe">
                    <span class="invalid-feedback"></span>
                    <label for="modalnovo_password">Confirma a Palavra-Passe</label>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="novo_user" class="btn btn-dark">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Modal Eliminar Utilizador -->
    <div class="modal fade" id="modaldel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modaldeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="users" method="POST">
                <input type="hidden" name="modaldel_id" id="modaldel_id">
                <input type="hidden" name="cod" id="cod" value="<?php print(implode($codigo_confirm)); ?>">

                <div class="modal-header">
                    <h5 class="modal-title" id="modaldelLabel">Eliminar Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        Para eliminar o utilizador introduza o seguinte código na caixa de texto: <i>"<?php print(implode($codigo_confirm));?>"</i>.
                        <input type="text" class="form-control" style="margin-top: 10px;" name="cod_confirm" id="cod_confirm" placeholder="Aqui">
                    </div>
                    <i class="text-muted text-decration-none text-end" style="font-size: 14px; margin-left: 5px; margin-top: 10px;">Este processo é irreversível</i>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="del_user" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Modal Editar Utilizador -->
    <div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modaleditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="modaledit_id" id="modaledit_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaleditLabel">Editar Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="modaledit_nome" name="modaledit_nome" placeholder="Nome">
                    <span class="invalid-feedback"></span>
                    <label for="modaledit_nome">Nome</label>
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        Escolha um nome.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="modaledit_alcunha" name="modaledit_alcunha" placeholder="Alcunha">
                    <span class="invalid-feedback"></span>
                    <label for="modaledit_nome">Alcunha</label>
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        Escolha uma alcunha.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="modaledit_username" name="modaledit_username" placeholder="Nome de Utilizador" disabled>
                    <span class="invalid-feedback"></span>
                    <label for="modaledit_username">Nome de Utilizador</label>
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        Escolha um username.
                    </div>
                </div>
                <p class="mb-3 text-muted">Para editar a palavra passe simplesmente escreva algo, para não alterar não digite nada</p>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="modaledit_password" name="modaledit_password" placeholder="Palavra-Passe">
                    <span class="invalid-feedback"></span>
                    <label for="modaledit_password">Palavra-Passe</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control <?php echo $password_err;?>" id="modaledit_confirmpassword" name="modaledit_confirmpassword" placeholder="Palavra-Passe">
                    <span class="invalid-feedback"></span>
                    <label for="modaledit_confirmpassword">Confirma a Palavra-Passe</label>
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        As passwords não coincidem.
                    </div>
                </div>
                <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="modaledit_email" name="modaledit_email" placeholder="Alcunha">
                        <span class="invalid-feedback"></span>
                        <label for="modaledit_email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="modaledit_datanascimento" name="modaledit_datanascimento">
                        <span class="invalid-feedback"></span>
                        <label for="modaledit_datanascimento">Data de Nascimento</label>
                    </div>
                    <select class="form-select" name="modaledit_cargo" id="modaledit_cargo">
                    <?php 
                        $cargos = $mysqli->query("SELECT * FROM cargos");
                        while($row_cargos = $cargos->fetch_assoc()): 
                    ?>
                        <option value="<?php echo $row_cargos['nome']; ?>" <?php 
                        if ($_SESSION['cargo'] == $row_cargos['nome']) {
                            echo "selected";
                        }
                        
                        ?>><?php echo $row_cargos['nome']; ?></option>
                    <?php endwhile;?>
                </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit_user" id="edit_user" class="btn btn-outline-dark">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Modal Info -->
    <div class="modal fade" id="modalinfo" data-bs-toogle="modal" tabindex="-1" aria-labelledby="modaleditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <input type="hidden" name="modalinfo_id" id="modalinfo_id">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="modaleditLabel">Editar Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="modalinfo_nome" name="modalinfo_nome" placeholder="Nome" readonly>
                        <span class="invalid-feedback"></span>
                        <label for="modalinfo_nome">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="modalinfo_username" name="modalinfo_username" placeholder="Nome de Utilizador" readonly>
                        <span class="invalid-feedback"></span>
                        <label for="modalinfo_username">Nome de Utilizador</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="modalinfo_alcunha" name="modalinfo_alcunha" placeholder="Alcunha" value="" readonly>
                        <span class="invalid-feedback"></span>
                        <label for="modalinfo_alcunha">Alcunha</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="modalinfo_email" name="modalinfo_email" placeholder="Email" readonly>
                        <span class="invalid-feedback"></span>
                        <label for="modalinfo_email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="modalinfo_datanascimento" name="modalinfo_datanascimento" readonly>
                        <span class="invalid-feedback"></span>
                        <label for="modalinfo_datanascimento">Data de Nascimento</label>
                    </div>
                    <select class="form-select" name="modalinfo_cargo" id="modalinfo_cargo" disabled>
                    <?php 
                        $cargos = $mysqli->query("SELECT * FROM cargos");
                        while($row_cargos = $cargos->fetch_assoc()): 
                    ?>
                        <option value="<?php echo $row_cargos['nome']; ?>" <?php 
                        if ($_SESSION['cargo'] == $row_cargos['nome']) {
                            echo "selected";
                        }
                        
                        ?>><?php echo $row_cargos['nome']; ?></option>
                    <?php endwhile;?>
                </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
        </div>
    </div>
    </div>
    <!-- Fim modal's -->
    <script>
        $(document).ready(function () {
            $('.editbtn').on('click', function() {
                $('#modaledit').modal('show');
                    $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function() {
                    return $(this).text();
                }). get();
                console.log(data);
            
                $('#modaledit_id'). val(data[0]);
                $('#modaledit_nome').val(data[1]);
                $('#modaledit_alcunha').val(data[2]);
                $('#modaledit_username').val(data[3]);
                $('#modaledit_email').val(data[4]);
                $('#modaledit_datanascimento').val(data[5]);
                $('#modaledit_cargo').val(data[6]);
            
            });

            $('.delbtn').on('click', function() {
                $('#modaldel').modal('show');
                    $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function() {
                    return $(this).text();
                }). get();
                console.log(data);
            
                $('#modaldel_id'). val(data[0]);
            
            });

            $('.novobtn').on('click', function() {
                $('#modalnovo').modal('show');
            
            });

            $('.infobtn').on('click', function() {
                $('#modalinfo').modal('show');
                    $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function() {
                    return $(this).text();
                }). get();
                console.log(data);
            
                $('#modalinfo_id'). val(data[0]);
                $('#modalinfo_nome').val(data[1]);
                $('#modalinfo_alcunha').val(data[2]);
                $('#modalinfo_username').val(data[3]);
                $('#modalinfo_email').val(data[4]);
                $('#modalinfo_datanascimento').val(data[5]);
                $('#modalinfo_cargo').val(data[6]);
            
            });
        });
    </script>

    <script type="application/javascript">
        function pesquisaTabela() {
                let input, filter, table, tr, td, i, txtValue;

                input = document.getElementById("inputPesquisa");
                filter = input.value.toLowerCase();
                table = document.getElementById("tabela-users");
                tr = table.getElementsByTagName("tr");
                for(let i = 0; i < tr.length; i++){
                    td = tr[i].getElementsByTagName("td")[1];
                    if(td) {
                        txtValue = td.textContent || td.innerText;
                        if(txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        }
                        else {
                            tr[i].style.display = "none";
                        }
                    }
                }
        }
    </script>
</body>
</html>