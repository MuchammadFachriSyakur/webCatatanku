const toggleShow = document.querySelector("main .informationDisplay .toggle");
const toggleHidden = document.querySelector("main .nav-bar .hiddenNavbar");
const navbar = document.querySelector("main .nav-bar");

toggleShow.addEventListener("click", (e) =>{
  navbar.classList.toggle('show');
});

toggleHidden.addEventListener("click", (e)=>{
  navbar.classList.toggle('show');
});