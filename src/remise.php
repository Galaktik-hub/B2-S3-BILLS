<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    include('links.php');
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
                }
                    echo '<div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>';
                ?>
            </div>
        </div>

        <script>
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>
