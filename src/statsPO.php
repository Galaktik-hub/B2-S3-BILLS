<?php
global $dbh;
session_start();
include('../include/function.php');
include('../include/connexion.php');
include('../include/navbar.php');
checkIsPO();
include('../data/fetchStatsPO.php');
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
                        <?php for ($i = date('Y'); $i >= 1980; $i--): ?>
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
        labels: [<?= implode(',', array_map(fn($m) => "'" . $m['motif'] . "'", $motifsData)) ?>],
        values: [<?= implode(',', array_map(fn($m) => $m['count'], $motifsData)) ?>],
        type: 'pie',
        name: 'Motifs d\'Impayés'
    };
    Plotly.newPlot('graphMotifs', [traceMotifs], {title: 'Motifs d’Impayés'});

    document.getElementById('exportPdf').addEventListener('click', function () {
        const pdf = new jspdf.jsPDF('portrait', 'mm', 'a4'); // Initialiser jsPDF
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const margin = 10;
        let cursorY = margin; // Position actuelle sur l'axe Y pour le contenu

        // Données dynamiques pour le titre et le nom du fichier
        const date = '<?= $date ?>';
        const pdfTitle = `Statistiques des impayés de tous les utilisateurs (${date})`;
        const fileName = `Statistiques_PO_${date}.pdf`;

        // Fonction pour ajouter un graphique Plotly à un PDF
        const addPlotlyToPdf = (graphId, title) => {
            return new Promise((resolve) => {
                const graphElement = document.getElementById(graphId);
                html2canvas(graphElement).then((canvas) => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = pageWidth - margin * 2;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    if (cursorY + imgHeight > pageHeight - margin) {
                        pdf.addPage(); // Ajouter une nouvelle page si nécessaire
                        cursorY = margin;
                    }

                    pdf.text(title, margin, cursorY - 5); // Ajouter le titre du graphique
                    pdf.addImage(imgData, 'PNG', margin, cursorY, imgWidth, imgHeight);
                    cursorY += imgHeight + 10; // Mettre à jour la position Y
                    resolve();
                });
            });
        };

        // Fonction principale pour générer le PDF
        (async () => {
            // Ajouter le titre principal
            pdf.setFontSize(16);
            pdf.text(pdfTitle, pageWidth / 2, cursorY, {align: 'center'});
            cursorY += 20;

            // Ajouter le graphique des motifs d’impayés si des données existent
            const graphMotifs = document.getElementById('graphMotifs');
            if (graphMotifs && graphMotifs.style.display !== 'none') {
                await addPlotlyToPdf('graphMotifs', 'Motifs d’Impayés');
            } else {
                pdf.text("Aucun impayé trouvé pour l'année sélectionnée.", margin, cursorY);
            }

            // Télécharger le fichier PDF avec le nom dynamique
            pdf.save(fileName);
        })();
    });
</script>
</body>
</html>
