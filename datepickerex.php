<?php
session_start();
include_once ("func.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>datepickerex</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.bootstrap.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-datatables.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.css"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#datepicker_from, #datepicker_to" ).datepicker( { dateFormat: "yy-mm-dd" } );
        });
    </script>
</head>
<body>
<div class="btn btn-primary">
<form action="datepickerex.php" method="post">
    <p>Дата от : <input class="btn btn-default" type="text" id="datepicker_from" name="data_from">
        Дата до : <input class="btn btn-default" type="text" id="datepicker_to" name="data_to"></p>
    <input class="btn btn-default" type="submit" value="На экран"/>
</form>
<br/>

<?php
if(isset($_POST['data_from']) || isset($_POST['data_to'])){


    try {

        $pdo = new PDO("mysql:host=localhost;dbname=expensdb", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $pdo->exec('SET NAMES "utf8"');

        $userid = $_SESSION["userid"];
        $amounts = '';

        $query = "SELECT * FROM expdescrtb";

        if(isset($_POST['data_from']) && $_POST['data_from'] !== '') $query .= " WHERE expdate >= '".$_POST['data_from']."' AND userid = '".$userid."'";

        if(isset($_POST['data_to']) && $_POST['data_to'] !== '') $query .= " AND expdate <= '".$_POST['data_to']."' AND userid = '".$userid."'";
        $sth = $pdo->query($query);

        $sth->setFetchMode( PDO::FETCH_ASSOC);

        echo "РАСХОДЫ с:  {$_POST['data_from']} по: {$_POST['data_to']}" .'<br/><br/>';
        //echo $_POST['data_from'].'<br/><br/>';


        // выводим на страницу сайта заголовки HTML-таблицы
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>expdate</th>';
        echo '<th>exptype</th>';
        echo '<th>amount</th>';
        echo '<th>expdescr</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // выводим в HTML-таблицу все данные клиентов из таблицы MySQL
        while($row = $sth->fetch(PDO::FETCH_BOTH)) {

            $expdate = $row['expdate'];
            $exptype = $row['exptype'];
            $amount = $row['amount'];//суммируем все количества по счетам
            $expdescr = $row['expdescr'];
            $amounts += $amount;

            echo '<tr>';
            echo '<td>' . $expdate.'</td>';
            echo '<td>' . $exptype. '</td>';
            echo '<td>' . $amount. '</td>';
            echo '<td>' . $expdescr. '</td>';
            echo $amounts;

            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<br/><p><a href="datepickerex.php" class="btn btn-primary">НАЗАД</a>
                <a href="milestone.php" class="btn btn-primary">НА ГЛАВНУЮ</a></p>';
        exit();

    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }

}

?>
<div id="getlinkdate2">
<script type="text/javascript">

    $('#getlinkdate').on('click', function(){
     var date_from=document.getElementById('datepicker_from');
     var date_to=document.getElementById('datepicker_to');
        alert("date_from");
       // var link='excell.php?date_from="document.getElementById(\'datepicker_from\').value"&date_to="document.getElementById(\'datepicker_to\').value"';
            /*$.ajax({
                url: "excell.php",
                type: "POST",
                data: {date_from:"date_from", date_to:"date_to"},
                //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: function (response) {
                    alert(response.status);
                },
                error:function () {
                    alert("error");
                }
            });//end ajax
        })//end on
*/
</script>

<button type="submit" class="btn btn-warning" name="getlinkdate2" id="getlinkdate">Экспорт в Excell
</button>

<br/><br/>
<p><a href="reports.php" class="btn btn-primary">В ОТЧЕТЫ</a>
    <a href="milestone.php" class="btn btn-primary">НА ГЛАВНУЮ</a></p>
</div></div>
</body>
</html>