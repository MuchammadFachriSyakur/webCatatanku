<?php
include('database/config.php');
if(isset($_POST['hapusFolder'])){
  $idFolder = $_POST['idFolder'];
  $usernameFolder = $_POST['usernameFolder'];
  $nameFolder = $_POST['nameFolder'];
  
  echo $idFolder;
  echo $usernameFolder;
  echo $nameFolder;
  
  $sql = "DELETE FROM folder WHERE id='$idFolder'";
  $query = mysqli_query($db,$sql);
  if($query){
    echo "<script>
    alert('Berhasil menghapus folder!!!');
   </script>";
  }else{
    echo "<script>
    alert('Gagal menghapus folder!!!');
   </script>";
  }
  echo "<script>
    window.location.href = 'dashboard_user.php';
   </script>";
}
echo "<script>
 window.location.href = 'index.php';
</script>";
exit;
?>