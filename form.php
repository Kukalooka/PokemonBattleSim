<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>
<body>
<?php
        session_start();

        require("menu.php");

        if(isset($_SESSION['login'])){
            header('Location: secret.php');
        }
        else{
            require('connect.php');
    
            if(isset($_POST['register'])){
    
                /// Form

                if(empty($_POST['login']) || empty($_POST['pass1']) || empty($_POST['gender']) || empty($_POST['pokemon']))
                {
                    $_SESSION['message'] = 'Brakuje jakiejś informacji';
                }
                else
                {
                    $login = $_POST['login'];
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];
                    $gender = $_POST['gender'];
                    $poke = $_POST['pokemon'];

                    if($poke == 1){
                        $poke = 0;
                    }
        
                    /// Uh oh that's-a spicy meatball
                    $salt = "yes"; // Salt is set to yes because otherwise php mistakes it for an array
                    $pepper = "owo";
        
                    for($i = 2; $i >= 0; $i--){
                        $salt[$i] = $login[$i];
                    }
    
                    
    
                    $query = "SELECT `login` FROM `accounts` WHERE `login` = '$login'";
                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    $count = mysqli_num_rows($result);
        
                    if($count < 1){
                        if($pass1 == $pass2){ 
                            for($i = 6; $i > 0; $i--){
                                $pass1 = hash('sha512', $pass1 . $salt . $pepper);
                            }
                            
                            $sql = "INSERT INTO accounts (login, password, gender) VALUES ('$login', '$pass1', '$gender')";
                            $sql2 = "INSERT INTO pokemon (pokemon, trainer) VALUES ('$poke', '$login')";
                            $sql3 = "UPDATE accounts SET slot1 = (SELECT id FROM pokemon WHERE pokemon = '$poke' AND trainer = '$login') WHERE login = '$login'";
                            
                            if(mysqli_query($conn, $sql)){
                                if(mysqli_query($conn, $sql2)){
                                    if(mysqli_query($conn, $sql3)){
                                        $_SESSION['message'] = 'Gratulacje! Twoje konto zostalo utworzone!';
                                    }
                                    else {
                                        $_SESSION['message'] = 'Niestety, wystąpił błąd';
                                    }
                                }
                                else {
                                    $_SESSION['message'] = 'Niestety, wystąpił błąd';
                                }
                            }
                            else {
                                $_SESSION['message'] = 'Niestety, wystąpił błąd';
                            }
                        }
                        else{
                            $_SESSION['message'] = 'Hasla nie są takie same';
                        }
                    }
                    else{
                        $_SESSION['message'] = 'Taki nick jest juz zajety';
                    }
                    
                    mysqli_close($conn);
                }
            } 

        }
                
               
    ?>

    <div class="container">
        <h1>LOGIN</h1>
        <div class="login">
            <form action="login.php" method="post">
                <span>Podaj Login</span> <input type="text" name="login"> <br>
                <span>Podaj Haslo</span> <input type="password" name="pass"> <br>

                <input type="submit" name="loging" value="Submit"> <br>
            </form>
        </div>
        <h1>REJESTRACJA</h1>
        <div class="register">
            <form action="form.php" method="post">
                <span>Login</span> <input type="text" name="login"> <br>
                <span>Podaj Haslo</span> <input type="password" name="pass1"> <br>
                <span>Podaj Haslo ponownie</span> <input type="password" name="pass2"> <br>
                <div>
                    <span>Dziewczyna</span>  <input type="radio" id="female" name="gender" value="female">
                    <span>Chłopak</span> <input type="radio" id="female" name="gender" value="male"> <br>
                </div>
                <div>
                    <span>Chikorita</span> <img src="Sprites/PokeIcons/0.png" alt="Chikorita"> <input type="radio" id="Chikorita" name="pokemon" value="1"> <br>
                    <span>Fennekin</span> <img src="Sprites/PokeIcons/3.png" alt="Fennekin"><input type="radio" id="Fennekin" name="pokemon" value="3"> <br>
                    <span>Popplio</span> <img src="Sprites/PokeIcons/6.png" alt="Popplio"><input type="radio" id="Popplio" name="pokemon" value="6"> <br>
                </div>

                <input type="submit" name="register" value="Submit"> <br>
            </form>
        </div>
    </div>

    <?php 
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
            echo "<span class='red'>" . $message . "</span>";
            $_SESSION['message'] = "";
        }
    ?>
</body>
</html>