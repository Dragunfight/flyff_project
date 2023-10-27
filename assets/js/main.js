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
const scrollToTop = document.querySelector('.scrollToTop');

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
    document.body.classList.add("no-scroll");
  }

  function closeModale() {
      modale.classList.add('hidden');
      overlay.classList.add('hidden');
      document.body.classList.remove("no-scroll");
  }

  for (let i = 0; i < showModale.length; i++) {
      showModale[i].addEventListener('click', openModale);
  }

  if(modale) {
    modale.addEventListener('click', openModale);
    modale.addEventListener('click', closeModale);
  }

  if(overlay) {
    overlay.addEventListener('click', closeModale);
  }

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


    // Scroll To Top Event
    window.addEventListener('scroll', () => {
      if (window.scrollY > 100) {
          scrollToTop.classList.remove('hidden');
      } else {
          scrollToTop.classList.add('hidden');
      }
    });

    scrollToTop.addEventListener("click", () => {
        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });     
    }); 
    
});