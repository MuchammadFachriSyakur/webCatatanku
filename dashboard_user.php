<?php 
session_start();
include("database/config.php");
$username = $_SESSION['username'];
$profilePicture = "";

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(isset($_GET['createFolder'])){
  $nameFolder = htmlspecialchars($_GET['nameFolder']);
  $sql = "INSERT INTO folder (username,name) VALUES ('$username','$nameFolder')";
  $query = mysqli_query($db,$sql);
  
  if($query){
    echo "<script>
      alert('Data berhasil ditambahkan');
      window.location.href = 'dashboard_user.php';
    </script>";
  }
}

if(isset($_SESSION['username']) && isset($_SESSION['is_login_user'])){
  $userSession = $_SESSION['username'];
  $sql = "SELECT * FROM user WHERE username='$username'";
  $query = mysqli_query($db,$sql);

  if($query){
    $data = mysqli_fetch_array($query);
    $profilePicture = $data['image'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Welcome to mynotes</title>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="stylesheet" href="src/css/defaultHomePage.css" type="text/css" media="all" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <main>
    <nav class="nav-bar">
     <div class="full-wrap">
      <p class="hiddenNavbar">
        <img src="img/asset/close.png" alt="Hidden Navbar" class="hidden">
      </p>

      <div class="wrapCreateFolder">
        <p class="username"><?= $username;  ?></p>
        <i class="ph ph-folder-plus createdFolder"></i>
      </div>

      <ul class="wrapFolder">
        <?php 
        $sqlFolder = "SELECT * FROM folder WHERE username='$username'";
        $queryFolder = mysqli_query($db,$sqlFolder);
        while($data = mysqli_fetch_array($queryFolder)):
        ?>
        <li>
          <form method="POST">
            <input type="text" class="hidden" name="idFolder" value="<?= $data['id']; ?>" readonly>
            <input type="text" class="hidden" name="usernameFolder" value="<?= htmlspecialchars($data['username']); ?>" readonly>
            <input type="text" class="hidden" name="nameFolder" value="<?= htmlspecialchars($data['name']); ?>" readonly>
            <button type="submit" name="detailFolder" class="nameFolder" formaction="detail_folder.php" style="color: rgb(204, 204, 204);"><?= $data['name']; ?></button>
            <div class="wrapAction">
              <button type="submit" class="editFolder" name="editFolder" formaction="proses_edit_folder.php"><i class="ph ph-pencil"></i></button>
              <button type="submit" class="hapusFolder" name="hapusFolder" formaction="proses_hapus_folder.php"><i class="ph ph-trash"></i></button>
            </div>
          </form>
        </li>
        <?php
        endwhile;
        ?>
      </ul>

      <form action="logout.php" method="GET" class="logoutForm">
        <button type="submit">Logout</button>
      </form>
     </div>
    </nav>
    
    <section class="informationDisplay">
      <div class="wrapHeader">

        <div class="wrap1">
          <h1>Mynotes</h1>
          <img class="profilePicture" src="img/<?= $profilePicture; ?>" data-image="img/<?= $profilePicture; ?>" alt="Profile Picture" loading='lazy'>
          <img src="img/asset/menu.png" alt="toggle" class="toggle" loading='lazy'>
        </div>

        <form action="" method="GET" class="searchData">
          <input type="search" name="searching" placeholder="Search..."/>
          <button type="submit">
            <img src="img/asset/search-interface-symbol.png" alt="Searcing Logo"/>
          </button>
        </form>

      </div>
      <div class="wrapNotesPublish">
        <?php 
        $cekData = false;
        $sqlNotes = "SELECT * FROM notes";
        $queryNotes = mysqli_query($db,$sqlNotes);
        while($data = mysqli_fetch_array($queryNotes)):
        $publish = $data['publish'];
        $id = $data["id"];
        $titleNotes = $data['titleNotes'];
        $descriptionNotes = $data['descriptionNotes'];
        $publish = $data['publish'];
        $idFolder = $data['idFolder'];
        $usernameFolder = $data['usernameFolder'];
        $NameFolder = $data['NameFolder'];
        $created_at = $data['created_at'];
        $image = $data['image'];
        $view = $data['view'];
        ?>
          <?php
          if($publish == "Publis"){
            $cekData = true;
           echo "
           <form action='detail_note_public.php' method='POST' class='notes'>

            <input type='text' class='hidden' name='id' value='$id'>

            <input type='text' class='hidden' name='titleNotes' value='$titleNotes' readonly>

            <input type='text' class='hidden' name='descriptionNotes' value='$descriptionNotes' readonly>

            <input type='text' class='hidden' name='publish' value='$publish' readonly>

            <input type='text' class='hidden' name='idFolder' value='$idFolder'>

            <input type='text' name='usernameFolder' class='hidden' value='$usernameFolder' readonly>

            <input type='text' class='hidden' name='NameFolder' value='$NameFolder'>

            <input type='text' class='hidden' name='created_at' value='$created_at'>

            <input type='text' class='hidden' name='image' value='$image'>

            <input type='text' class='hidden' name='view' value='$view'>

            <button type='submit' name='detailNotes'>
              <p class='username'>$usernameFolder</p>
              <p class='title'>$titleNotes</p>
              <p class='description'>$descriptionNotes</p>
              <p class='date'>$created_at</p>
            </button>
           </form>
           ";
          }       
          ?>
        <?php endwhile; ?>

        <?php if($cekData == false): ?>
          <div class='noNote'>
            <div class='card-information'>
              <img src='img/asset/no-note-2.avif' alt='No Note' loading='lazy'>
              <p class='title'>Tidak ada catatan yang dibagikan secara publik saat ini</p>
              <p class='description'>Periksa kembali nanti untuk pembaruan!</p>
            </div>
          </div>
        <?php endif; ?>

      </div>

    </section>
    
  </main>
  
  <section class="wrapAlertFormAdd">
    <form class="formCreateFolder" method="GET">
      <span class="deleteAlertFolder">
        <img class="delete" src="img/asset/close.png" alt="deleteAlertFolder" />
      </span>
      <h1>Formulir create folder</h1>
      <input type="text" name="nameFolder" placeholder="Nama folder..." required>
      <button type="submit" name="createFolder" class="btn_create">Create</button>
    </form>
  </section>

<script src="src/js/navbarUser.js" type="text/javascript" charset="utf-8"></script>
<script src="src/js/homePage.js" type="text/javascript" charset="utf-8"></script>
<script src="src/js/confirmHapusFolder.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
