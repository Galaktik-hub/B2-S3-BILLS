<?php
global $dbh;
session_start();
include('function.php');
include('connexion.php');
include('navbar.php');
checkIsPO();

$date = isset($_GET['date']) ? $_GET['date'] : date('Y');

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
    <h1 class="title">Statistiques des impayés de tous les utilisateurs</h1>

    <!-- Formulaire de sélection d'année et de type de graphique -->
    <form method='get' action='statsPO.php'>
        <div class="choice">
            <label>Choix de l'année :
                <div class="select-wrapper">
                    <select class="select-list" name="date">
                        <?php for($i = date('Y'); $i >= 1980; $i--): ?>
                            <option value="<?= $i ?>" <?= $i == $date ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </label>
        </div>

        <input type="submit" value="Valider" class="button">
    </form>

    <!-- Conteneurs pour les graphiques -->
    <div class="container-graph">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<script>
    // Données pour la trésorerie mensuelle
    // Données pour les motifs d'impayés (camembert)
    var traceMotifs = {
        labels: [<?= implode(',', array_map(fn($m) => "'".$m['motif']."'", $motifsData)) ?>],
        values: [<?= implode(',', array_map(fn($m) => $m['count'], $motifsData)) ?>],
        type: 'pie',
        name: 'Motifs d\'Impayés'
    };
    Plotly.newPlot('graphMotifs', [traceMotifs], {title: 'Motifs d’Impayés'});

    // Fonction d'exportation en PDF
    document.getElementById("exportPdf").onclick = function() {
        html2canvas(document.querySelector(".container-graph")).then(canvas => {
            const imgData = canvas.toDataURL("image/png");
            const pdf = new jspdf.jsPDF("landscape", "mm", "a4");
            pdf.addImage(imgData, "SVG", 0, 0, 300, 190);
            const fileName = `Statistiques_${'<?= $date ?>'}.pdf`;
            pdf.save(fileName);
        });
    };
</script>
</body>
</html>
