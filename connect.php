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
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "pokemon";
         
         $conn = mysqli_connect($servername, $username, $password, $dbname);

         if(!$conn){
             die("Uh oh!: " . mysqli_connect_error());
         }
    ?>
</body>
</html>