<?php 
session_start();
include("database/config.php");

if(!isset($_SESSION['username']) && !isset($_SESSION['is_login_user']) ){
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
        <p><?= $_SESSION['username']; ?></p>
        <img src="img/asset/add.png" alt="Created Folder" class="createdFolder">
      </div>
      
      <ul class="wrapFolder">
        <li><a href="#">IPA</a></li>
        <li><a href="#">IPS</a></li>
        <li><a href="#">MTK</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
        <li><a href="#">B.INDONESIA</a></li>
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

<script src="src/js/navbarUser.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
