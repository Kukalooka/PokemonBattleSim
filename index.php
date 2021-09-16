<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php
        session_start();
        
        require("menu.php");
    ?>
    <div id="cendiv">
        <img src="Sprites/Icons/pokemon.png" alt="Pokemon" class="center">
        <p>Utwórz konto / zaloguj się aby zagrać</p>
    </div>
    
</body>
</html>