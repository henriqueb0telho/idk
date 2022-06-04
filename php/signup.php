<?php
    include_once "config.php";

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($username) && !empty($password)){
        if(preg_match('/^[a-zA-Z0-9]$/', $username)){
            $sql = mysqli_query($conn, "SELECT username FROM users WHERE username = '{$username}'");
            if (mysqli_num_rows($sql) > 0){
                echo 'O username "<i>'.$username.'</i>" já existe.';
            } else {
                if(isset($_FILES['image'])){
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);

                    $extentions = ['png', 'jpg', 'jpeg', 'gif'];
                    if(in_array($img_ext, $extentions) === true){
                        
                    } else {
                        echo "O formato da imagem não é compatível. As imagens têm de ser <i>.png</i>, <i>.jpg</i>, <i>.jpeg</i> ou <i>.gif</i>!";
                    }
                } else {

                }
            }
        } else {
            echo "$username - Este username não é válido!";
        }
    } else {
        echo "Os campos assinalados são campos de preenchimento obrigatório!";
    }
?>