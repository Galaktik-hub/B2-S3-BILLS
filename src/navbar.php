<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <nav class="vertical-navigation">
        <div class="titleName">
            <p>
                B.I.L.L.S.
            </p>
        </div>

        <?php display_navigation(); ?>

        <div class="deconnect">
            <a href="deconnexion.php" class="deconnect-link">
                <img src="../Image/deconnect.svg" alt="Icone Paramètres" class="icon">
                <p>Déconnexion</p>
            </a>
        </div>
    </nav>

    <script>
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

        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(nav => {
                    nav.classList.remove('active');
                    updateIcon(nav, false); // Remettre l'icône d'origine
                });

                this.classList.add('active');
                updateIcon(this, true); // Changer l'icône en version "active"
            });
        });
    </script>
</body>
</html>