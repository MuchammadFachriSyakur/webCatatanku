<?php
session_start();
include("database/config.php");
$username = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];

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

if(!isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && !isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7']) ){
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
    <title>My Notes || Detail notes</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="src/css/detail_note.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-notes" data-background='img/<?= $image; ?>'>
      <div class="shadow-top">
       <a href="dashboard_user.php" class="back"><i class="ph ph-arrow-left"></i></a>
      </div>
      <p class="titleNotes"><?= $titleNotes; ?></p>
      <div class="shadow-bottom"></div>
    </div>
    <form action="proses_hapus_note.php" method="POST">

      <p class="descriptionNotes"><?= $descriptionNotes; ?></p>

      <p class="usernameFolder">Dibuat oleh: <?= $usernameFolder; ?></p>

      <p class="date">Tanggal: <?= $created_at; ?></p>
      
      <p class="date">View: <?= $plusOne; ?></p>
    </form>

<script src="src/js/imageNote.js"></script>
</body>
</html>