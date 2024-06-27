<?php
session_start();
include("database/config.php");
$usernameCookie = $_SESSION['username'];
$idUsername = "";
$username = "";
$usernameOne = "";
$password = "";
$email = "";
$image = "";

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
    echo "<script>
      window.location.href = 'index.php';
    </script>";
    exit;
  }

if(isset($_POST['settingAcount'])){
  $username = $_POST['username'];
  $sql = "SELECT * FROM user WHERE username='$username'";
  $query = mysqli_query($db,$sql);
  
  if(mysqli_num_rows($query) > 0){
    $data = mysqli_fetch_array($query);
    $idUsername = $data['id'];
    $username = $data['username'];
    $usernameOne = $data['username'];
    $password = $data['password'];
    $email = $data['email'];
    $image = $data['image'];
  }else{
    echo "<script>
      window.location.href = 'index.php';
    </script>";
  }
}

if(isset($_POST['editAccount'])){
 $id = $_POST['idUsername'];
 $usernameEdit = htmlspecialchars($_POST['username']);
 $usernameOne = htmlspecialchars($_POST['usernameOne']);
 $pasword = htmlspecialchars($_POST['password']);
 $email = htmlspecialchars($_POST['email']);
 
 $image_name = $_FILES['image']['name'];
 $image_error = $_FILES['image']['error'];
 $image_size = $_FILES['image']['size'];
 $image_tmp_name = $_FILES['image']['tmp_name'];

 $noSpaceUsername = str_replace(' ','',$usernameEdit);
 $noSpacePassword = str_replace(' ','',$pasword);
 $validationNumberUsername = preg_match("/\d/",$usernameEdit);
 $validationEmailUsername = filter_var($email,FILTER_VALIDATE_EMAIL);

 $sql = "SELECT * FROM user WHERE username='$usernameEdit'";
 $query = mysqli_query($db,$sql);
 $cekHasilQuery = mysqli_num_rows($query);
 
 if(strlen($usernameEdit) < 6){
    echo "Username kurang dari 6 digit";
 }elseif(strlen($usernameEdit) > strlen($noSpaceUsername)){
    echo "Pastikan usename yang anda masukan tidak mengandung spasi";
 }elseif(strlen($pasword) < 6){
    echo "Passowrd kurang dari 6 digit";
 }elseif(strlen($pasword) > strlen($noSpacePassword)){
    echo "Pastikan password yang anda masukan tidak mengandung spasi";
 }elseif($validationEmailUsername == false){
    echo "Kamu harus memasukan alamat email yang benar";
 }elseif(!$validationNumberUsername){
    echo "Pastikan username berisi setidaknya 1 angka";
 }elseif($usernameOne == $usernameEdit){
    echo "Anda tidak mengganti username!!!";
    //Tinggal melanjutkan sql atau mengganti yang lainnya
    if($image_error == 4 ){
        echo "Tidak mengganti gambar";
        //Tinggal melanjutkan sql atau mengganti yang lainnya
     }
 }else{
    
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes</title>
</head>
<body>
   <form class="form_add_notes" method="POST" enctype="multipart/form-data">
    <input type="text" name="idUsername" value="<?= $idUsername; ?>"><br><br>
    <input type="text" name="username" value="<?= $username; ?>"><br><br>
    <input type="text" name="usernameOne" value="<?= $usernameOne; ?>"><br><br>
    <input type="text" name="password" value="<?= $password; ?>"><br><br>
    <input type="text" name="email" value="<?= $email; ?>"><br><br>
    <p>Gambar Sebelumnya:</p>
    <input type="image" src="img/<?= $image; ?>" alt=""><br><br>
    <input type="file" name="image" value="<?= $image; ?>">
    <button type="submit" name="editAccount" formaction="">Edit</button>
   </form>
</body>
</html>
