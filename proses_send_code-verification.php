<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include("database/config.php");

$emailSender = "muchammadfachrisyakur@gmail.com";
$nameOfTheSender = "My Notes";
$emailSubject = "Kode forgot password acount";

if(isset($_POST['sendCode'])){
    $messageCode = htmlspecialchars($_POST['kodeVerifikasiEmail']);
    $username = htmlspecialchars($_POST['username']);
    $emailUser = htmlspecialchars($_POST['emailUser']);

    $sql = "UPDATE user SET kode_verifikasi='$messageCode' WHERE username='$username'";
    $query = mysqli_query($db,$sql);
    if($query){
      $mail = new PHPMailer;
      $mail->isSMTP();
  
      $mail->Host = 'smtp.gmail.com';
      $mail->Username = $emailSender;
      $mail->Password = 'iisd miix whcc hvua';
      $mail->Port = 465;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'ssl';
      $mail->SMTPDebug = 2;
  
      $mail->setFrom($emailSender,$nameOfTheSender);
      $mail->addAddress($emailUser);
      $mail->isHTML(true);
  
      $mail->Subject = $emailSubject;
      $mail->Body = $messageCode;
  
      $send = $mail->send();
      
      if($send){
        $sendFile = "<script>
        alert('Kode verifikasi berhasil dikirimkan');
        window.location.href = 'forgotPassword.php?sending=benar&username=" . $username . "';
        </script>";

        echo $sendFile;
      }else{
        echo "<script>
        alert('Kode verifikasi gagal dikirimkan');
        window.location.href = 'forgotPassword.php?sending=salah';
      </script>";
      }
    }else{
      echo "<script>
        alert('Gagal mengirin kode verifikasi!!');
      </script>";
    }
}

?>