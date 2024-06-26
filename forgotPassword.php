<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include("database/config.php");

function generatiCodeVerifikasi($length){
  $numbers = '';
  for($i = 0;$i < $length;$i++){
    $numbers .= random_int(0,9);
  }
  return $numbers;
}

$kodeVerifikasiEmail = generatiCodeVerifikasi(6);

$username = "";
$emailUser = "";
$emailSender = "muchammadfachrisyakur@gmail.com";
$nameOfTheSender = "My Notes";
$emailSubject = "Kode forgot password acount";
$messageCode = "Berikut ini adalah kode untuk mereset password: " . $kodeVerifikasiEmail;

if(isset($_GET['forgotPassword'])){
  $id = $_GET['id'];
  $username = htmlspecialchars($_GET['username']);
  
  $sql = "SELECT * FROM user WHERE username='$username'";
  $query = mysqli_query($db,$sql);
  
  $dataUser = mysqli_fetch_array($query);
  $username = $dataUser['username'];
  $emailUser = $dataUser['email'];
  

  if(mysqli_num_rows($query) == 0){
    header("location : index.php?status-gagal");
  }
}

$cekSending = '';
$userSending = '';
if(isset($_GET['sending'])){
  $sending = $_GET['sending'];
  $userSending = $_GET['username'];

  if($sending == 'benar'){
    $cekSending = "iya";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Catatan || forgot password</title>
</head>
<body>
  
  <form method="POST">
    <input type="text" name="kodeVerifikasiEmail" value="<?= $kodeVerifikasiEmail; ?>">

    <input type="text" name="username" value="<?= $username; ?>">

    <input type="text" name="emailUser" value="<?= $emailUser; ?>">

    <button type="submit" name="sendCode" formaction="proses_send_code-verification.php">Kirim kode</button>
  </form>

  <br><br><br>
  
  <?php if($cekSending == 'iya'): ?>
  <form method="GET">
    <input type="text" name="username" value="<?= $userSending; ?>">
    <input type="number" name="kode" placeholder="Masukan kode verifikasi">
    <button type="submit" name="verification_code" formaction="verification_code.php">verifikasi code</button>
  </form>
  <?php endif; ?>
  
</body>
</html>
