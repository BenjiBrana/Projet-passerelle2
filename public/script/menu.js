let navbar;

// Gère l'ouverture/fermeture du menu burger
function toggleMenu() {
    navbar.classList.toggle('show-nav');
}

window.onload = () => {
    
    navbar = document.querySelector('.navbar');
    const burger = document.querySelector('.burger');

    // Vérifie si les éléments existent
    if (navbar && burger) {
        burger.addEventListener('click', toggleMenu);
    }
};
