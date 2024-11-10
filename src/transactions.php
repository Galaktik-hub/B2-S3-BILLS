<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include('links.php');
checkIsUser();
include('../data/fetchTransaction.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/transaction.css">

        <title>Espace Client</title>
    </head>
    <body>
        <div class="page-container">
            <div class="page-content">
                <a href="remise.php" class="back-container">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Retour aux remises</span>
                </a>
                <h1> Détails de la remise n° <?php echo $_GET['numRemise'] ?> </h1>
                <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>

            </div>
        </div>

        <script>
            const data = <?php echo $transactions_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>

        <script src="../js/constructor_agGrid_transaction.js"></script>
    </body>
</html>