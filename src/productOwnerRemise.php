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

                <div class="container box">
                    <form action="productOwnerRemise.php" method="POST" class="imp">
                        <label for="numSiren">Numéro SIREN</label>
                        <input type="text" name="numSiren" id="numSiren">

                        <label for="debut">Du</label>
                        <input type="date" name="debut" id="debut" <?php echo "value='".$debut."' max='".date('Y-m-d')."'";  ?>>

                        <label for="fin">Au</label>
                        <input type="date" name="fin" id="fin" <?php echo "value='".$fin."' max='".date('Y-m-d')."'";  ?>>

                        <input type="submit">
                    </form>

                    <?php
                    echo "
                        <ul>
                                <li>Numéro SIREN : $numSiren</li>
                                <li>Début : $debut</li>
                                <li>Fin : $fin</li>
                        </ul>";

                    if($debut > $fin && $fin != null){
                        echo "<div class='alert alert-danger' role='alert'>La date de début doit être inférieure à la date de fin</div>";
                        exit;
                    }

                    ?>
                </div>

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