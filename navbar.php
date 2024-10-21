<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NavBar</title>
    <link rel="stylesheet" href="../Css/Navbar.css">
</head>
<body>
    <nav class="vertical-navigation">
        <div class="titleName">
            <p>
                B.I.L.L.S.
            </p>
        </div>
        <ul class="navigation-items">
            <a href="home.php" class="nav-item">
                <li class="item">
                    <img src="../Image/accueil.svg" alt="Icone Accueil" class="icon">
                    <p>Accueil</p>
                </li>
            </a>
            <a href="remise.php" class="nav-item">
                <li class="item">
                    <img src="../Image/remises.svg" alt="Icone Remises" class="icon">
                    <p>Remises</p>
                </li>
            </a>
            <a href="impaye.php" class="nav-item">
                <li class="item">
                    <img src="../Image/impayés.svg" alt="Icone Impayés" class="icon">
                    <p>Impayés</p>
                </li>
            </a>
            <a href="stats.php" class="nav-item">
                <li class="item">
                    <img src="../Image/stats.svg" alt="Icone Statistiques" class="icon">
                    <p>Statistiques</p>
                </li>
            </a>
            <a href="#" class="nav-item">
                <li class="item">
                    <img src="../Image/compte.svg" alt="Icone Compte" class="icon">
                    <p>Compte</p>
                </li>
            </a>
            <a href="#" class="nav-item">
                <li class="item">
                    <img src="../Image/settings.svg" alt="Icone Paramètres" class="icon">
                    <p>Paramètres</p>
                </li>
            </a>
        </ul>
        <div class="deconnect">
            <a href="#" class="deconnect-link">
                <img src="../Image/deconnect.svg" alt="Icone Paramètres" class="icon">
                <p>Déconnexion</p>
            </a>
        </div>
    </nav>

    <script>
        const navItems = document.querySelectorAll('.navigation-items a.nav-item');

        navItems.forEach(item => {
            item.addEventListener('click', function() {
                // Supprime la classe active de tous les éléments
                navItems.forEach(nav => {
                    nav.classList.remove('active');

                    // Récupère l'icône et remet l'icône d'origine
                    const img = nav.querySelector('img');
                    const imgSrc = img.getAttribute('src');
                    const originalSrc = imgSrc.replace('_selected.svg', '.svg');
                    img.setAttribute('src', originalSrc); // Remet à jour l'attribut src de l'image
                });

                // Ajoute la classe active à l'élément cliqué
                this.classList.add('active');

                // Change l'icône SVG en ajoutant "_selected" au nom de fichier
                const img = this.querySelector('img');
                const imgSrc = img.getAttribute('src');
                const newSrc = imgSrc.replace('.svg', '_selected.svg'); // Remplace ".svg" par "_selected.svg"
                img.setAttribute('src', newSrc); // Met à jour l'attribut src de l'image
            });
        });
    </script>
</body>
</html>