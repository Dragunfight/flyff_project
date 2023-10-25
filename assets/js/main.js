const burgerButton = document.getElementById("burgerbutton");
const burgerContent = burgerButton.querySelector("span");
const nav = document.querySelector(".nav-list");
const navlinks = document.querySelectorAll("nav li");
const modale = document.querySelector('.modale');
const overlay = document.querySelector('.overlay');
const showModale = document.querySelectorAll('.show-modale');
const closeModale = document.querySelector('.close-modale');
const editIcons = document.querySelectorAll('.edit-icon');
const deleteIcons = document.querySelectorAll('.delete-icon');

document.addEventListener("DOMContentLoaded", function () {

  // Gestion Menu Burger
  let active = false;

  burgerButton.addEventListener("click", () => {

    active = !active;

    if(active) {
      burgerContent.textContent = "\u2715"
    } else {
      burgerContent.textContent = "\u2630"
    }
    nav.classList.toggle("active");
  });

  navlinks.forEach((navlinks) => {
      navlinks.addEventListener("click", () => {
      nav.classList.remove("active");
    });
  });


  // Gestion Modale
  function openModale() {
    modale.classList.remove('hidden');
    overlay.classList.remove('hidden');
  }

  function closeModale() {
      modale.classList.add('hidden');
      overlay.classList.add('hidden');
  }

  for (let i = 0; i < showModale.length; i++) {
      showModale[i].addEventListener('click', openModale);
  }

  modale.addEventListener('click', openModale);
  modale.addEventListener('click', closeModale);
  overlay.addEventListener('click', closeModale);

  document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !modale.classList.contains('hidden')) {
          closeModale();
      }
  });

  // Ne pas ouvrir la modale sur les boutons edit/delete
    editIcons.forEach(editIcon => {
      editIcon.addEventListener('click', function (event) {
          event.stopPropagation(); 
      });
    });

    deleteIcons.forEach(deleteIcon => {
      deleteIcon.addEventListener('click', function (event) {
          event.stopPropagation(); 
      });
    });
});