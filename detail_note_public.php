<?php
session_start();
include("database/config.php");
$username = $_SESSION['username'];

if(isset($_POST['detailNotes'])){
  $id = $_POST['id'];
  $titleNotes = htmlspecialchars($_POST['titleNotes']);
  $descriptionNotes = htmlspecialchars($_POST['descriptionNotes']);
  $publish = htmlspecialchars($_POST['publish']);
  $idFolder = htmlspecialchars($_POST['idFolder']);
  $usernameFolder = htmlspecialchars($_POST['usernameFolder']);
  $NameFolder = htmlspecialchars($_POST['NameFolder']);
  $created_at = htmlspecialchars($_POST['created_at']);
  $image = htmlspecialchars($_POST['image']);
  $view = $_POST['view'];
  $intView = (int)$view;
  $plusOne = $intView + 1;

  $sql = "UPDATE notes SET view='$plusOne' WHERE id='$id'";
  $query = mysqli_query($db,$sql);
}else{
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
    <title>My Notes || Detail notes</title>
    <link rel="stylesheet" href="src/css/detail_note.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-notes" data-background='img/<?= $image; ?>'>
     <p class="titleNotes"><?= $titleNotes; ?></p>
    </div>
    <form action="proses_hapus_note.php" method="POST">
      <a href="dashboard_user.php">Kembali</a>

      <p class="descriptionNotes"><?= $descriptionNotes; ?></p>

      <p class="usernameFolder">Dibuat oleh: <?= $usernameFolder; ?></p>

      <p class="date">Tanggal: <?= $created_at; ?></p>
      
      <p class="date">View: <?= $plusOne; ?></p>
    </form>

<script src="src/js/imageNote.js"></script>
</body>
</html>