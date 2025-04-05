<?php
$db_server="localhost";
$db_user="root";
$db_pass="";
$db_name="studentdata";
$mysqli="";
try{
    $mysqli = new mysqli($db_server,$db_user,$db_pass,$db_name);

}
catch(mysqli_sql_exception){
    echo"could not connect!";
}
if($mysqli){
    echo "you are connected";
}