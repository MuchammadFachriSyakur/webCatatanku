<?php
include("database/config.php");
$regitrasi_message = "";
$message_error_username = "";
$message_error_password = "";
$message_error_email = "";

if(isset($_POST['submitedFormLogin'])){
  $username = htmlspecialchars($_POST['nama']);
  $password = htmlspecialchars($_POST['pw']);
  $hash_password = hash("sha256",$password);
  $email = htmlspecialchars($_POST['email']);
  $image_name = $_FILES['gambar_barang']['name'];
  $image_error = $_FILES['gambar_barang']['error'];
  $image_size = $_FILES['gambar_barang']['size'];
  $image_tmp_name = $_FILES['gambar_barang']['tmp_name'];
  
  $validation_number_username = preg_match("/\d/",$username);
  
  $no_space_username = str_replace(' ','',$username);
  $no_space_password = str_replace(' ','',$password);
  $isValidEmail = filter_var($email,FILTER_VALIDATE_EMAIL);
  
  $extention_image_valid = ['jpg','jpeg','png'];
  $extention_image = explode('.',$image_name);
  $extention_image = strtolower(end($extention_image));
  
  $new_name_file = uniqid();
  $new_name_file .= '.';
  $new_name_file .= $extention_image;
  
  if(strlen($username) > strlen($no_space_username)){
    $message_error_username = "Pastikan masukan username tanpa spasi";
  }elseif(strlen($password) > strlen($no_space_password)){
    $message_error_password = "Pastikan password yang anda masukan tidak mengandung spasi";
  }elseif(!$validation_number_username){
    $message_error_username = "Pastikan username berisi setidaknya 1 angka";
  }elseif($isValidEmail == false){
    $message_error_email = "Kamu harus memasukan alamat email yang benar";
  }elseif($image_error == 4){
    echo "<script>alert('Masukan gambar terlebih dahulu')</script>";
  }elseif(!in_array($extention_image,$extention_image_valid)){
    echo "<script>alert('Jangan masukan gambar selain jpg,jpeg dan png!!!')</script>";
  }elseif($image_size > 1000000){
    echo "<script>alert('Pastikan gambar tidak melebihi 1mb!!!')</script>";
  }else{
    try{
      $sql = "INSERT INTO user (username,password,email,image) VALUES ('$username','$hash_password','$email','$new_name_file')";
      $query = mysqli_query($db,$sql);
      if($query){
        $regitrasi_message = "Akun berhasl dibuat";
        move_uploaded_file($image_tmp_name,'img/' . $new_name_file);
      }else{
        $regitrasi_message = "Akun gagal dibuat,silahkan coba lagi";
      }
    }catch(mysqli_sql_exception){
      $regitrasi_message = "Username yang anda masukan sudah ada!";
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
  <title>Catatanku || Registrasi</title>
  <link rel="stylesheet" href="src/css/login.css">
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
  
 <div class="wrapForm">
   <form method="POST" class="form_edit_barang" enctype="multipart/form-data">
    <h1 class="title">Registrasi Member</h1>
    
    <p><?= $regitrasi_message; ?></p>
    
    <p class="message"><?= $message_error_username; ?></p>
    
    <div class="form-group">
      <input type="text" name="nama" placeholder="Username" required>
    </div>
    
    <div class="form-group">
      <input type="password" class="password" name="pw" placeholder="Password" required>
      <div class="wrapEye">
        <i class="ph ph-eye-slash"></i>
        <i class="ph ph-eye"></i>
      </div>
    </div>
    
    <p><?= $message_error_email; ?></p>
    
    <div class="form-group">
      <input type="email" name="email" placeholder="Email" required>
    </div>
    
    <input class="file" type="file" name="gambar_barang"/>
    
    <a href="index.php">Sudah mempunyai akun?</a>
    
    <button type="submit" class="submitedFormLogin" name="submitedFormLogin">Registrasi</button>
  </form>
   
 </div>
 
<script src="src/js/login.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>