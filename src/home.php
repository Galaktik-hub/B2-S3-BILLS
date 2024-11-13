<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include('navbar.php');
    include('links.php');
    checkIsUser();
    include('../data/fetchHome.php');


    if (isset($_SESSION['numClient'])){
        $raison_display = $_SESSION['raisonSociale'];
    }

    // Si le PO veut voir la page du point de vue d'un client
    if (isset($_SESSION['PO_VIEW_CLIENT'])){
        $stmt = $dbh->prepare("SELECT raisonSociale FROM client WHERE numClient = :numClient");
        $stmt->bindParam(':numClient', $_SESSION['PO_VIEW_CLIENT'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $raison_display = htmlspecialchars($result['raisonSociale']). " (visualisation PO)";
        } else {
            // si jamais la requête échoue on garde le numéro
            $raison_display = htmlspecialchars("Client n°".$_SESSION['PO_VIEW_CLIENT']. " (visualisation PO)");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/home.css">

    <title>Espace Client</title>
</head>
    <body>
        <div class="page-container">
            <div class="page-top">
                <h1>Bonjour <?php echo $raison_display?> </h1>
                <?php

                if(isset($_POST['date'])){
                    $_SESSION['home.date'] = $_POST['date'];
                    $date = $_SESSION['home.date'];
                }
                else {
                    $date = date('Y-m-d');
                    unset($_SESSION['home.date']);
                }
                setlocale (LC_TIME, 'fr_FR.utf8','fra');
                echo "<h2>Trésorerie du ".strftime('%A %e %B %Y', strtotime($date))."</h2>";

                ?>

                <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; max-width: 100%;"></div>
            </div>
        </div>

        <script>
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>


