<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include("../include/navbar.php");
    include('../include/links.php');
    checkIsPO();
    include('../data/fetchRemisePO.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">

    <title>Espace Product Owner</title>
</head>
    <body>
        <div class="page-container">
            <div class="page-content">
                <h1 class="titre">Remises</h1>

                <?php
                    // Gestion des variables de session pour les filtres de recherche (numSiren, dates)
                    if(isset($_POST['numSiren'])) {
                        $_SESSION['numSiren'] = $_POST['numSiren'];
                        $numSiren = $_SESSION['numSiren'];
                    }
                    else {
                        unset($_SESSION['numSiren']);
                        // Si aucun numéro Siren n'est envoyé, on vide la session
                        $numSiren = "";
                    }

                    // Gestion de la date de début (début de la période)
                    if(isset($_POST['debut'])){
                        $_SESSION['debut.date'] = $_POST['debut'];
                        $debut = $_SESSION['debut.date'];
                    }
                    else {
                        //$debut = date('Y-m-d');
                        unset($_SESSION['debut.date']);
                        $debut = "";
                    }

                    // Gestion de la date de fin (fin de la période)
                    if(isset($_POST['fin'])){
                        $_SESSION['fin.date'] = $_POST['fin'];
                        $fin = $_SESSION['fin.date'];
                    }
                    else {
                        //$fin = date('Y-m-d');
                        unset($_SESSION['fin.date']);
                        $fin = "";
                    }
                ?>

                <!-- Section d'exportation de données -->
                <section class="export-options">
                    <div class="select-container">
                        <label for="format">Format d'export :</label>
                        <div class="select-wrapper">
                            <select id="format">
                                <option value="csv">CSV</option>
                                <option value="xls">XLS</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                    <button id="exportButton">Exporter</button>
                </section>

                <div class="nbRemises" id="rowCountInfo"></div>

                <!-- Tableau ag-Grid pour afficher les données -->
                <div id="myGrid" class="ag-theme-quartz" style="width: 1200px;"></div>
            </div>
        </div>

        <script>
            // Récupération des données PHP dans des variables JavaScript pour alimenter ag-Grid
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
            const fileName = <?php echo json_encode("Remises_" . $_SESSION['raisonSociale'] . "_" . date('Y_m_j')); ?>;
        </script>

        <!-- Fichier js de construction du tableau -->
        <script src="../js/constructor_agGrid_remise_po.js"></script>
    </body>
</html>