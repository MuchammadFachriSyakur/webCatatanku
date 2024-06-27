const button = document.querySelectorAll("main .nav-bar .wrapFolder li form .wrapAction .hapusFolder");

button.forEach((e)=>{
 e.addEventListener("click" , (e)=>{
  const konfirmasi = confirm("Apakah anda ingin menghapus folder");
  if(konfirmasi == false){
    e.preventDefault();
  }
 })
});
