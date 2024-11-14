<?php
session_start();
include('../include/function.php');
include('../include/connexion.php');
include("../include/navbar.php");
include('../include/links.php');
checkIsPo();
include('../data/fetchTransactionPO.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/transaction.css">

    <title>Espace Client</title>
</head>
<body>
<div class="page-container">
    <div class="page-content">
        <a href="productOwnerRemise.php" class="back-container">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Retour aux remises</span>
        </a>
        <h1> Détails de la remise n° <?php echo $_GET['numRemise'] ?> </h1>

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

        <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>

    </div>
</div>

<script>
    const data = <?php echo $transactions_json; ?>;
    const columnNames = <?php echo $columns_json; ?>;
    const fileName = <?php echo json_encode("Transactions_Remise_N°_" . $_GET['numRemise'] . "_" . $_SESSION['raisonSociale'] . "_" . date('Y_m_j')); ?>;
</script>

<script src="../js/constructor_agGrid_transaction.js"></script>
</body>
</html>