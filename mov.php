<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 09.08.2018
 * Time: 20:46
 */
session_start();
include_once('func.php');//объединить оба скрипта с обработкой балланса
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
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>datemov</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.bootstrap.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-datatables.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.css"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-ui.js"></script>
</head>
<body>
<div class="btn btn-primary">
<form action="mov.php" method="POST">
    <p>Дата<input type="date" id="datepicker_mov" name="data_mov" value="" class="btn btn-default"/>
       <!-- <script>
            $(document).ready(function() {
                $( "#datepicker_mov").datepicker( { dateFormat: "yy-mm-dd" } );
            });
        </script>-->
    <input class="btn btn-default" type="submit" value="На экран"/>
</form>
<br/>

<?php
if(isset($_POST["data_mov"])){
$inputmov = mysqli_real_escape_string($conn, ($_POST["data_mov"]));

        $userid = $_SESSION["userid"];
    var_dump($userid);
    var_dump($inputmov);
    //вариант с подзапросом 1
   $inquery = mysqli_query($conn, "SELECT SUM(incamount) AS incamount FROM incdescrtb WHERE userid = '".$userid."' (SELECT FROM incdescrtb WHERE incdate <= '".$inputmov."')");

   //вариант с подзапросом 2
    //$inquery = mysqli_query($conn, "SELECT SUM(incamount) FROM incdescrtb WHERE incdate <= '".$inputmov."' (SELECT SUM(incamount) FROM incdescrtb WHERE userid = '".$userid."')");

    //вариант работающий в скрипте datepickerin
   // $inquery = "SELECT SUM (incamount) AS incamount FROM  incdescrtb";
   // if(isset($inputmov) && $inputmov !== '') $inquery .= " WHERE incdate <= '".$inputmov."' AND userid = '".$userid."'";
    while($row = mysqli_fetch_array($inquery)){
        $inqueryResult = $row["incamount"];
    }

        echo $inquery. 'ВНИМАНИЕ НА ЭКРАН';

    //$exquery = "SELECT SUM (amount) AS exquery FROM  expdescrtb GROUP BY amount";

    if(isset($inputmov) && $inputmov != '') $exquery .= " WHERE incdate <= '".$inputmov."' AND userid = '".$userid."'";

    while($row = mysqli_fetch_array($exquery)){
        $exqueryResult = $row[0];
    }

    //основные варианты - это две строки ниже
        $inquery = mysqli_query($conn,"SELECT SUM (incamount) AS sum FROM incdescrtb WHERE incdate <= '".$inputmov."' && userid = '".$userid."' GROUP BY incamount");

    $exquery = mysqli_query($conn,"SELECT SUM(amount) AS incsum FROM expdescrtb WHERE expdate <= '".$inputmov."' && userid = '".$userid."' GROUP BY amount");

var_dump($inquery);
var_dump($exquery);

/*$chek = mysqli_query($conn, "SELECT SUM(amount) FROM expdescrtb WHERE expdate = '".$inputmov."' && userid = '".$userid."'");
    var_dump($chek);*/

        $mov = $exqueryResult - $inqueryResult;
        var_dump($mov);
        echo "РАСЧЕТЫЙ БАЛАНС НА: {$inputmov} РАВЕН {$mov}";

        echo '<br/><br/><p><a href="milestone.php" class="btn btn-primary">НА ГЛАВНУЮ</a></p>';
        exit();

}
?>
