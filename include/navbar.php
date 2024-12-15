<?php
include('../data/fetchHomeDeleteClient.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
</head>
<body>
    <nav class="vertical-navigation">
        <div class="titleName">
            <p title="Bilan des Impayés et Lettres de Licences avec Statistiques">
                B.I.L.L.S.
            </p>
        </div>

        <!-- Appel de la fonction d'affichage de la barre de navigation -->
        <?php display_navigation(); ?>

        <div class="deconnect">
            <a href="../include/deconnexion.php" class="deconnect-link">
                <img src="../image/deconnect.svg" alt="Icone Paramètres" class="icon">
                <p> <?php
                    // Affichage dynamique du bouton "Déconnexion"
                if (isset($_SESSION['PO_VIEW_CLIENT'])) {
                    echo "Arrêter la visualisation";
                } else {
                    echo "Déconnexion";
                } ?> </p>
            </a>
        </div>
    </nav>
    <script src="../js/navbar.js"></script>
    <script>
        // Affichage dynamique d'un indicateur rouge si la liste de suppression n'est pas vide
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (!empty($clients)): ?>
            document.getElementById('notificationDot').style.display = 'inline-block';
            <?php endif; ?>
        });
    </script>


</body>
</html>
