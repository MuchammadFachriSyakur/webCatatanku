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
    <link rel="stylesheet" href="src/css/detail_note.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-notes" data-background='img/<?= $image; ?>'>
     <p class="titleNotes"><?= $titleNotes; ?></p>
    </div>
    <form method="POST">
      <a href="dashboard_user.php">Kembali</a>

      <p class="descriptionNotes"><?= $descriptionNotes; ?></p>

      <p class="usernameFolder">Dibuat oleh: <?= $usernameFolder; ?></p>

      <p class="date">Tanggal: <?= $created_at; ?></p>

      <?php if($usernameFolder == $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']): ?>
        <input type="text" class="hidden" name="id" value="<?= $id; ?>" readonly>

        <input type="text" class="hidden" name="titleNotes" value="<?= $titleNotes; ?>" readonly>

        <input type="text" class="hidden" name="descriptionNotes" value="<?= $descriptionNotes; ?>" readonly>

        <input type="text" class="hidden" name="publish" value="<?= $publish; ?>" readonly>

        <input type="text" class="hidden" name="idFolder" value="<?= $idFolder; ?>">

        <input type="text" class="hidden" name="usernameFolder" value="<?= $usernameFolder; ?>">

        <input type="text" class="hidden" name="NameFolder" value="<?= $NameFolder; ?>">

        <input type="text" class="hidden" name="image" value="<?= $image; ?>">
        
        <input type="text" class="hidden" name="created_at" value="<?= $created_at; ?>">

        <button type="submit" formaction="form_edit_note.php" name="editNote">Edit</button>

        <button type="submit" formaction="proses_hapus_note.php" name="hapusNote" class="hapus">Hapus</button>
      <?php endif; ?>
    </form>

<script src="src/js/imageNote.js"></script>
<script src="src/js/confirmHapusNote.js"></script>
</body>
</html>