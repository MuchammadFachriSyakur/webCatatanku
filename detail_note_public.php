<?php
session_start();
include("database/config.php");
$usernameAvailable = false;
$usernameFix = "";
$profilePictureUsername = "";
$username = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];


if(isset($_POST['detailNotes'])){
  $id = $_POST['id'];
  $titleNotes = htmlspecialchars($_POST['titleNotes']);
  $descriptionNotes = $_POST['descriptionNotes'];
  $string = nl2br(str_replace(" ", " &nbsp;", $descriptionNotes));
  $descriptoSaveString = nl2br($descriptionNotes);
  $publish = htmlspecialchars($_POST['publish']);
  $idFolder = htmlspecialchars($_POST['idFolder']);
  $idUsername = htmlspecialchars($_POST['usernameFolder']);
  $NameFolder = htmlspecialchars($_POST['NameFolder']);
  $created_at = htmlspecialchars($_POST['created_at']);
  $image = htmlspecialchars($_POST['image']);
  $view = $_POST['view'];
  $intView = (int)$view;
  $plusOne = $intView + 1;

  $sqlUser = "SELECT * FROM user WHERE id='$idUsername'";
  $queryUser = mysqli_query($db,$sqlUser); 
  $resultQueryUser = mysqli_num_rows($queryUser);
  if($resultQueryUser > 0){
    $usernameAvailable = true;
    $data = mysqli_fetch_array($queryUser);
    $usernameFix = $data['username'];
    $profilePictureUsername = $data['image'];
  }

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
    <link rel="stylesheet" href="src/css/detail_note_public.css">
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

    <section class="predifined-notes">
      <div class="user-profile">
        <div class="wrap">
          <img src="img/<?= $profilePictureUsername; ?>" alt="Profile Picture User">
          <span>By <?= $usernameFix; ?> <?= $created_at; ?></span>  
        </div>
        <span class="view-note"><i class="ph ph-eye"></i> <?= $plusOne; ?></span>
      </div>

      <p class="title-notes"><?= $titleNotes; ?></p>
 
      <p class="descriptionNotes"><?= "$descriptoSaveString"; ?></p>
    </section>

<script src="src/js/imageNote.js"></script>
</body>
<!-- </html>
<p>
Pernahkah Anda berpikir: siapa sih yang membuat sebuah website? Jawabannya yaitu web developer. Nah, web developer adalah seseorang yang menggunakan skill teknisnya untuk mengembangkan dan mengelola website.

Kalau Anda suka problem solving, memiliki kreativitas tinggi, dan selalu update tentang tren teknologi, menjadi seorang web developer adalah pilihan karier yang tepat. Tak perlu khawatir harus belajar mulai dari mana. 

Di artikel ini, kami akan mengupas tuntas apa itu web developer, termasuk skill dan pengetahuan apa yang dibutuhkan untuk menjadi web developer sukses. Langsung saja, yuk simak artikelnya! 
</p> -->