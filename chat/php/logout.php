<?php
    session_start();
    if(isset($_SESSION['id_unico'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Offline";
            $sql = mysqli_query($conn, "UPDATE utilizadores SET status = '{$status}' WHERE id_unico={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login");
            }
        }else{
            header("location: ../users");
        }
    }else{  
        header("location: ../login");
    }
?>