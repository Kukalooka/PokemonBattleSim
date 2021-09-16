<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        if(isset($_SESSION['login'])){
            $login = $_SESSION['login'];

            echo "<div class='menubar'>";

            echo "Witaj " . $login . " ";

            echo "<div class='right'>";

            echo "<a class='top' href='index.php'>Home </a>";
            echo "<a class='top' href='secret.php'>Secret </a>";
            echo "<a class='top' href='logout.php'>Wyloguj </a>";

            echo "</div>";

            echo "</div>";
        }
        else{
            echo "<div class='menubar'>";

            echo "<span class='dif'>Niezalogowany</span>";

            echo "<div class='right'>";

            echo "<a class='top' href='index.php'>Home </a>";
            echo "<a class='top' href='form.php'>Zaloguj </a>";

            echo "</div>";

            echo "</div>";
        }
    ?>
</body>
</html>