const button = document.querySelector("main .nav-bar .wrapFolder li form .wrapAction .hapusFolder");

button.addEventListener("click", (e)=>{
  const konfirmasi = confirm("Apakah anda ingin menghapus folder");
  if(konfirmasi == false){
    e.preventDefault();
  }
});