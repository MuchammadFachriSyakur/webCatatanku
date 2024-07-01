<?php 
session_start();
include("database/config.php");
$username = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];
$idFolder = 0;
$idUsername = "";
$usernameFolder = "";
$namaFolder = "";
$idFolderValid = 0;

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
    $hashUsernameDatabase = hash("sha256",$data['username']);
    if($username === $hashUsernameDatabase){
      $username = $data['username'];
    }
  }
}

if(isset($_POST['detailFolder'])){
  $idFolder = $_POST['idFolder'];
  $usernameFolder = htmlspecialchars($_POST['usernameFolder']);
  $idUsername = $_POST['idUsername'];
  $namaFolder = htmlspecialchars($_POST['nameFolder']);
}

if(isset($_GET['createFolder'])){
  $nameFolder = htmlspecialchars($_GET['nameFolder']);
  $idUsernameForm = $_GET['idUsername'];
  $sql = "INSERT INTO folder (idUsername,name) VALUES ('$idUsernameForm','$nameFolder')";
  $query = mysqli_query($db,$sql);
  
  if($query){
    echo "<script>
      alert('Data berhasil ditambahkan');
    </script>";
  }
}

if($usernameFolder == "" & $namaFolder == "" & $idFolder == 0){
  echo "<script>
    window.location.href = 'dashboard_user.php';
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
  <title>My Notes || Details Folder</title>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="stylesheet" href="src/css/detail_folder.css" type="text/css" media="all" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="img/asset/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/asset/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/asset/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="img/asset/favicon_io/site.webmanifest">
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
        <li class="backed">
          <a href="dashboard_user.php" class="back"><i class="ph ph-house"></i> Dashboard</a>
        </li>
        <?php 
        $sqlFolder = "SELECT * FROM folder WHERE idUsername='$idUsername'";
        $queryFolder = mysqli_query($db,$sqlFolder);
        while($data = mysqli_fetch_array($queryFolder)):
        ?>
        <?php 
        if($idFolder == $data['id']): 
        $idFolderValid = $data['id'];
        $idUsername = htmlspecialchars($data['idUsername']);
        $nameDatabase1Folder = htmlspecialchars($data['name']);
        ?>
         <li class="FolderValid">
          <form method="POST">
            <input type="text" class="hidden" name="idFolder" value="<?= $idFolderValid; ?>" readonly>
            <input type="text" class="hidden" name="usernameFolder" value="<?= $usernameFolder; ?>" readonly>
            <input type="text" class="hidden" name="idUsername" value="<?= $idUsername; ?>" readonly>
            <input type="text" class="hidden" name="nameFolder" value="<?= $nameDatabase1Folder; ?>" readonly>
            <button type="submit" name="detailFolder" class="namesFolder" formaction="detail_folder.php"><?= $nameDatabase1Folder; ?></button>
            <div class="wrapAction">
              <button type="submit" class="editFolder" name="editFolder" formaction="proses_edit_folder.php" style="color: black;"><i class="ph ph-pencil"></i></button>
              <button type="submit" class="hapusFolder" name="hapusFolder" formaction="proses_hapus_folder.php" style="color: black;"><i class="ph ph-trash"></i></button>
            </div>
          </form>
         </li>
        <?php endif; ?>
        <?php
        endwhile;
        ?>
        
        <?php 
        $sqlFolder2 = "SELECT * FROM folder WHERE idUsername='$idUsername' AND id <> $idFolderValid";
        $queryFolder2 = mysqli_query($db,$sqlFolder2);
        while($data = mysqli_fetch_array($queryFolder2)):
          $idUsername = $data['idUsername'];
          $nameDatabase2Folder = htmlspecialchars($data['name']);
        ?>
        <li class="folderInvalid">
          <form method="POST">
            <input type="text" class="hidden" name="idFolder" value="<?= $data['id']; ?>" readonly>
            <input type="text" class="hidden" name="usernameFolder" value="<?= $usernameFolder; ?>" readonly>
            <input type="text" class="hidden" name="idUsername" value="<?= $idUsername; ?>" readonly>
            <input type="text" class="hidden" name="nameFolder" value="<?= $nameDatabase2Folder; ?>" readonly>
            <button type="submit" name="detailFolder" class="nameFolder" formaction="detail_folder.php"><?= $nameDatabase2Folder; ?></button>
            <div class="wrapAction">
              <button type="submit" class="editFolder" name="editFolder" formaction="proses_edit_folder.php" style="color: white;"><i class="ph ph-pencil"></i></button>
              <button type="submit" class="hapusFolder" name="hapusFolder" formaction="proses_hapus_folder.php" style="color: white;"><i class="ph ph-trash"></i></button>
            </div>
          </form>
        </li>
        <?php endwhile; ?>
      </ul>
      
      <form action="logout.php" method="GET" class="logoutForm">
        <button type="submit"><i class="ph ph-sign-out"></i> Logout</button>
      </form>

      <form method="POST" class="settingAcount">
        <input type="text" class="hidden" name="username" value="<?= htmlspecialchars($username); ?>" required readonly>
        <button type="submit" name="settingAcount" formaction="settingAcount.php"><i class="ph ph-gear-six"></i> Setelan</button>
      </form>
     </div>
    </nav>
    
    <section class="informationDisplay">
      <div class="wrapHeader">
        <div class="wrap1">
          <h1>Mynotes</h1>
          <img src="img/asset/menu.png" alt="toggle" class="toggle">
        </div>
        <form action="" method="GET" class="searchData">
          <input type="search" name="searching" placeholder="Search..."/>
          <button type="submit">
            <img src="img/asset/search-interface-symbol.png" alt="Searcing Logo"/>
          </button>
        </form>
      </div>
      <form class="addNote" method="POST">
          <input type="text" class="hidden" name="idFolder" value="<?= $idFolderValid; ?>" >
          <input type="text" class="hidden" name="namesFolder" value="<?= $namaFolder; ?>" />
          <input type="text" class="hidden" name="usernameToAddFolder" value="<?= $usernameFolder; ?>">
          <button type="submit" name="addNote" formaction="form_add_note.php">Tambah Catatan</button>
        </form>
      <div class="wrapNote">
        <?php
        $sql = "SELECT * FROM notes WHERE idUsername='$idUsername'";
        $query = mysqli_query($db,$sql);
        while($data = mysqli_fetch_array($query)):
        ?>
         <?php if($idFolder == $data['idFolder']): 
          $idUsername = $data['idUsername'];
          ?>
          <form action="detail_note.php" method="POST" class="notes">

            <input type="text" class="hidden" name="id" value="<?= $data['id']; ?>">

            <input type="text" class="hidden" name="titleNotes" value="<?= htmlspecialchars($data['titleNotes']); ?>" readonly>

            <input type="text" class="hidden" name="descriptionNotes" value="<?= $data['descriptionNotes'];?>" readonly>

            <input type="text" class="hidden" name="publish" value="<?= htmlspecialchars($data['publish']); ?>" readonly>

            <input type="text" class="hidden" name="idFolder" value="<?= $data['idFolder']; ?>">

            <?php 
             $sqlUser = "SELECT * FROM user WHERE id='$idUsername'";
             $queryUser = mysqli_query($db,$sqlUser);

             $dataUser = mysqli_fetch_array($queryUser);
            ?> 
            <input type="text" class="hidden" name="usernameFolder" value="<?= $dataUser['username']; ?>">

            <input type="text" class="hidden" name="NameFolder" value="<?= htmlspecialchars($data['NameFolder']); ?>">

            <input type="text" class="hidden" name="created_at" value="<?= htmlspecialchars($data['created_at']); ?>">

            <input type="text" class="hidden" name="image" value="<?= htmlspecialchars($data['image']); ?>">

            <button type="submit" name="detailNotes">
              <p class="title"><?= htmlspecialchars($data['titleNotes']); ?></p>
              <p class="description"><?= $data['descriptionNotes']; ?></p>
              <p class="date"><?= htmlspecialchars($data['created_at']); ?></p>
            </button>
          </form>
         <?php endif; ?>
        <?php endwhile; ?>
      </div>
    </section>
    
  </main>
  
  <section class="wrapAlertFormAdd">
    <form class="formCreateFolder" method="GET">
      <span class="deleteAlertFolder">
        <img class="delete" src="img/asset/close.png" alt="deleteAlertFolder" />
      </span>
      <h1>Formulir create folder</h1>
      <input type="text" name="idUsername" value="<?= $idUsername; ?>" style="display:none;">
      <input type="text" name="nameFolder" placeholder="Nama folder..." required>
      <button type="submit" name="createFolder" class="btn_create">Create</button>
    </form>
  </section>

<script src="src/js/navbarUser.js" type="text/javascript" charset="utf-8"></script>
<script src="src/js/homePage.js" type="text/javascript" charset="utf-8"></script>
<script src="src/js/confirmHapusFolder.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
