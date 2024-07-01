const buttonShowAddFolder = document.querySelector("main .nav-bar .wrapCreateFolder .createdFolder");
const buttonHiddenAddFolder = document.querySelector(".wrapAlertFormAdd .formCreateFolder .deleteAlertFolder .delete");
const alertForm = document.querySelector(".wrapAlertFormAdd");
const profilePicture = document.querySelector("main .informationDisplay .wrapHeader .wrap1 .profilePicture");
const searchingNotes = document.querySelector("main .informationDisplay .wrapHeader .searchData input[type=search]");

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

searchingNotes.addEventListener("keyup", (e)=>{
  const collectionOfNotes = document.querySelectorAll("main .informationDisplay .wrapNotesPublish .notes");
  const inputSearching = e.target.value.toLowerCase();
  const AllItemNotes = document.querySelectorAll("main .informationDisplay .wrapNotesPublish .notes");

  if(collectionOfNotes.length < 1){
    alert('Mohon maaf Tidak ada catatan yang dibagikan secara publik saat ini,Periksa kembali nanti untuk pembaruan!');
  }else{
    for(const data of AllItemNotes){
      const titleNotes = data.querySelector("button .title").textContent.toLowerCase();
      const descriptionNotes = data.querySelector("button .description").textContent.toLowerCase();
      const usernameNotes = data.querySelector("button .username").textContent.toLowerCase();
      const dateNotes = data.querySelector("button .date").textContent.toLowerCase();

      if(titleNotes.includes(inputSearching) || usernameNotes.includes(inputSearching)){
        data.style.display = 'flex';
      }else{
        data.style.display = 'none';
      }
    }
  }
});