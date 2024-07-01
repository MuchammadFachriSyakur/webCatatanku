<?php
session_start();
include("database/config.php");
$usernameFolder = "";
$username = "";
$image = "";

if(!isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && !isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7']) ){
  echo "<script>
   window.location.href = 'dashboard_user.php';
  </script>";
  exit;
}

if(isset($_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2']) && isset($_SESSION['ee49dcf234054d9329748e09f2cd9d29e20f7a000a533812653f9e552ce67dd7'])){
  $userSession = $_SESSION['f32bee31be074f58db022158fb7f400bfa8b321f0012c9e50346e8bc230d5cb2'];
  $sql = "SELECT * FROM user";
  $query = mysqli_query($db,$sql);

  while($data = mysqli_fetch_array($query)){
    $hashUsernameDatabase = hash("sha256",$data['username']);
    if($userSession === $hashUsernameDatabase){
      $username = $data['username'];
    }
  }
}

if(isset($_POST['editNote'])){
  $id = $_POST['id'];
  $titleNotes = htmlspecialchars($_POST['titleNotes']);
  $descriptionNotes = htmlspecialchars($_POST['descriptionNotes']);
  $publish = htmlspecialchars($_POST['publish']);
  $idFolder = $_POST['idFolder'];
  $usernameFolder = htmlspecialchars($_POST['usernameFolder']);
  $NameFolder = htmlspecialchars($_POST['NameFolder']);
  $image = htmlspecialchars($_POST['image']);
  $createdAt = htmlspecialchars($_POST['created_at']);
}

if(isset($_POST['editNotes'])){
  $id = $_POST['id'];
  $titleNotes = htmlspecialchars($_POST['titleNotes']);
  $descriptionNotes = $_POST['descriptionNotes'];
  $saveString = nl2br(str_replace(" ", " &nbsp;",$descriptionNotes));
  $idFolder = htmlspecialchars($_POST['idFolder']);
  $NameFolder = htmlspecialchars($_POST['NameFolder']);
  $username = htmlspecialchars($_POST['username']);
  $publish = htmlspecialchars($_POST['publish']);
  $gambarSebelumnya = htmlspecialchars($_POST['image']);
  
  $nameFile = $_FILES['background_notes']['name'];
  $sizeFile = $_FILES['background_notes']['size'];
  $errorFile = $_FILES['background_notes']['error'];
  $tmpNameFile = $_FILES['background_notes']['tmp_name'];
  $viewDefault = 0;

  if(file_exists($tmpNameFile) || is_uploaded_file($tmpNameFile)){
    $ektensiGambarValid = ['jpg','jpeg','png'];
    $ektensiGambar = explode('.',$nameFile);
    $ektensiGambar = strtolower(end($ektensiGambar));

    if(!in_array($ektensiGambar,$ektensiGambarValid)){
      echo "<script>
      alert('Silahkan upload file yang memiliki ekstensi jpeg,jpg dan png');
      window.location.href = 'dashboard_user.php';
      </script>";
      exit;
    }

    if($sizeFile > 1000000){
      echo "<script>
        alert('Ukuran gambar telalu besar');
        window.location.href = 'dashboard_user.php';
      </script>";
      exit;
    }

    $newNameFile = uniqid();
    $newNameFile .= '.';
    $newNameFile .= $ektensiGambar;

    if($publish == "Private"){
        $sql = "UPDATE notes SET titleNotes='$titleNotes',descriptionNotes='$saveString',publish='$publish',view='$viewDefault',image='$newNameFile' WHERE id='$id'";
        $query = mysqli_query($db,$sql);

        if($query){
            unlink('img/' . $gambarSebelumnya);
            move_uploaded_file($tmpNameFile, 'img/' . $newNameFile);
            echo "<script>
              alert('Data berhasil diupdate');
              window.location.href = 'dashboard_user.php';
            </script>";
            exit;
        }else{
            echo "<script>
              alert('Data gagal diupdate');
              window.location.href = 'dashboard_user.php';
            </script>";
            exit;
        }
    }else{
      $sql = "UPDATE notes SET titleNotes='$titleNotes',descriptionNotes='$saveString',publish='$publish',view='$viewDefault',image='$newNameFile' WHERE id='$id'";
      $query = mysqli_query($db,$sql);

      if($query){
          unlink('img/' . $gambarSebelumnya);
          move_uploaded_file($tmpNameFile, 'img/' . $newNameFile);
          echo "<script>
            alert('Data berhasil diupdate dan akan menghapus file');
            window.location.href = 'dashboard_user.php';
          </script>";
          exit;
      }else{
          echo "<script>
            alert('Data gagal diupdate');
            window.location.href = 'dashboard_user.php';
          </script>";
          exit;
      }
    }

  }else{
    if($publish == "Private"){
        $sql = "UPDATE notes SET titleNotes='$titleNotes',descriptionNotes='$saveString',publish='$publish',view='$viewDefault' WHERE id='$id'";
        $query = mysqli_query($db,$sql);

        if($query){
            echo "<script>
              alert('Data berhasil diupdate');
              window.location.href = 'dashboard_user.php';
            </script>";
            exit;
        }else{
            echo "<script>
              alert('Data gagal diupdate');
              window.location.href = 'dashboard_user.php';
            </script>";
            exit;
        }
    }else{
        $sql = "UPDATE notes SET titleNotes='$titleNotes',descriptionNotes='$saveString',publish='$publish' WHERE id='$id'";
        $query = mysqli_query($db,$sql);

        if($query){
            echo "<script>
              alert('Data berhasil diupdate');
              window.location.href = 'dashboard_user.php';
            </script>";
            exit;
        }else{
            echo "<script>
              alert('Data gagal diupdate');
              window.location.href = 'dashboard_user.php';
            </script>";
            exit;
        }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>My Notes || Form edit notes</title>
  <link rel="stylesheet" href="src/css/form_add_notes.css" type="text/css" media="all" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="img/asset/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/asset/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/asset/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="img/asset/favicon_io/site.webmanifest">
</head>
<body>
  <form class="form_add_notes" method="POST" enctype="multipart/form-data">
   <?php if($usernameFolder == $username): ?> 
    <h1 class="title">Formulir edit catatan</h1>

    <input type="text" class="hidden" name="id" value="<?= $id; ?>" readonly required>

    <input type="text" name="titleNotes" value="<?= $titleNotes; ?>" required>

    <textarea class="descriptionNotesAreas" name="descriptionNotes" value="<?= $descriptoSaveString; ?>" required><?= $descriptionNotes; ?></textarea>

    <!-- <input type="text" name="descriptionNotes" value="" required> -->

    <input type="text" class="hidden" name="idFolder" value="<?= $idFolder; ?>" readonly required>

    <input type="text" name="NameFolder" class="hidden" value="<?= $NameFolder; ?>" readonly required>

    <input type="text" name="username" value="<?= $usernameFolder; ?>" readonly required>

    <input type="text" name="created_at" class="hidden" value="<?= $createdAt; ?>" required readonly>
    
    <input type="text" name="image" class="hidden" value="<?= $image; ?>" required readonly>

    <input type="image" src="img/<?= $image; ?>" alt="Background Notes">

    <input type="file" name="background_notes" placeholder="Silahkan masukan gambar yang kamu sukai" required readonly>

    <select name="publish" required>
      <option value="">Silahkan pilih publish atau private</option>
      <option value="Private"
       <?php
        if($publish == "Private"){
         echo "selected";
        }
       ?>>Private</option>
      <option value="Publis" <?php
        if($publish == "Publis"){
         echo "selected";
        }
       ?>>Publis</option>
    </select>

    <a href="detail_folder.php">Kembali</a>

    <button type="submit" name="editNotes">Edit</button>
   <?php endif; ?>
  </form>
</body>
</html>
