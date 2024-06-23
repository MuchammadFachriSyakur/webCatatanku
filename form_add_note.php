<?php
session_start();
include("database/config.php");
$idFolder = 0;
$nameFolder = "";
$usernameToAddFolder = "";

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(isset($_POST['addNote'])){
  $idFolder = $_POST['idFolder'];
  $nameFolder = htmlspecialchars($_POST['namesFolder']);
  $usernameToAddFolder = htmlspecialchars($_POST['usernameToAddFolder']);
}

//if($idFolder == 0 & $nameFolder == "" & $usernameToAddFolder == ""){
//  echo "<script>
//    window.location.href = 'index.php';
//  </script>";
//  exit;
//}

if(isset($_POST['tambahCatatan'])){
  $titleNotes = htmlspecialchars($_POST['titleNotes']);
  $descriptionNotes = htmlspecialchars($_POST['descriptionNotes']);
  $publish = htmlspecialchars($_POST['publish']);
   
  $sql = "INSERT INTO notes (titleNotes,descriptionNotes,publish,idFolder,usernameFolder,NameFolder) VALUES ('$titleNotes','$descriptionNotes','$publish','$idFolder','$usernameToAddFolder','$nameFolder')";
  $query = mysqli_query($db,$sql);
  
  if($query){
    echo "<script>
      alert('Data berhasil ditambahkan');
    </script>";
  }else{
    echo "<script>
      alert('Data gagal ditambahkan');
    </script>";
  }
  echo "<script>
    window.location.href = 'dashboard_user.php';
  </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Notes || Create Notes</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <form method="POST">
    <input type="text" name="idFolder" value="<?= $idFolder; ?>" readonly required>
    <input type="text" name="nameFolder" value="<?= $nameFolder; ?>" readonly required>
    <input type="text" name="username" value="<?= $usernameToAddFolder; ?>" readonly required>
    <input type="text" name="titleNotes" placeholder="Masukan judul catatan anda" required>
    <input type="text" name="descriptionNotes" placeholder="Masukan deskripsi catatan anda" required>
    <select name="publish" required>
      <option value="Private">Private</option>
      <option value="Publis">Publis</option>
    </select>
    <button type="submit" formaction="" name="tambahCatatan">Tambah</button>
  </form>
</body>
</html>