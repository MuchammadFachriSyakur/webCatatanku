<?php
session_start();
include("database/config.php");
$idFolder = 0;
$nameFolder = "";
$idUsername = 0;
$usernameToAddFolder = "";
$usernameFix = "";
$usernameSession = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];

if(!isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && !isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7'])){
  $userSession = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];
  $sql = "SELECT * FROM user";
  $query = mysqli_query($db,$sql);

  while($data = mysqli_fetch_array($query)){
    $idUsernameDatabase = $data['id'];
    $usernameDatabase = $data['username'];
    $hashUsernameDatabase = hash("sha256",$data['username']);
    if($usernameSession == $hashUsernameDatabase){
      $idUsername = $idUsernameDatabase;
      $usernameFix = $usernameDatabase;
    }
  }
}

if(isset($_POST['addNote'])){
  $idFolder = $_POST['idFolder'];
  $nameFolder = htmlspecialchars($_POST['namesFolder']);
  $usernameToAddFolder = htmlspecialchars($_POST['usernameToAddFolder']);
}

if(isset($_POST['tambahCatatan'])){
  $titleNotes = htmlspecialchars($_POST['titleNotes']);
  $descriptionNotes = htmlspecialchars($_POST['descriptionNotes']);
  $saveString = nl2br(str_replace(" ", " &nbsp;",$descriptionNotes));
  $publish = htmlspecialchars($_POST['publish']);

  $namaFolder = htmlspecialchars($_POST['nameFolder']);

  $idfolder = $_POST['idFolder'];
  $idUsername = htmlspecialchars($_POST['idUsername']);

  $nameFile = $_FILES['background_notes']['name'];
  $sizeFile = $_FILES['background_notes']['size'];
  $errorFile = $_FILES['background_notes']['error'];
  $tmpNameFile = $_FILES['background_notes']['tmp_name'];

  //Mengecek apakah gambar diupload atau tidak
  if($errorFile === 4){
    echo "<script>
      alert('Silahkan Pilih gambar terlebih dahulu');
    </script>";
    exit;
  }

  //Menegcek gambar yang diupload apakah valid
  $ektensiGambarValid = ['jpeg','png','jpg'];
  $ektensiGambar = explode('.',$nameFile);
  $ektensiGambar = strtolower(end($ektensiGambar));

  if(!in_array($ektensiGambar,$ektensiGambarValid)){
    echo "<script>
      alert('Silahkan upload file yang memiliki ekstensi jpeg,jpg dan png');
      window.location.href = 'dashboard_user.php';
    </script>";
    exit;
  }

  //Mengecek ukuran gambar jika terlalu besar
  if($sizeFile > 1000000){
    echo "<script>
      alert('Ukuran gambar telalu besar');
    </script>";
    exit;
  }

  //Mmebuat nama baru 
  $newNameFile = uniqid();
  $newNameFile .= '.';
  $newNameFile .= $ektensiGambar;

  //lolos pengecekan 
  move_uploaded_file($tmpNameFile, 'img/' . $newNameFile);
   
  $sql = "INSERT INTO notes (titleNotes,descriptionNotes,publish,idFolder,idUsername,NameFolder,image) VALUES ('$titleNotes','$saveString','$publish','$idfolder','$idUsername','$namaFolder','$newNameFile')";
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

if($idFolder == 0 & $nameFolder == "" & $usernameToAddFolder == ""){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(!$usernameFix === $usernameToAddFolder){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Notes || Create Notes</title>
  <link rel="stylesheet" href="src/css/form_add_notes.css" type="text/css" media="all" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="img/asset/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/asset/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/asset/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="img/asset/favicon_io/site.webmanifest">
</head>
<body>
  <form class="form_add_notes" method="POST" enctype="multipart/form-data">
    <h1 class="title">Formulir Catatan</h1>

    <input type="text" class="hidden" name="idFolder" value="<?= $idFolder; ?>" readonly required>

    <input type="text" class="hidden" name="nameFolder" value="<?= $nameFolder; ?>" readonly required>

    <input type="text" class="hidden" name="idUsername" value="<?= $idUsername; ?>" readonly required>

    <input type="text" name="titleNotes" placeholder="Masukan judul catatan anda" required>

    <input type="text" name="descriptionNotes" placeholder="Masukan deskripsi catatan anda" required>

    <input type="file" name="background_notes" placeholder="Silahkan masukan gambar yang kamu sukai" required>

    <select name="publish" required>
      <option value="">Silahkan pilih publish atau private</option>
      <option value="Private">Private</option>
      <option value="Publis">Publis</option>
    </select>

    <a href="detail_folder.php">Kembali</a>

    <button type="submit" name="tambahCatatan">Tambah</button>
  </form>
</body>
</html>
