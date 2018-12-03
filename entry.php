<?php
//entry.php
session_start();
if(!isset($_SESSION["username"]))
{
    header("location:index.php?action=login");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.bootstrap.css">
    <script src="js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/angular.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-datatables.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.css"></script>
</head>
<body>
<br/><br/>
<div class="container" style="width:500px;">
    <h3 align="center">Отлично! Зарегистрировали!</h3>
    <br />
    <?php
    echo '<h1>Привет - '.$_SESSION["username"].'</h1>';
    echo '<label><a href="logout.php">Выйти</a></label>';
    ?>
</div>
</body>
</html>