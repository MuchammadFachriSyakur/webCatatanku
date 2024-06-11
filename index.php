<?php
session_start();
include("database/config.php");
$login_message = "";

if(isset($_POST['submitedFormLogin'])){
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  $hash_password = hash("sha256",$password);
  
  if(strlen($username) > 64){
    $login_message = "Username tidak boleh memiliki panjang lebih dari 64 huruf";
  }else{
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$hash_password'";
    $query = mysqli_query($db,$sql);
    
    // Cek username
    if(mysqli_num_rows($query) > 0){
      $data = mysqli_fetch_array($query);
      $user_name = $data['username'];
      $user_password = $data['password'];
      $user_level = $data['level'];
      
      echo "Password User didatabase adalah: " . $user_password;
      echo "Password User diinput adalah: " . $hash_password;
      
      // Cek Password
      if($user_password == $hash_password){
        echo "Pasword benar";
        
        // Cek Level akun
        if($user_level == "admin"){
          echo "Level akun adalah : admin";
          $_SESSION['username'] = $user_name;
          $_SESSION['is_login_admin'] = true;
          echo "<script>
            window.location.href = 'dashboard_admin.php';
          </script>";
        }else{
          echo "Level akun adalah : user";
          $_SESSION['username'] = $user_name;
          $_SESSION['is_login_user'] = true;
          echo "<script>
            window.location.href = 'dashboard_user.php';
          </script>";
        }
      }
    }
    
    $error = true;
    
  }
  
}

if(isset($_POST['forgotPassword'])){
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  
  $sql = "SELECT * FROM user WHERE username='$username'";
  $query = mysqli_query($db,$sql);
  
  if(mysqli_num_rows($query) > 0){
   $data = mysqli_fetch_array($query);
   $idUsername = $data['id'];
   $usernameFix = $data['username'];
   
   $targetUrl = "forgotPassword.php";
   $urlWithParam = $targetUrl . "id=" . $idUsername . "&username=" . $usernameFix . "&forgotPassword";
   
   echo "<script>window.location.href = 'forgotPassword.php?id=" . $idUsername . "&username=" . $usernameFix . "&forgotPassword" . "';</script>";
  }else{
    $login_message = "Username tidak ada";
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Catatanku || Login</title>
  <link rel="stylesheet" href="src/css/login.css">
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
  
 <div class="wrapForm">
   <form action="" method="POST">
    <h1 class="title">Login member</h1>
     
    <p class="message"><?= $login_message; ?></p>
    
    <div class="form-group">
      <input type="text" name="username" placeholder="Username">
    </div>
    
    <div class="form-group">
      <input type="password" class="password" name="password" placeholder="Password">
      <div class="wrapEye">
        <i class="ph ph-eye-slash"></i>
        <i class="ph ph-eye"></i>
      </div>
    </div>
    
    <a href="registrasi.php">Belum memiliki akun?</a>

    <button type="submit" name="forgotPassword">Lupa Password?</button>
    
    <button type="submit" class="submitedFormLogin" name="submitedFormLogin">Login</button>
  </form>
 </div>

<script src="src/js/login.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
