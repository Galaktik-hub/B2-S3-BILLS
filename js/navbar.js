const navItems = document.querySelectorAll('.navigation-items a.nav-item');
const currentPage = window.location.pathname.split("/").pop();

// Fonction pour gérer le changement d'icône
function updateIcon(item, isActive) {
    const img = item.querySelector('img');
    const imgSrc = img.getAttribute('src');
    if (isActive) {
        const newSrc = imgSrc.replace('.svg', '_selected.svg');
        img.setAttribute('src', newSrc);
    } else {
        const originalSrc = imgSrc.replace('_selected.svg', '.svg');
        img.setAttribute('src', originalSrc);
    }
}

// Mettre à jour l'élément actif au chargement de la page
navItems.forEach(item => {
    const href = item.getAttribute('href');
    if (href === currentPage) {
        item.classList.add('active');
        updateIcon(item, true); // Changer l'icône en version "active"
    } else {
        updateIcon(item, false); // Remettre l'icône d'origine
    }
});
