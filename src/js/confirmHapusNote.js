const btn_delete = document.querySelector("form .hapus");

btn_delete.addEventListener("click", (e)=>{
   const konfirmasi = confirm("Apakah anda ingin menghapus folder");
   if(konfirmasi == false){
    e.preventDefault();
   }
});