<?php
include("database/config.php");

function generatiCodeVerifikasi($length){
  $numbers = '';
  for($i = 0;$i < $length;$i++){
    $numbers .= random_int(0,9);
  }
  return $numbers;
}

$kodeVerifikasiEmail = generatiCodeVerifikasi(6);
echo "Your verifikasi code is" . $kodeVerifikasiEmail;

$username = "";
$emailUser = "";
$subjek = "Code verifikasi";

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
  }else{
    echo "Ada";
  }
}

if(isset($_POST['sendCode'])){
  $sql = "UPDATE user SET kode_verifikasi='$kodeVerifikasiEmail' WHERE username='$username'";
  $query = mysqli_query($db,$sql);
  if($query){
    $headers = "From: muchammadfachrisyakur@gmail.com" . "\r\n" . "Content-Type: text/plain;charset=UTF-8";
    $messageCode = "Berikur ini adalah kode untuk mereset password: " . $kodeVerifikasiEmail;
    
    $sentMessage = mail($emailUser,$subjek,$messageCode,$headers);
    
    if($sentMessage){
      echo "Email sent succesfuly";
    }else{
      echo "Email Sending failed";
    }
    echo "<script>
      alert('Kode verifikasi telah dikirimkan ke email akun');
    </script>";
  }else{
    echo "<script>
      alert('Gagal mengirin kode verifikasi!!');
    </script>";
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
  
  <form action="" method="POST">
    <button type="submit" name="sendCode">Kirim kode</button>
  </form>
  
</body>
</html>