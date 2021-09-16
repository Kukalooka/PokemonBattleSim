<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="pokemon.json"></script>
    <script src="moves.json"></script>
    <link rel="stylesheet" href="style.css">
    <title>Battle Time!</title>
</head>

<body>
    <?php
        session_start();
        require('connect.php');
        require("menu.php");
        
        if(isset($_SESSION['login']))
        {
            $login = $_SESSION['login'];

            if(isset($_SESSION['login'])){

            }
            else{
                header('Location: form.php');
            }

            $lvl = 1;
            $exp = 0;

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

            for($i = 1; $exp - (100*$i) >= 0; $i++){
                $exp -= 100 * $i;
                $lvl++;
            }

            echo "<div class='playerlv' hidden>" . $lvl . "</div>";
            

            echo "<p hidden class='slot1'>";
            
            $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot1` AND `trainer` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
            
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    echo $row["pokemon"];
                }
            }
            else
            {
                echo "-1";
            }
        
            echo "</p>";

            echo "<p hidden class='sprite1'>";
            
            $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot1` AND `trainer` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
            $shiny = 0;
            
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    $shiny = $row["shiny"];
                }
            }

            if($shiny == 0){
                echo $row["pokemon"];
            }
            else{
                echo $row["pokemon"] . "s";
            }
        
            echo "</p>";

            echo "<p hidden class='slot2'>";
            
            $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot2` AND `trainer` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
            
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    echo $row["pokemon"];
                }
            }
            else
            {
                echo "-1";
            }
        
            echo "</p>";

            echo "<p hidden class='sprite2'>";
            
            $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot2` AND `trainer` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
            $shiny = 0;
            
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    $shiny = $row["shiny"];
                }
            }

            if($shiny == 0){
                echo $row["pokemon"];
            }
            else{
                echo $row["pokemon"] . "s";
            }
        
            echo "</p>";

            echo "<p hidden class='slot3'>";

            $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot3` AND `trainer` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
            
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    echo $row["pokemon"];
                }
            }
            else
            {
                echo "-1";
            }
        
            echo "</p>";

            echo "<p hidden class='sprite3'>";
            
            $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot3` AND `trainer` = '$login'";
            $result= mysqli_query($conn, $sql);
            $numRows= mysqli_num_rows($result);
            $shiny = 0;
            
            if($numRows > 0)
            {
                for($i= 1; $i != 2; $i++){
                    $row= mysqli_fetch_assoc($result);
                    $shiny = $row["shiny"];
                }
            }

            if($shiny == 0){
                echo $row["pokemon"];
            }
            else{
                echo $row["pokemon"] . "s";
            }
        
            echo "</p>";

            echo "<p hidden class='enemy'>";

            $wild = rand(0, 16);

            $enemyshine = rand(1, 5);

            echo $wild;

            if($enemyshine == 1){
                $_SESSION['shiny'] = 1;
            }
            else{
                $_SESSION['shiny'] = 0;
            }

            echo "</p>";

            echo "<p hidden class='enemysprite'>";

            if($enemyshine == 1){
                echo $wild . "s";
            }
            else{
                echo $wild;
            }

            echo "</p>";

            $_SESSION['wild'] = $wild;

            echo "</p>";

            $wildlvl = rand($lvl - 5, $lvl + 5);

            if($wildlvl < 1)
                $wildlvl = 1;

            echo "<p hidden class='lvl'>";

            echo $wildlvl;

            echo "</p>";

            $_SESSION['wildlvl'] = $wildlvl;
        }
        else
        {
            header('Location: form.php');
        }
    
    ?>
    <div id="arena">
        <div class="playcont">
            <img id="player" src="" alt="Your pokemon">
        </div>
        <div class="enemcont">
            <img id="enemy" src="" alt="Enemy Pokemon">
        </div>
        <div id="staPlayer">
            <span>Name</span>
            <div id="hpbar">
                <div id="hpgreen"></div>
            </div>
        </div>
        <div id="staEnemy">
            <span>Name</span>
            <div id="hpbar">
                <div id="hpgreen"></div>
            </div>
        </div>
    </div>
    <div id="textbox">
        <p id="battltext"></p>
    </div>
    <div id="selection">
        <div id="moves">
            <div id="button1">
            </div>
            <div id="button2">
            </div>
            <div id="button3">
            </div>
            <div id="button4">
            </div>
        </div>
        <div id="catch">
            <div id="yes">Yes</div>
            <div id="no">No</div>
        </div>
    </div>
    <div id="switch">
        <img id="pokeslot1" src="" alt="pokemon1">
        <img id="pokeslot2" src="" alt="pokemon2">
        <img id="pokeslot3" src="" alt="pokemon3">
    </div>
    <script src="battle.js"></script>
</body>

</html>