const buttonShowAddFolder = document.querySelector("main .nav-bar .wrapCreateFolder .createdFolder");
const buttonHiddenAddFolder = document.querySelector(".wrapAlertFormAdd .formCreateFolder .deleteAlertFolder .delete");
const alertForm = document.querySelector(".wrapAlertFormAdd");
const profilePicture = document.querySelector("main .informationDisplay .wrapHeader .wrap1 .profilePicture");

buttonShowAddFolder.addEventListener("click", (e) =>{
  alertForm.classList.toggle("show");
});

buttonHiddenAddFolder.addEventListener("click", e =>{
  alertForm.classList.toggle("show");
});

profilePicture.addEventListener("click", (e)=>{
 const nameImage = e.target.getAttribute("data-image");
 const popup = document.createElement('div');
 popup.className = 'modalProfileImage';
 popup.innerHTML = `
  <section class="modalProfileImage">
    <span class="closeModal" onclick="closeModal()"><i class="ph ph-x"></i></span>
    <div class="wrapImage">
     <img src="${nameImage}" alt="Profile Picture">
    </div>
  </section>
 `;
 document.body.appendChild(popup);
});

function closeModal(){
  const popup = document.querySelector(".modalProfileImage");
  document.body.removeChild(popup);
}
