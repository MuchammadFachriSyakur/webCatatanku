<?php
session_start();
include('database/config.php');
$username = "anjay";
$usernameFix = "";
$userSession = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];

if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];
 
  $sql = "SELECT username FROM user WHERE id='$id'";
  $result = mysqli_query($db, $sql);

  $data = mysqli_fetch_assoc($result);

  // Cek cookie dan username 
  if ($key === hash('sha256', $data['username'])) {
    $_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7'] = true;
    $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'] = hash('sha256', $data['username']);
    echo "<script>
     window.location.href = 'dashboard_user.php';
    </script>";
  }
}

if(isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7'])){
  $userSession = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];
  $sql = "SELECT * FROM user";
  $query = mysqli_query($db,$sql);

  while($data = mysqli_fetch_array($query)){
    $username = $data['username'];
    $hashUsernameDatabase = hash("sha256",$data['username']);
    if($userSession === $hashUsernameDatabase){
      $usernameFix = $username;
    }
  }
}

if(!isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && !isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7']) ){
  echo "<script>
    window.location.href = 'index.php';
  </script>";
  exit;
}

if(isset($_POST['hapusFolder'])){
  $idFolder = $_POST['idFolder'];
  $usernameFolder = $_POST['usernameFolder'];
  $nameFolder = $_POST['nameFolder'];

  if(!$usernameFix == $usernameFolder){
    echo "<script>
    window.location.href = 'dashboard_user.php';
   </script>";
  }else{
    $sql = "DELETE FROM folder WHERE id='$idFolder'";
    $query = mysqli_query($db,$sql);
    if($query){
     echo "<script>
       alert('Berhasil menghapus folder!!!');
       window.location.href = 'dashboard_user.php';
     </script>";
    }else{
     echo "<script>
       alert('Gagal menghapus folder!!!');
       window.location.href = 'dashboard_user.php';
     </script>";
    }
  }
}else{
 echo "<script>
  window.location.href = 'index.php';
 </script>";
 exit;
}
?>
