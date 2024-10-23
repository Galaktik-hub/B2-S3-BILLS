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

        <h3 class="titre">Impayés</h3>

        <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>

        <script>
            const data = <?php echo $impayes_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>
