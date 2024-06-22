<?php 
session_start();
include("database/config.php");
$idFolder = 0;
$username = $_SESSION['username'];
$usernameFolderPadaDatabase = "";
$namaFolderPadaDatabase = "";

if($usernameFolderPadaDatabase == "" & $namaFolderPadaDatabase == "" & !$idFolder == 0){
  echo "<script>
    window.location.href = 'dashboard_user.php';
  </script>";
  exit;
}

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(isset($_POST['editFolder'])){
  $idFolder = $_POST['idFolder'];
  $sql = "SELECT * FROM folder WHERE id='$idFolder'";
  $query = mysqli_query($db,$sql);
  $data = mysqli_fetch_array($query);
  $usernameFolderPadaDatabase = $data['username'];
  $namaFolderPadaDatabase = $data['name'];
  
  if(!$username == $usernameFolderPadaDatabase){
    echo "<script>
      window.location.href = 'dashboard_user.php';
    </script>";
    exit;
  }
}

if(isset($_POST['updateFolder'])){
  $idFol = $_POST['idFolder'];
  $usernameFolder = htmlspecialchars($_POST['username']);
  $namaFolder = htmlspecialchars($_POST['namaFolder']);
  
  $sql = "UPDATE folder SET name='$namaFolder' WHERE id='$idFol'";
  $query = mysqli_query($db,$sql);
  
  if($query){
    echo "<script>
      alert('Berhasil mengubah nama folder');
      window.location.href = 'dashboard_user.php';
    </script>";
  }else{
    echo "<script>
      alert('Gagal mengubah nama folder');
      window.location.href = 'dashboard_user.php';
    </script>";
  }
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Notes || Formulir edit folder</title>
</head>
<body>
  <form method="POST">
    <h1>Formulir edit folder</h1>
    <input type="text" name="idFolder" value="<?= $idFolder; ?>" readonly>
    <input type="text" name="username" value="<?= $usernameFolderPadaDatabase; ?>" readonly>
    <input type="text" name="namaFolder" value="<?= $namaFolderPadaDatabase; ?>">
    <button type="submit" name="updateFolder" formaction="">Edit</button>
  </form>
</body>
</html>