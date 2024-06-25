<?php 
session_start();
include("database/config.php");

if( !isset($_SESSION['username']) & !isset($_SESSION['is_login_admin']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard Admin || Catatanku</title>
</head>
<body>
  <h1>Selamat datang didashboard admin website catatanku</h1>
</body>
</html>