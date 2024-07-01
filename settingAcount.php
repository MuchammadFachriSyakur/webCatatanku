<?php
session_start();
include("database/config.php");
$usernameCookie = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];
$idUsername = "";
$username = "";
$usernameOne = "";
$password = "";
$passwordOne = "";
$email = "";
$image = "";

//Contoh penggunaan ternary operator;
$result = 15 > 14 ? "15 tidak lebih besar dari 14" : "15 tidak lebih besar dari 14";

if(!isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && !isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7']) ){
    echo "<script>
      window.location.href = 'index.php';
    </script>";
    exit;
  }

if(isset($_POST['settingAcount'])){
  $username = $_POST['username'];
  $sql = "SELECT * FROM user WHERE username='$username'";
  $query = mysqli_query($db,$sql);
  
  if(mysqli_num_rows($query) > 0){
    $data = mysqli_fetch_array($query);
    $idUsername = $data['id'];
    $username = $data['username'];
    $usernameOne = $data['username'];
    $passwordOne = $data['password'];
    $password = $data['password'];
    $email = $data['email'];
    $image = $data['image'];
  }else{
    echo "<script>
      window.location.href = 'index.php';
    </script>";
  }
}

if(isset($_POST['editAccount'])){
 $id = $_POST['idUsername'];
 $usernameEdit = htmlspecialchars($_POST['username']);
 $usernameOne = htmlspecialchars($_POST['usernameOne']);
 $password = htmlspecialchars($_POST['password']);
 $passwordOne = htmlspecialchars($_POST['passwordOne']);
 $email = htmlspecialchars($_POST['email']);

 $hashPassword = hash("sha256",$password);
 $previousImage = htmlspecialchars($_POST['previousImage']);

 $image_name = $_FILES['image']['name'];
 $image_error = $_FILES['image']['error'];
 $image_size = $_FILES['image']['size'];
 $image_tmp_name = $_FILES['image']['tmp_name'];
 $extentionImageValid = ['jpg','jpeg','png'];

 $noSpaceUsername = str_replace(' ','',$usernameEdit);
 $noSpacePassword = str_replace(' ','',$password);
 $validationNumberUsername = preg_match("/\d/",$usernameEdit);
 $validationEmailUsername = filter_var($email,FILTER_VALIDATE_EMAIL);

 $sql = "SELECT * FROM user WHERE username='$usernameEdit'";
 $query = mysqli_query($db,$sql);
 $cekHasilQuery = mysqli_num_rows($query);

 
 if(strlen($usernameEdit) < 6){
    echo "Username kurang dari 6 digit";
 }elseif(strlen($usernameEdit) > strlen($noSpaceUsername)){
    echo "Pastikan usename yang anda masukan tidak mengandung spasi";
 }elseif(strlen($password) < 6){
    echo "Passowrd kurang dari 6 digit";
 }elseif(strlen($password) > strlen($noSpacePassword)){
    echo "Pastikan password yang anda masukan tidak mengandung spasi";
 }elseif($validationEmailUsername == false){
    echo "Kamu harus memasukan alamat email yang benar";
 }elseif(!$validationNumberUsername){
    echo "Pastikan username berisi setidaknya 1 angka";
 }elseif($usernameOne == $usernameEdit){
    //Tinggal melanjutkan sql atau mengganti yang lainnya
    if($image_error === 4){
        if($password == $passwordOne){
            $sql = "UPDATE user SET email='$email' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);
            
            $resultQuery = $query ? "<script>alert('Berhasil pada password yang sama dan username sama......'); window.location.href = 'index.php';</script>" : "<script>alert('Gagal pada password yang sama'); window.location.href = 'index.php';</script>";
            echo $resultQuery;
        }else{
           $sql = "UPDATE user SET password='$hashPassword',email='$email' WHERE   username='$usernameOne'";
           $query = mysqli_query($db,$sql);

           $resultQuery = $query ? "<script>alert('Berhasil pada password yang berbeda'); window.location.href = 'index.php';</script>" : "<script>alert('Gagal pada password yang berbeda'); window.location.href = 'index.php';</script>";
           echo $resultQuery;
        }
    }elseif($image_error === 0){
      $extentionImage = explode('.',$image_name);
      $extentionImage = strtolower(end($extentionImage));

      $newNameFile = uniqid();
      $newNameFile .= '.';
      $newNameFile .= $extentionImage;

      if(!in_array($extentionImage,$extentionImageValid)){
         echo "<script>alert('Jangan masukan gambar selain jpg,jpeg dan png!!!'); window.location.href = 'index.php';</script>";
      }elseif($image_size > 1000000){
         echo "<script>alert('Pastikan gambar tidak melebihi 1mb!!!'); window.location.href = 'index.php';</script>";
      }else{
         if($password == $passwordOne){
            $sql = "UPDATE user SET username='$usernameEdit',email='$email',image='$newNameFile' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);

            if($query){
               unlink('img/' . $previousImage);
               move_uploaded_file($image_tmp_name,'img/' . $newNameFile);
               echo "<script>alert('Berhasil pada password yang sama');</>";
            }else{
               echo "<script>alert('Gagal pada password yang sama'); window.location.href = 'index.php';</script>";
            }
          }else{
            echo "Password beda";
            $sql = "UPDATE user SET username='$usernameEdit',password='$hashPassword',email='$email' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);

            $resultQuery = $query ? "<script>alert('Berhasil pada password yang berbeda'); window.location.href = 'index.php';</script>" : "<script>alert('Gagal pada password yang berbeda'); window.location.href = 'index.php';</script>";
            echo $resultQuery;
          }
      }
    }
 }else{
    if($image_error == 4 ){
        if($cekHasilQuery == 1){
            echo "<script>alert('Nama pengguna tersebut sudah dipakai oleh pengguna lain.Silahkan pilih yang lain.'); window.location.href = 'index.php';</script>";
        }else{
          if($password == $passwordOne){
            $sql = "UPDATE user SET username='$usernameEdit',email='$email' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);

            $resultQuery = $query ? "<script>alert('Berhasil pada password yang sama'); window.location.href = 'dashboard_user.php';</script>" : "<script>alert('Gagal pada password yang sama'); window.location.href = 'dashboard_user.php';</script>";
            echo $resultQuery;
          }else{
            $sql = "UPDATE user SET username='$usernameEdit',password='$hashPassword',email='$email' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);

            $resultQuery = $query ? "<script>alert('Berhasil pada password yang berbeda'); window.location.href = 'dashboard_user.php';</script>" : "<script>alert('Gagal pada password yang berbeda'); window.location.href = 'dashboard_user.php';</script>";
            echo $resultQuery;
          }
        }
    }elseif($image_error === 0){
      $extentionImage = explode('.',$image_name);
      $extentionImage = strtolower(end($extentionImage));

      $newNameFile = uniqid();
      $newNameFile .= '.';
      $newNameFile .= $extentionImage;

      if($cekHasilQuery == 1){
         echo "Username sudah ada";
         exit;
      }elseif(!in_array($extentionImage,$extentionImageValid)){
         echo "<script>alert('Jangan masukan gambar selain jpg,jpeg dan png!!!'); window.location.href = 'index.php';</script>";
      }elseif($image_size > 1000000){
         echo "<script>alert('Pastikan gambar tidak melebihi 1mb!!!'); window.location.href = 'index.php';</script>";
      }else{
         if($password == $passwordOne){
            echo "Gambar didatabase " . $previousImage;
            $sql = "UPDATE user SET username='$usernameEdit',email='$email',image='$newNameFile' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);

            if($query){
               unlink('img/' . $previousImage);
               move_uploaded_file($image_tmp_name,'img/' . $newNameFile);
               echo "<script>alert('Berhasil pada password yang sama');</>";
            }else{
               echo "<script>alert('Gagal pada password yang sama'); window.location.href = 'index.php';</script>";
            }
          }else{
            echo "Password beda";
            $sql = "UPDATE user SET username='$usernameEdit',password='$hashPassword',email='$email' WHERE username='$usernameOne'";
            $query = mysqli_query($db,$sql);

            $resultQuery = $query ? "<script>alert('Berhasil pada password yang berbeda'); window.location.href = 'index.php';</script>" : "<script>alert('Gagal pada password yang berbeda'); window.location.href = 'index.php';</script>";
            echo $resultQuery;
          }
      }
    }
 }
}

