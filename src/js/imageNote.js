const image = document.querySelector(".background-notes");

const attribute_background = image.getAttribute("data-background");

image.style.backgroundImage = `url('${attribute_background}')`;