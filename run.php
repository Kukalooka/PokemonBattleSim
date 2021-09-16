<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Run</title>
</head>
<body>
    <?php 
        session_start();

        require("menu.php");
        require('connect.php');

        if(isset($_SESSION['wild']))
        {   
            echo "<h1>Postanowiłeś nie łapać Pokemona...</h1>";

            $login = $_SESSION['login'];

            $sql = "SELECT * FROM `accounts` WHERE `login` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
                
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    $exp = $row["exp"];
                }
            }

            $lvl = $_SESSION['wildlvl'];

            $exp += 50 * $lvl;

            $sql = "UPDATE `accounts` SET `exp` = '$exp' WHERE `login` = '$login'";
            mysqli_query($conn, $sql);
            
            unset($_SESSION['wild']);
        }
        else
        {
            header('Location: battle.php');
        }

        

       
    
    ?>
</body>
</html>