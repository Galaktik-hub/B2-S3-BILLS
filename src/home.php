<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include('navbar.php');
    include('links.php');
    checkIsUser();
    include('../data/fetchHome.php');
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
        <div class="page-top">
            <h1>Bonjour <?php echo $_SESSION['raisonSociale']?> </h1>
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
        </div>

        <div id="myGrid" class="ag-theme-quartz" style="width: 1400px; margin: auto; max-width: 100%; font-size: 15px"></div>


        <script>
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>


