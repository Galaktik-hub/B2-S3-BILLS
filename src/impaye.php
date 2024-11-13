<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    include('links.php');
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
                if (empty($impayes)) {
                    echo "Il n'y a pas d'impayés enregistrés pour ce compte.";
                } else {
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

                    <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>';
                }
                ?>
            </div>
        </div>

        <script>
            const data = <?php echo $impayes_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>
