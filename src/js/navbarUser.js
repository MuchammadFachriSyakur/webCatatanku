const toggleShow = document.querySelector("main .informationDisplay .wrapHeader .toggle");
const toggleHidden = document.querySelector("main .nav-bar .hiddenNavbar .hidden");
const navbar = document.querySelector("main .nav-bar");

toggleShow.addEventListener("click", (e) =>{
  navbar.classList.toggle('show');
});

toggleHidden.addEventListener("click", (e)=>{
  navbar.classList.toggle('show');
});
