<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 24.07.2018
 * Time: 20:41
 */
session_start();
//подключаемся к базе данных если выражение isset вернет true
include_once('func.php');
$conn=mysqli_connect($server,$login,$password);
mysqli_query($conn, "SET NAMES UTF8");
mysqli_select_db($conn, $database);
if (isset($_POST['login']) && isset($_POST['password'])) {
    $userlogin = mysqli_real_escape_string($conn, $_POST['login']);
    $userpassword = md5(mysqli_real_escape_string($conn, $_POST['password']));
}
else if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
    $userlogin = mysqli_real_escape_string($conn, $_SESSION['login']);
    $userpassword = mysqli_real_escape_string($conn, $_SESSION['password']);
}
else {
    Header("Location: index.html");
}
$result=mysqli_query($conn, "SELECT * FROM users WHERE login='".$userlogin."' && password='".$userpassword."'");
$count=mysqli_num_rows($result);
if($count==0) {
    session_destroy();
    Header("Location: index.php");
}
else {

if(isset($_POST["exptype"]) && isset($_POST["amount"])){
    $expdate = mysqli_real_escape_string($conn, $_POST["expdate"]);
    $exptype = mysqli_real_escape_string($conn, $_POST["exptype"]);
    $amount = trim(mysqli_real_escape_string($conn, $_POST["amount"]));
    $amount = str_replace(',','.', $amount);
    $expdescr = mysqli_real_escape_string($conn, $_POST["expdescr"]);
}

$userid = $_SESSION["userid"];

$result = mysqli_query($conn, "INSERT INTO `expdescrtb` (`expid`, `expdate`, `exptype`, `amount`, `expdescr`, `userid`, `reserv`) VALUES (NULL, '".$expdate."', '".$exptype."', '".$amount."', '".$expdescr."', '".$userid."', '')");

if($result){
    echo '<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>success expinput</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.css"></script>
</head>
    <div class="btn bg-primary" align="center">'.
        'Данные о расходе '. $amount .' рублей на '. $exptype .' успешно внесены';
} else {
    echo "Что-то пошло не так. Расход не внесён.";
} echo
    '<br/><br/><p><a href="exp.html" class="btn btn-primary">Вернуться</a></p></div>';
}
?>