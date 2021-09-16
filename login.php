<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>
<body>
    <?php 
        session_start();

        require('connect.php');

        if(isset($_POST['login']) and isset($_POST['pass'])){

            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $pepper = "owo";
            $salt = "";

            for($i = 2; $i >= 0; $i--){
                $salt[$i] = $login[$i];
            }

            for($i = 6; $i > 0; $i--){
                $pass = hash('sha512', $pass . $salt . $pepper);
            }

            $query = "SELECT * FROM `accounts` WHERE `login` = '$login' AND `password` = '$pass'";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $count = mysqli_num_rows($result);
            
            if($count == 1){
                $_SESSION['login'] = $login;
                header('Location: index.php');
            }
            else{
                $_SESSION['message'] = "Zły login lub hasło";
                header('Location: form.php');
            }
        } 
    ?>
</body>
</html>