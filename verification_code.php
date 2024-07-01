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
  <title>My Notes || Verification Code</title>
  <link rel="stylesheet" href="src/css/forgot_password.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet" />
  <link rel="apple-touch-icon" sizes="180x180" href="img/asset/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/asset/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/asset/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="img/asset/favicon_io/site.webmanifest">
</head>
<body>
    <header>
      <a href="index.php">Kembali</a>
      <?= "Verifikasi password : " . $checkingVerificationCode; ?>
    </header>
    <main>
      <h1 class="title">Formulir Change Password</h1>
      <?php if($checkingVerificationCode == "yes"): ?>
      <form method="POST" class="formCheckedCodeVerification">
        <label for="id" class="hidden">
          Id :
          <input type="text" name="id" readonly>
        </label>

        <label for="username" class="hidden">
          Username :
          <input type="text" name="username" value="<?= $username; ?>" placeholder="Masukan username yang sesuai" readonly>
        </label>

        <label for="kode" class="hidden">
          Kode :
          <input type="text" name="kode" value="<?= $kode; ?>" placeholder="Masukan username yang sesuai" readonly>
        </label>

        <p><?= $messageErrorPassword; ?></p>

        <label for="password">
          Password :
          <input type="text" name="password" placeholder="Masukan password dengan benar" required>
        </label>

        <button type="submit" name="changePassword">C Password</button>
      </form>
      <?php endif; ?>
    </main>
</body>
</html>
