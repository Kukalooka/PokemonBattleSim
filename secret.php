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

        require("menu.php");
        require('connect.php');

        if(isset($_SESSION['login'])){

            $login = $_SESSION['login'];

            if(isset($_POST['pokeswitch']))
            {
                $slot1 = $_POST['slot1'];
                $slot2 = $_POST['slot2'];
                $slot3 = $_POST['slot3'];

                $flag = false;

                if($slot1 != $slot2){
                    if(empty($slot2)){
                        $flag = true;
                    }
                    else{
                        if($slot2 != $slot3){
                            if($slot3 != $slot1){
                                $flag = true;
                            }
                        }
                    }
                }

                if($flag == true)
                {
                    if(empty($slot1))
                    {
                        echo "<p>Slot 1 nie może być pusty!</p>";
                    }
                    else
                    {
                        $sql2;
                        if(empty($slot3)){
                            if(empty($slot2)){
                                $sql2 = "UPDATE `accounts` SET `slot1` = '$slot1', `slot2` = '0', `slot3` = '0' WHERE `login` = '$login'";
                            }
                            else{
                                $sql2 = "UPDATE `accounts` SET `slot1` = '$slot1', `slot2` = '$slot2', `slot3` = '0' WHERE `login` = '$login'";
                    
                            }
                        }
                        else{
                            if(empty($slot2)){
                                header('Location: secret.php');
                            }
                            else{
                                $sql2 = "UPDATE `accounts` SET `slot1` = '$slot1', `slot2` = '$slot2', `slot3` = '$slot3' WHERE `login` = '$login'";
                            }
                        }


                        $sql3 = "SELECT * FROM `pokemon` WHERE `id` = '$slot1' AND `trainer` = '$login'";
                        $sql4 = "SELECT * FROM `pokemon` WHERE `id` = '$slot2' AND `trainer` = '$login'";
                        $sql5 = "SELECT * FROM `pokemon` WHERE `id` = '$slot3' AND `trainer` = '$login'";
        
        
                        $result3= mysqli_query($conn, $sql3);
                        $numRows3= mysqli_num_rows($result3);
        
                        if($numRows3 > 0){
                            $numRows4;
                            if(empty($slot2)){
                                $numRows4 = 1;
                            }
                            else{
                                $result4= mysqli_query($conn, $sql4);
                                $numRows4= mysqli_num_rows($result4);
                            }
        
                            if($numRows4 > 0){
                                $numRows5;
                                if(empty($slot3)){
                                    $numRows5 = 1;
                                }
                                else{
                                    $result5= mysqli_query($conn, $sql5);
                                    $numRows5= mysqli_num_rows($result5);
                                }
                                
        
                                if($numRows5 > 0){
                                    $result2= mysqli_query($conn, $sql2);
                                    echo "<p>Pokemony wymienione pomyślnie</p>";
                                }
                                else{
                                    echo "<p>Pokemon w slocie 3 nie istnieje lub nie należy do ciebie</p>";
                                }
                            }
                            else{
                                echo "<p>Pokemon w slocie 2 nie istnieje lub nie należy do ciebie</p>";
                            }
                        }
                        else{
                            echo "<p>Pokemon w slocie 1 nie istnieje lub nie należy do ciebie</p>";
                        }
                    }
                }
                else
                {
                    echo "<p> Nie można dać tego samego pokemona do dwóch slotów...</p>";
                }
                
            }
    ?>

    <div id="rest">
        <h1>Trainer Card</h1>
        <p>Wpisz # Pokemona w okienku do którego chcesz go przypisać, <br> zostaw puste pole jak chcesz żeby to pole było
            puste, <br> Nie możesz dać pokemona do slotu 3 jak slot 2 jest pusty</p>
        <p>(IMPORTANT! Pamiętaj, że pierwszy slot nie może być pusty!!!)</p><br>
        <form style="text-align: center" action="secret.php" method="post">
            <span> Slot 1 </span> <input type="number" name="slot1">
            <span> Slot 2 </span> <input type="number" name="slot2">
            <span> Slot 3 </span> <input type="number" name="slot3"><br>
            <input style="margin-top: 10px" type="submit" name="pokeswitch" value="Zmień!"><br>
        </form>

        <div class="fight"><a href="battle.php">Szukaj dzikiego Pokemona</a></div>

        <?php
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



            $gsql = "SELECT gender FROM accounts WHERE `login` = '$login'";
            $gresult= mysqli_query($conn, $gsql);
            $gnumRows= mysqli_num_rows($gresult);
            $gender;
            for($i= 1; $i < $gnumRows + 1; $i++){
                $row= mysqli_fetch_assoc($gresult);
                $gender = $row["gender"];
            }

            echo "<div id='ballin'>";
            if($gender == "female")
            {
                echo "<div id='card' style='background-color: rgba(250, 199, 224, 0.678);;'>";
            }
            else
            {
                echo "<div id='card' style='background-color: rgba(205, 235, 255, 0.678);'>";    
            }
        ?>
        <div class="trainerrest">
            <h2>Trainer Card</h1>
                <?php 
                    echo "<div class='cardtext'><div>Name: </div><div>".$login."</div></div><br>";
                    echo "<div class='cardtext'><div>Level: </div><div>"."$lvl"."</div></div><br>";
                ?>
                <h3>Team:</h3>
                <div id="pokedisplay">

                    <?php 
                        $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot1` AND `trainer` = '$login'";
                        $result= mysqli_query($conn, $sql);
                        $numRows= mysqli_num_rows($result);
                        
                        if($numRows > 0)
                        {
                            for($i= 1; $i != 2; $i++){
                                $row= mysqli_fetch_assoc($result);
                                echo "<div class='dispoke'>";
                                if($row["shiny"] == 0){
                                    echo "<img src='Sprites/PokeFront/".$row["pokemon"].".gif' alt='slot1'>";
                                }
                                else{
                                    echo "<img src='Sprites/PokeFront/".$row["pokemon"]."s".".gif' alt='slot1'>";
                                }
                                echo "</div>";
                            }
                        }
                        
                        $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot2` AND `trainer` = '$login'";
                        $result= mysqli_query($conn, $sql);
                        $numRows= mysqli_num_rows($result);
                        
                        if($numRows > 0)
                        {
                            for($i= 1; $i != 2; $i++){
                                $row= mysqli_fetch_assoc($result);
                                echo "<div class='dispoke'>";
                                if($row["shiny"] == 0){
                                    echo "<img src='Sprites/PokeFront/".$row["pokemon"].".gif' alt='slot2'>";
                                }
                                else{
                                    echo "<img src='Sprites/PokeFront/".$row["pokemon"]."s".".gif' alt='slot2'>";
                                }
                                echo "</div>";
                            }
                        }

                        $sql = "SELECT * FROM `pokemon` INNER JOIN `accounts` ON `pokemon`.`trainer` = `accounts`.`login` WHERE `pokemon`.`id` = `accounts`.`slot3` AND `trainer` = '$login'";
                        $result= mysqli_query($conn, $sql);
                        $numRows= mysqli_num_rows($result);
                        
                        if($numRows > 0)
                        {
                            for($i= 1; $i != 2; $i++){
                                $row= mysqli_fetch_assoc($result);
                                echo "<div class='dispoke'>";
                                if($row["shiny"] == 0){
                                    echo "<img src='Sprites/PokeFront/".$row["pokemon"].".gif' alt='slot3'>";
                                }
                                else{
                                    echo "<img src='Sprites/PokeFront/".$row["pokemon"]."s".".gif' alt='slot3'>";
                                }
                                echo "</div>";
                            }
                        }
                    
                    ?>
                </div>
        </div>

        <div class="trainerimg">
            <?php
                    echo"<img id='trainer' src='Sprites/Icons/".$gender.".png' alt='trainer'>";
                ?>
        </div>
    </div>
    </div>
    </div>

    <?php 
            echo '<h1>PC Box</h1>';
            echo '<p>Tu są wszystkie Pokemony które należą do ciebie</p>';
            echo "<div id='over'>";
            echo"<table class = table>";
            echo"<thead><tr><th scope=col> # </th><th> POKEMON </th></tr></thead>";
                $sql = "SELECT * FROM `pokemon` WHERE `trainer` = '$login'";
                $result= mysqli_query($conn, $sql);
                $numRows= mysqli_num_rows($result);
                for($i= 1; $i < $numRows + 1; $i++){
                    $row= mysqli_fetch_assoc($result);
                    
                    if($row["shiny"] == 0){
                        echo"<tbody><tr><th>".$row["id"] .". </th><td>"."<img class='icon' src='Sprites/PokeIcons/".$row["pokemon"].".png' alt='pokemon'>"."</td></tr></tbody>";
                    }
                    else{
                        echo"<tbody><tr><th>".$row["id"] .". </th><td>"."<img class='icon' src='Sprites/PokeIcons/".$row["pokemon"]."s".".png' alt='pokemon'>"."</td></tr></tbody>";
                    }
                }
            echo"</table>";
            echo "</div>";
            
        }
        else{
            header('Location: form.php');
        }
    ?>
</body>

</html>