if(!$usernameOne == $usernameCookie){
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
    <title>My Notes || Setting Acount</title>
    <link rel="stylesheet" href="src/css/setting_acount.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet" />
    <link rel="apple-touch-icon" sizes="180x180" href="img/asset/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/asset/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/asset/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="img/asset/favicon_io/site.webmanifest">
</head>
<body>
<header>
      <a href="">Kembali</a>
   </header>
   <main>
   <h1 class="title">Formulir Setting Acount</h1>
    <form class="formSettingAcount" method="POST" enctype="multipart/form-data">
      <label for="idUsername" class="hidden">
         Id username :
         <input type="text" name="idUsername" value="<?= $idUsername; ?>">
      </label>

      <label for="username" >
         Username :
         <input type="text" name="username" value="<?= $username; ?>">
      </label>

      <label for="usernameOne" class="hidden">
         Username Awal :
         <input type="text" name="usernameOne" value="<?= $usernameOne; ?>">
      </label>

      <label for="password">
         Password :
         <input type="text" name="password" value="<?= $password; ?>">
      </label>

      <label for="passwordOne" class="hidden">
         Password awal :
         <input type="text" name="passwordOne" value="<?= $passwordOne; ?>">
      </label>

      <label for="idUsername">
         Email :
         <input type="text" name="email" value="<?= $email; ?>">
      </label>

      <label for="idUsername">
         Gambar Sebelumnya :
         <input type="image" src="img/<?= $image; ?>" alt="Profile Picture">
      </label>

      <label for="previousImage" class="hidden">
         Gambar Sebelumnya :
         <input type="text" name="previousImage" value="<?= $image; ?>">
      </label>

      <label for="image">
         Gambar baru :
         <input type="file" name="image" value="<?= $image; ?>">
      </label>

      <button type="submit" name="editAccount" formaction="">Edit</button>
    </form>
   </main>
</body>
</html>
