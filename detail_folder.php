<?php 
session_start();
include("database/config.php");
$username = $_SESSION['username'];
$idFolder = 0;
$usernameFolder = "";
$namaFolder = "";
$idFolderValid = 0;

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(isset($_POST['detailFolder'])){
  $idFolder = $_POST['idFolder'];
  $usernameFolder = htmlspecialchars($_POST['usernameFolder']);
  $namaFolder = htmlspecialchars($_POST['nameFolder']);
}

if($usernameFolder == "" & $namaFolder == "" & $idFolder == 0){
  echo "<script>
    window.location.href = 'dashboard_user.php';
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
      window.location.href = 'detail_folder.php';
    </script>";
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
  <link rel="stylesheet" href="src/css/detail_folder.css" type="text/css" media="all" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <main>
    <nav class="nav-bar">
      <p class="hiddenNavbar">
        <img src="img/asset/close.png" alt="Hidden Navbar" class="hidden">
      </p>
      
      <div class="wrapCreateFolder">
        <p class="username"><?= $username;  ?></p>
        <img src="img/asset/add.png" alt="Created Folder" class="createdFolder">
      </div>
      
      <ul class="wrapFolder">
        <li>
          <a href="dashboard_user.php">All</a>
        </li>
        <?php 
        $sqlFolder = "SELECT * FROM folder WHERE username='$username'";
        $queryFolder = mysqli_query($db,$sqlFolder);
        while($data = mysqli_fetch_array($queryFolder)):
        ?>
        <?php 
        if($idFolder == $data['id']): 
        $idFolderValid = $data['id'];
        ?>
         <li class="FolderValid">
          <form method="POST">
            <input type="text" class="hidden" name="idFolder" value="<?= $data['id']; ?>" readonly>
            <input type="text" class="hidden" name="usernameFolder" value="<?= $data['username']; ?>" readonly>
            <input type="text" class="hidden" name="nameFolder" value="<?= $data['name']; ?>" readonly>
            <button type="submit" name="detailFolder" class="nameFolder" formaction="detail_folder.php"><?= $data['name']; ?></button>
            <div class="wrapAction">
              <button type="submit" class="editFolder" name="editFolder" formaction="proses_edit_folder.php"><i class="ph ph-pencil"></i></button>
              <button type="submit" class="hapusFolder" name="hapusFolder" formaction="proses_hapus_folder.php"><i class="ph ph-trash"></i></button>
            </div>
          </form>
         </li>
        <?php endif; ?>
        <?php
        endwhile;
        ?>
        
        <?php 
        $sqlFolder2 = "SELECT * FROM folder WHERE username='$username' AND id <> $idFolderValid";
        $queryFolder2 = mysqli_query($db,$sqlFolder2);
        while($data = mysqli_fetch_array($queryFolder2)):
        ?>
        <li class="folderInvalid">
          <form method="POST">
            <input type="text" class="hidden" name="idFolder" value="<?= $data['id']; ?>" readonly>
            <input type="text" class="hidden" name="usernameFolder" value="<?= $data['username']; ?>" readonly>
            <input type="text" class="hidden" name="nameFolder" value="<?= $data['name']; ?>" readonly>
            <button type="submit" name="detailFolder" class="nameFolder" formaction="detail_folder.php"><?= $data['name']; ?></button>
            <div class="wrapAction">
              <button type="submit" class="editFolder" name="editFolder" formaction="proses_edit_folder.php"><i class="ph ph-pencil"></i></button>
              <button type="submit" class="hapusFolder" name="hapusFolder" formaction="proses_hapus_folder.php"><i class="ph ph-trash"></i></button>
            </div>
          </form>
        </li>
        <?php endwhile; ?>
      </ul>
      
      <form action="logout.php" method="GET" class="logoutForm">
        <button type="submit">Logout</button>
      </form>
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
        $sql = "SELECT * FROM notes WHERE usernameFolder='$username'";
        $query = mysqli_query($db,$sql);
        while($data = mysqli_fetch_array($query)):
        ?>
         <?php if($namaFolder == $data['NameFolder']): ?>
          <form action="detail_note.php" method="POST" class="notes">

            <input type="text" class="hidden" name="id" value="<?= $data['id']; ?>">

            <input type="text" class="hidden" name="titleNotes" value="<?= $data['titleNotes']; ?>" readonly>

            <input type="text" class="hidden" name="descriptionNotes" value="<?= $data['descriptionNotes']; ?>" readonly>

            <input type="text" class="hidden" name="publish" value="<?= $data['publish']; ?>" readonly>

            <input type="text" class="hidden" name="idFolder" value="<?= $data['idFolder']; ?>">

            <input type="text" class="hidden" name="usernameFolder" value="<?= $data['usernameFolder']; ?>">

            <input type="text" class="hidden" name="NameFolder" value="<?= $data['NameFolder']; ?>">

            <input type="text" class="hidden" name="created_at" value="<?= $data['created_at']; ?>">

            <input type="text" class="hidden" name="image" value="<?= $data['image']; ?>">

            <button type="submit" name="detailNotes">
              <p class="title"><?= $data['titleNotes']; ?></p>
              <p class="description"><?= $data['descriptionNotes']; ?></p>
              <p class="date"><?= $data['created_at']; ?></p>
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
      <input type="text" name="nameFolder" placeholder="Nama folder..." required>
      <button type="submit" name="createFolder" class="btn_create">Create</button>
    </form>
  </section>

<script src="src/js/navbarUser.js" type="text/javascript" charset="utf-8"></script>
<script src="src/js/homePage.js" type="text/javascript" charset="utf-8"></script>
<script src="src/js/confirmHapusFolder.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
