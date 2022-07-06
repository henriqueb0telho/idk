<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['id_unico'];
    $sql = "SELECT * FROM utilizadores WHERE NOT id_unico = {$outgoing_id} ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No utilizadores are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>