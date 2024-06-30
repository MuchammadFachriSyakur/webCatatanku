<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['kirim_email'])){
    $email_pengirim = 'muchammadfachrisyakur@gmail.com';
    $nama_pengirim = 'My Notes';
    $email_penerima = htmlspecialchars($_POST['email']);
    $subjek = htmlspecialchars($_POST['subject']);
    $pesan = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer;
    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->Username = $email_penerima;
    $mail->Password = 'pomzsioetfzkvjbq';
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPDebug = 2;
      
    $mail->setFrom($email_pengirim, $nama_pengirim);
    $mail->addAddress($email_penerima);
    $mail->isHTML(true);

    $mail->Subject = $subjek;
    $mail->Body = $pesan; 

    $send = $mail->send();

    if($send){
     echo "Succes";
    }else{
    echo "Succes";
    }
}
?>