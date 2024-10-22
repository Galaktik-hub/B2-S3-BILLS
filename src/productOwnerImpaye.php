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
            raisonSociale as 'Raison Sociale',
            sum(montant) AS Montant
        FROM
            client
        NATURAL JOIN remise
        NATURAL JOIN transaction
        WHERE montant < 0";

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $impayes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($impayes[0]);

    $impayes_json = json_encode($impayes);
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

        <h3 class="titre">Impayés</h3>

        <div class="container box">
            <form action="productOwnerImpaye.php" method="POST" class="imp">
                <label for="numSiren">Numéro SIREN</label>
                <input type="text" name="numSiren" id="numSiren">

                <input type="submit">
            </form>
            <?php

            if(isset($_POST['numSiren'])) {
                $_SESSION['numSiren'] = $_POST['numSiren'];
                $numSiren = $_SESSION['numSiren'];
            }
            else {
                unset($_SESSION['numSiren']);
                $numSiren = "";
            }

            echo "
                <ul>
                        <li>Numéro SIREN : $numSiren</li>
                </ul>";

            ?>
            <br/>
        </div>

        <div id="myGrid" class="ag-theme-quartz" style="width: 1400px; margin: auto; max-width: 100%; font-size: 15px"></div>

        <script>
            const data = <?php echo $impayes_json; ?>;
            const columnNames = <?php echo $columns_json; ?>;
        </script>
        <script src="../js/constructor_agGrid.js"></script>
    </body>
</html>