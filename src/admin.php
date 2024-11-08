<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    include('links.php');
    checkIsAdmin();
    include('../data/fetchHomePO.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">

        <title>Espace Admin</title>
    </head>
    <body>
    <div class="body_admin" >
        <h1> Détails des comptes clients </h1>
        <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>
        <script>
            // Recupere les données de fetchHomePO.php
            const data = <?php echo $clients_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <?php
            // Si l'user est PO, on utilise le script PO
            if(isset($_SESSION['isProductOwner']) && $_SESSION['isProductOwner']){
                echo "<script src=\"../js/constructor_agGrid_PO.js\"></script>";
            } else {
                echo "<script src=\"../js/constructor_agGrid_admin.js\"></script>";
            }
        ?>
    </div>
    </body>
</html>