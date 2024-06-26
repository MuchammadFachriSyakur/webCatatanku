<?php 
include("database/config.php");

$checkingVerificationCode = '';
$messageErrorPassword = '';


if(isset($_GET['verification_code'])){
    $username = htmlspecialchars($_GET['username']);
    $kode = htmlspecialchars($_GET['kode']);

    $sql = "SELECT * FROM user WHERE username='$username'";
    $query = mysqli_query($db,$sql);

    if(mysqli_num_rows($query) == 0){
        echo "<script>
        window.location.href = 'index.php';
      </script>";
    }

    $data = mysqli_fetch_array($query);

    $usernameDatabase = $data['username'];
    $kodeVerifikasi = $data['kode_verifikasi'];

    if($kode === $kodeVerifikasi){
      $checkingVerificationCode = "yes";
    }else{
      echo "<script>
        alert('Kode verifikasi salah,pastikan kode yang anda ketik sama dengan kode yang ada diemail anda!!!');
        window.location.href = 'index.php';
      </script>";
    }

}

if(isset($_POST['changePassword'])){
  $usernameChangePassword = htmlspecialchars($_POST['username']);
  $newCode = htmlspecialchars($_POST['kode']);
  $newPassword = $_POST['password'];
  $lengthPassword = strlen($newPassword);
  
  $arrayPassword = str_split($newPassword);
  $allInteger = false;

  foreach($arrayPassword as $data){
    $int = (int)$data;
    if($int > 0){
      $allInteger = true;
    }
  }

  if($lengthPassword < 6){
    $messageErrorPassword = "Password harus memiliki setidaknya 6 huruf baik string maupun integer";
  }elseif(preg_match('/\s+/',$newPassword)){
    $messageErrorPassword = "Password mengandung spasi";
  }elseif(!preg_match('/[A-Z]+/',$newPassword)){
    $messageErrorPassword = "Password tidak mengandung huruf kapital";
  }elseif($allInteger == false){
    $messageErrorPassword = "Setidaknya kamu harus memiliki 1 angka pada passwordmu";
  }else{
    $newHashPassword = hash("sha256",$newPassword);
    $sql = "UPDATE user SET password='$newHashPassword' WHERE username='$usernameChangePassword'";
    $query = mysqli_query($db,$sql);

    if($query){
      echo "<script>
       alert('Pasword Berhasil diubah');
       window.location.href = 'index.php';
      </script>";
      exit;
    }else{
      echo "<script>
       alert('Pasword gagal diubah!!!');
       window.location.href = 'index.php';
      </script>";
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php if($checkingVerificationCode == "yes"): ?>
    <form action="" method="POST">
      <input type="text" name="id" readonly>
      <input type="text" name="username" value="<?= $username; ?>" placeholder="Masukan username yang sesuai" readonly>
      <input type="text" name="kode" value="<?= $kode; ?>" placeholder="Masukan username yang sesuai" readonly>
      <p><?= $messageErrorPassword; ?></p>
      <input type="text" name="password" placeholder="Masukan password dengan benar" required>
      <button type="submit" name="changePassword">Ganti Password</button>
    </form>
  <?php endif; ?>
</body>
</html>