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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>My Notes || forgot password</title>
    <link rel="stylesheet" href="src/css/forgot_password.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="apple-touch-icon" sizes="180x180" href="img/asset/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/asset/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/asset/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="img/asset/favicon_io/site.webmanifest">
  </head>
  <body>
    <header>
      <a href="index.php">Kembali</a>
    </header>
    <main>
      <h1 class="title">Formulir Verification Code</h1>
      <form method="POST" class="formSendCodeVerification">
        <label for="kodeVerifikasiEmail" class="hidden">
          Kode verifikasi :
          <input
            type="text"
            name="kodeVerifikasiEmail"
            value="<?= $kodeVerifikasiEmail; ?>"
            readonly
          />
        </label>

        <label for="username" class="hidden">
          Username :
          <input
            type="text"
            name="username"
            value="<?= $username; ?>"
            readonly
          />
        </label>

        <label for="emailUser" class="hidden">
          Email :
          <input
            type="text"
            name="emailUser"
            value="<?= $emailUser; ?>"
            readonly
          />
        </label>

        <button
          type="submit"
          name="sendCode"
          formaction="proses_send_code-verification.php"
        >
          Kirim kode
        </button>
      </form>

      <?php if($cekSending == 'iya'): ?>
      <form method="GET" class="formCheckedCodeVerification">
        <label for="username" class="hidden">
          Username :
          <input
            type="text"
            name="username"
            value="<?= $userSending; ?>"
            readonly
          />
        </label>

        <label for="kode">
          Kode Verifikasi :
          <input
            type="number"
            name="kode"
            placeholder="Masukan kode verifikasi"
            required
          />
        </label>

        <button
          type="submit"
          name="verification_code"
          formaction="verification_code.php"
        >
          verifikasi code
        </button>
      </form>
      <?php endif; ?>
    </main>
  </body>
</html>
