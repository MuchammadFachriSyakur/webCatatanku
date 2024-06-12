<?php 
session_start();
include("database/config.php");

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
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
  <title>Homepage || Catatanku</title>
</head>
<body>
  <form action="logout.php">
    <button type="submit">Logout</button>
  </form>
  <h1>Selamat datang diwbesite catatanku</h1>
</body>
</html>
