<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include("../include/navbar.php");
    include('../include/links.php');
    checkIsPO();
    include('../data/fetchTreasuryPO.php');
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
                <?php
                // Si une date est envoyée via POST, elle est stockée dans la session pour être utilisée
                if(isset($_POST['date'])){
                    $_SESSION['home.datePO'] = $_POST['date'];
                    $date = $_SESSION['home.datePO'];
                }
                else {
                    // Si aucune date n'est envoyée, on utilise la date actuelle
                    unset($_SESSION['home.datePO']);
                    $date = date('Y-m-d');
                }

                // Mise en place de la locale pour afficher la date en français
                setlocale (LC_TIME, 'fr_FR.utf8','fra');
                // Affichage de la date dans un format français
                echo "<h1 class='titre'>Trésorerie du ".strftime('%A %e %B %Y', strtotime($date))."</h1>";

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

                <!-- Tableau ag-Grid pour afficher les données -->
                <div id="myGrid" class="ag-theme-quartz" style="width: 1200px;"></div>
            </div>
        </div>

        <script>
            // Récupération des données PHP dans des variables JavaScript pour alimenter ag-Grid
            const data = <?php echo $clients_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
            const fileName = <?php echo json_encode("Tresorerie_" . $_SESSION['raisonSociale'] . "_" . date('Y_m_j')); ?>;
        </script>

        <!-- Fichier js de construction du tableau -->
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>

