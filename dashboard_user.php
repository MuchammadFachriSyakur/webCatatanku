<?php 
session_start();
include("database/config.php");
$username = $_SESSION['username'];

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Welcome to mynotes</title>
  <link rel="stylesheet" href="src/css/defaultHomePage.css" type="text/css" media="all" />
</head>
<body>
  <main>
    <nav class="nav-bar">
      <p class="hiddenNavbar">
        <img src="img/asset/close.png" alt="Hidden Navbar" class="hidden">
      </p>
      
      <div class="wrapCreateFolder">
        <p>Username</p>
        <img src="img/asset/add.png" alt="Created Folder" class="createdFolder">
      </div>
      
      <ul class="wrapFolder">
        <?php 
        $sqlFolder = "SELECT * FROM folder WHERE username='$username'";
        $queryFolder = mysqli_query($db,$sqlFolder);
        while($data = mysqli_fetch_array($queryFolder)):
        ?>
        <li>
          <a href="#"><?= $data['name']; ?></a>
        </li>
        <?php
        endwhile;
        ?>
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
</body>
</html>
