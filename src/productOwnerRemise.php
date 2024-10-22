<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    include('links.php');
    checkIsPO();

    $query = "
        SELECT 
            numSiren as 'N° Siren', 
            numRemise as 'N° Remise', 
            dateRemise as 'Date de Remise',
            raisonSociale as 'Raison Sociale', 
            nbrTransaction as 'Nombre de Transactions', 
            montantTotal as 'Montant Total', 
            devise as Devise 
            FROM remise NATURAL JOIN client";

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($remises[0]);

    $remises_json = json_encode($remises);
    $columns_json = json_encode($columns);
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

        <h3 class="titre">Remises</h3>

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

        <div id="myGrid" class="ag-theme-quartz" style="width: 1400px; margin: auto; font-size: 15px"></div>

        <script>
            const data = <?php echo $remises_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>