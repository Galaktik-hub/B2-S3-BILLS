<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    include('links.php');
    checkIsPO();
    include('../data/fetchRemisePO.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">

    <title>Espace Product Owner</title>
</head>
    <body>
        <div class="page-container">
            <div class="page-content">
                <h1 class="titre">Remises</h1>

                <?php
                    if(isset($_POST['numSiren'])) {
                        $_SESSION['numSiren'] = $_POST['numSiren'];
                        $numSiren = $_SESSION['numSiren'];
                    }
                    else {
                        unset($_SESSION['numSiren']);
                        $numSiren = "";
                    }

                    if(isset($_POST['debut'])){
                        $_SESSION['debut.date'] = $_POST['debut'];
                        $debut = $_SESSION['debut.date'];
                    }
                    else {
                        //$debut = date('Y-m-d');
                        unset($_SESSION['debut.date']);
                        $debut = "";
                    }

                    if(isset($_POST['fin'])){
                        $_SESSION['fin.date'] = $_POST['fin'];
                        $fin = $_SESSION['fin.date'];
                    }
                    else {
                        //$fin = date('Y-m-d');
                        unset($_SESSION['fin.date']);
                        $fin = "";
                    }
                ?>

                <div id="myGrid" class="ag-theme-quartz" style="width: 1200px;"></div>
            </div>
        </div>

        <script>
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>