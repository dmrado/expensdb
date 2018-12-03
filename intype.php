<?php
/**
 * Created by PhpStorm.
 * User: dmrado
 * Date: 26.07.2018
 * Time: 14:48
 */
include_once ("func.php");
$conn = mysqli_connect($server, $login, $password);
mysqli_query($conn, 'SET NAMES UTF8');
mysqli_select_db($conn, $database);

if(isset($_POST["query"])){
    $input = mysqli_real_escape_string($conn, $_POST["query"]);
    $output = '';
    $result = mysqli_query($conn, "SELECT inctype FROM type_id2 WHERE inctype LIKE '%".$input."%'");

    $output = '<ul class="list-unstyled">';

    if(mysqli_num_rows($result)!=0){
        while($row = mysqli_fetch_array($result)){
            $output .= '<li>'.$row["inctype"].'</li>';
        }
    } else {
        $output .= '<li>Нет подходящего типа расхода</li>';
    }
    $output .= '</ul>';
    echo $output;
}