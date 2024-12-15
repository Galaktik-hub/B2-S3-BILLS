<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include("../include/navbar.php");
    include('../include/links.php');
    ifAdminNotPO();
    include('../data/fetchHomeDeleteClient.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">

    <title>Espace Admin</title>
</head>
    <body>
        <div class="page-container" >
            <div class="page-content">
                <h1> Liste des demandes de suppression de comptes </h1>
                <?php
                    // Vérifie si la variable $clients est vide (aucune demande de suppression)
                    if(empty($clients)){
                        echo " Il n'y a pas de demande de suppression de comptes actuellement.";
                    } else {
                        // Si des demandes sont présentes, on affiche un tableau avec ag-Grid
                        echo '<div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>';
                    }
                ?>
            </div>
        </div>

        <script>
            // Récupération des données PHP dans des variables JavaScript pour alimenter ag-Grid
            const data = <?php echo $clients_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>

        <!-- Fichier js de construction du tableau -->
        <script src="../js/constructor_agGrid_admin.js"></script>

        <?php
        // Si le paramètre 'numClient' est passé dans l'URL, on affiche un message de confirmation
        if(isset($_GET['numClient'])){
            $numClient = $_GET["numClient"];
            echo "Le client N° $numClient a bien été supprimé.";
        }
        ?>
    </body>
</html>