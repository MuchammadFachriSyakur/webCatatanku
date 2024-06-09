const wrapEye = document.querySelector(".wrapForm form  .wrapEye");

wrapEye.addEventListener("click", (e)=>{
  const inputPassword = document.querySelector(".wrapForm form .form-group .password");
  const eyeSlash = document.querySelector(".wrapForm form .form-group .wrapEye .ph-eye-slash");
  const eye = document.querySelector(".wrapForm form .form-group .wrapEye .ph-eye");
  console.log(inputPassword.type);
  
  if(inputPassword.type === "password"){
    inputPassword.type = "text";
    eyeSlash.style.display = "block";
    eye.style.display = "none";
  }else{
    inputPassword.type = "password";
    eyeSlash.style.display = "none";
    eye.style.display = "block";
  }
});