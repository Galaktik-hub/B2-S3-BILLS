<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include("../include/navbar.php");
    include('../include/links.php');
    checkIsUser();
    include('../data/fetchRemise.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/remise_u.css">

    <title>Espace Client</title>
</head>
    <body>
        <div class="page-container">
            <div class="page-content">
                <h1 class="titre">Remises</h1>
                <?php
                if (empty($remises)) {
                    echo "Il n'y a pas de remises enregistrées pour ce compte.";
                } else {
                    // Section d'exportation de données
                    echo '
                    <section class="export-options">
                        <div class="select-container">
                            <label for="format">Format d\'export :</label>
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
                    <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>';
                }
                ?>
            </div>
        </div>

        <script>
            // Récupération des données PHP dans des variables JavaScript pour alimenter ag-Grid
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
            const fileName = <?php echo json_encode("Liste des remises de l'entreprise " . $_SESSION['raisonSociale'] . " N° SIREN "
                . $_SESSION['numSiren'] ." - Extrait du " . date('Y-m-j')); ?>;
        </script>

        <!-- Fichier js de construction du tableau -->
        <script src="../js/constructor_agGrid_remise.js"></script>
    </body>
</html>
