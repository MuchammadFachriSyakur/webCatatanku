<?php
session_start();
include("database/config.php");
$usernameCookie = $_SESSION['username'];
$idUsername = "";
$username = "";
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
    $password = $data['password'];
    $email = $data['email'];
    $image = $data['image'];
  }else{
    echo "<script>
      window.location.href = 'index.php';
    </script>";
  }
}else{
  echo "<script>
    window.location.href = 'index.php';
  </script>";
}

if(isset($_POST['editAccount'])){
 $id = $_POST['idUsername'];
 $usernameEdit = htmlspecialchars($_POST['username']);
 $pasword = htmlspecialchars($_POST['password']);
 $email = htmlspecialchars($_POST['email']);
 $image = htmlspecialchars($_POST['image']);
 
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
    <input type="text" name="password" value="<?= $password; ?>"><br><br>
    <input type="text" name="email" value="<?= $email; ?>"><br><br>
    <p>Gambar Sebelumnya:</p>
    <input type="image" src="img/<?= $image; ?>" alt=""><br><br>
    <input type="text" name="image" value="<?= $image; ?>">
    <button type="submit" name="editAccount" formaction="">Edit</button>
   </form>
</body>
</html>