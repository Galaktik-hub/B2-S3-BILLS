<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include('links.php');
checkIsAdmin();
include('../data/fetchHomeAdmin.php');
$numClient = $_GET["numClient"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

    <title>Espace Admin</title>
</head>
<body>
<div class="page">
    <h1> Détails du client </h1>
    <form action="deleteClient.php" method="get">
        <input type="hidden" name="numClient" value="<?php echo htmlspecialchars($numClient); ?>">
        <button class="button" type="submit">Suppression du compte client</button>
    </form>
    <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>
    <script>
        const data = <?php echo $client_json; ?>;
        const columnNames = <?php echo $column_json; ?>;
    </script>
    <script src="../js/constructor_agGrid.js"></script>
</div>
</body>
</html>
