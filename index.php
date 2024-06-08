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
    
    if(mysqli_num_rows($query) > 0){
      $data = mysqli_fetch_array($query);
      $user_name = $data['username'];
      $user_level = $data['level'];
      
      if($user_level == "admin"){
        $_SESSION['username'] = $user_name;
        $_SESSION['is_login_admin'] = true;
        echo "<script>
        window.location.href = 'dashboard_admin.php';
        </script>";
      }else{
        $_SESSION['username'] = $user_name;
        $_SESSION['is_login_admin'] = true;
        echo "<script>
        window.location.href = 'dashboard_user.php';
        </script>";
      }
    }
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
  
 <div class="wrapForm">
   <form action="" method="POST">
     <h1>Login member</h1>
     
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" name="username">
    </div>
    
    <div class="form-group">
      <label for="username">Password:</label>
      <input type="password" name="password">
    </div>
    
    <a href="registrasi.php">Belum mempunyai akun?</a>

    <button type="submit" name="submitedFormLogin">Login</button>
  </form>
 </div>
  
</body>
</html>