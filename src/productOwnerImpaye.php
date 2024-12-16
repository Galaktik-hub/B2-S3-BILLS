<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include("../include/navbar.php");
    include('../include/links.php');
    checkIsPO();
    include('../data/fetchImpayePO.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">

    <title>Espace Product Owner</title>
</head>
    <body>
        <div class="page-container">
            <div class="page-content">
                <h1 class="titre">Impayés</h1>

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

                <div class="nbImpayes" id="rowCountInfo"></div>

                <!-- Tableau ag-Grid pour afficher les données -->
                <div id="myGrid" class="ag-theme-quartz" style="width: 1200px;"></div>
            </div>
        </div>
        <script>
            // Récupération des données PHP dans des variables JavaScript pour alimenter ag-Grid
            const data = <?php echo $impayes_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
            const fileName = <?php echo json_encode("Impayes_" . $_SESSION['raisonSociale'] . "_" . date('Y_m_j')); ?>;
        </script>

        <!-- Fichier js de construction du tableau -->
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>