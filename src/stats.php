<?php
global $dbh;
session_start();
include('function.php');
include('connexion.php');
include('navbar.php');
checkIsUser();

$date = isset($_GET['date']) ? $_GET['date'] : date('Y');
$graph = isset($_GET['graph']) ? $_GET['graph'] : "bar";

// Requête pour obtenir la trésorerie (montant total) par mois pour l'année sélectionnée
$queryTreasury = "
    SELECT MONTH(dateRemise) AS month, 
           COALESCE(SUM(montantTotal), 0) AS total_tresorerie
    FROM remise 
    WHERE YEAR(dateRemise) = ?
    GROUP BY MONTH(dateRemise)
    ORDER BY month
";
$stmt = $dbh->prepare($queryTreasury);
$stmt->execute([$date]);
$tresorerieData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Extraction des données pour le graphique
$months = array_map(fn($d) => $d['month'], $tresorerieData);
$totals = array_map(fn($d) => $d['total_tresorerie'], $tresorerieData);

// Requête pour les motifs d'impayés
$queryMotifs = "
    SELECT ci.libelleImpaye AS motif, COUNT(i.numTransaction) AS count 
    FROM impaye i
    JOIN codeimpaye ci ON i.codeImpaye = ci.codeImpaye
    JOIN remise r ON i.numTransaction = r.numRemise
    WHERE YEAR(r.dateRemise) = ?
    GROUP BY ci.libelleImpaye
";
$stmtMotifs = $dbh->prepare($queryMotifs);
$stmtMotifs->execute([$date]);
$motifsData = $stmtMotifs->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="../css/statistiques.css" rel="stylesheet">
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <title>Espace Client</title>
    </head>
    <body>
        <div class="container">
            <h1 class="title">Statistiques de votre compte</h1>

            <!-- Formulaire de sélection d'année et de type de graphique -->
            <form method='get' action='stats.php'>
                <div class="choice">
                    <label>Choix de l'année :
                        <select name="date">
                            <?php for($i = 1950; $i <= date('Y'); $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $date ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </label>
                </div>
                <p class="separator">|</p>
                <div class="choice">
                    <label>Type de graphique :
                        <select name="graph">
                            <option value="bar" <?= $graph === "bar" ? 'selected' : '' ?>>Histogramme</option>
                            <option value="line" <?= $graph === "line" ? 'selected' : '' ?>>Courbe</option>
                        </select>
                    </label>
                </div>

                <input type="submit" value="Valider" class="button">
            </form>

            <!-- Conteneurs pour les graphiques -->
            <div class="container-graph">
                <div id="graphTresorerie"></div>

                <!-- Vérification de motifs d'impayés -->
                <?php
                    if (!empty($motifsData)) {
                        echo "<div id=\"graphMotifs\"></div>";
                    } else {
                        echo "<p id=\"noDataMessage\"> Aucun impayé n'a été trouvé pour l'année $date.</p>";
                    }
                ?>
            </div>

            <!-- Exportation en PDF -->
            <button id="exportPdf" class="button">Exporter en PDF</button>
        </div>
    </body>
</html>
