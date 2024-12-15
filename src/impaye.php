<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include("../include/navbar.php");
    include('../include/links.php');
    checkIsUser();
    include('../data/fetchImpaye.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/impayes_u.css">

    <title>Espace Client</title>
</head>
    <body>
        <div class="page-container">
            <div class="page-content">
                <h1 class="titre">Impayés</h1>
                <?php
                // Si la variable $impayes est vide, cela signifie qu'il n'y a pas d'impayés enregistrés
                if (empty($impayes)) {
                    echo "Il n'y a pas d'impayés enregistrés pour ce compte.";
                } else {
                    // Si des impayés existent, afficher les options d'export et le tableau
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

                    <!-- On affiche le tableau ag-Grid -->
                    <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>';
                }
                ?>
            </div>
        </div>

        <script>
            // Récupération des données PHP dans des variables JavaScript pour alimenter ag-Grid
            const data = <?php echo $impayes_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
            const fileName = <?php echo json_encode("Liste des impayés de l'entreprise " . $_SESSION['raisonSociale'] . " N° SIREN "
                . $_SESSION['numSiren'] ." - Extrait du " . date('Y-m-j')); ?>;
        </script>

        <!-- Fichier js de construction du tableau -->
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>
