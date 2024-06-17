const buttonShowAddFolder = document.querySelector("main .nav-bar .wrapCreateFolder .createdFolder");
const buttonHiddenAddFolder = document.querySelector(".wrapAlertFormAdd .formCreateFolder .deleteAlertFolder .delete");
const alertForm = document.querySelector(".wrapAlertFormAdd");

buttonShowAddFolder.addEventListener("click", (e) =>{
  alertForm.classList.toggle("show");
});

buttonHiddenAddFolder.addEventListener("click", e =>{
  alertForm.classList.toggle("show");
});