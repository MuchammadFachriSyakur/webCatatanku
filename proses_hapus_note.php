<?php
include("database/config.php");

if(isset($_POST['hapusNote'])){
    $id = $_POST['id'];
    $image = htmlspecialchars($_POST['image']);

    $sql = "DELETE FROM notes WHERE id='$id'";
    $query = mysqli_query($db,$sql);
    
    if($query){
      unlink("img/$image");
      echo "<script>
        alert('Catatan berhasil dihapus');
        window.location.href = 'dashboard_user.php';
      </script>";
    }else{
      echo "<script>
        alert('Catatan gagal dihapus');
        window.location.href = 'dashboard_user.php';
      </script>";
    }
    exit;
}else{
  echo "<script>
    window.location.href = 'index.php';
  </script>";
}
?>