<?php 
$hostname = "127.0.0.1";
$username = "root";
$password = "admin123";
$databaseName = "webCatatan";

$db = mysqli_connect($hostname,$username,$password,$databaseName);

if(!$db){
  die("error");
}
?>