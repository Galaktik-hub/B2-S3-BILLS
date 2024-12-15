<?php
global $dbh;
session_start();
include('../include/function.php');
include('../include/connexion.php');
include('../include/navbar.php');
checkIsUser();
include('../data/fetchStats.php');
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
            <?php
            // Affiche un titre personnalisé en fonction du client connecté
            if (isset($_SESSION['numClient'])){
                $raison_display = "Statistiques de votre compte";
            }

            // Si le PO veut voir la page du point de vue d'un client
            if (isset($_SESSION['PO_VIEW_CLIENT'])){
                $stmt = $dbh->prepare("SELECT raisonSociale FROM client WHERE numClient = :numClient");
                $stmt->bindParam(':numClient', $_SESSION['PO_VIEW_CLIENT'], PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Si le client est trouvé, afficher son nom
                if ($result) {
                    $raison_display = htmlspecialchars("Statistiques du compte de ". $result['raisonSociale']);
                } else {
                    // Si jamais la requête échoue, afficher l'ID du client
                    $raison_display = htmlspecialchars("Statistiques du client n°".$_SESSION['PO_VIEW_CLIENT']);
                }
            }
            ?>
            <h1 class="title"><?php echo $raison_display;?></h1>

            <!-- Formulaire de sélection d'année et de type de graphique -->
            <form method='get' action='stats.php'>
                <div class="choice">
                    <label>Choix de l'année :
                        <div class="select-wrapper">
                            <select class="select-list" name="date">
                                <?php for ($i = date('Y'); $i >= 1980; $i--) : ?>
                                    <option value="<?= $i ?>" <?= $i == $date ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </label>
                </div>
                <p class="separator">|</p>
                <div class="choice">
                    <label>Type de graphique :
                        <div class="select-wrapper">
                            <select class="select-list" name="graph">
                                <option value="bar" <?= $graph === "bar" ? 'selected' : '' ?>>Histogramme</option>
                                <option value="line" <?= $graph === "line" ? 'selected' : '' ?>>Courbe</option>
                            </select>
                        </div>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

        <script>
            // Données pour la trésorerie mensuelle
            var traceTresorerie = {
                x: [<?= implode(',', array_map(fn($m) => "'".date('F', mktime(0, 0, 0, $m))."'", $months)) ?>],
                y: [<?= implode(',', $totals) ?>],
                type: '<?= $graph ?>',
                name: 'Trésorerie'
            };

            // Affichage du graphique de trésorerie
            Plotly.newPlot('graphTresorerie', [traceTresorerie], {title: 'Trésorerie Mensuelle'});

            // Données pour les motifs d'impayés (camembert)
            var traceMotifs = {
                labels: [<?= implode(',', array_map(fn($m) => "'".$m['motif']."'", $motifsData)) ?>],
                values: [<?= implode(',', array_map(fn($m) => $m['count'], $motifsData)) ?>],
                type: 'pie',
                name: 'Motifs d\'Impayés'
            };
            Plotly.newPlot('graphMotifs', [traceMotifs], {title: 'Motifs d’Impayés'});

            document.getElementById('exportPdf').addEventListener('click', function () {
                const pdf = new jspdf.jsPDF('portrait', 'mm', 'a4');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const margin = 10;
                let cursorY = margin;

                // Données dynamiques pour le titre et le nom du fichier
                const raisonSociale = '<?= str_replace(" ", "_", $_SESSION["raisonSociale"]) ?>';
                const date = '<?= $date ?>';
                const pdfTitle = `Statistiques de ${'<?= $_SESSION["raisonSociale"] ?>'} (${date})`;
                const fileName = `Statistiques_${raisonSociale}_${date}.pdf`;

                // Fonction pour ajouter un graphique Plotly au PDF
                const addPlotlyToPdf = (graphId, title) => {
                    return new Promise((resolve) => {
                        const graphElement = document.getElementById(graphId);
                        html2canvas(graphElement).then((canvas) => {
                            const imgData = canvas.toDataURL('image/png');
                            const imgWidth = pageWidth - margin * 2;
                            const imgHeight = (canvas.height * imgWidth) / canvas.width;

                            if (cursorY + imgHeight > pageHeight - margin) {
                                pdf.addPage();
                                cursorY = margin;
                            }

                            pdf.text(title, margin, cursorY - 5);
                            pdf.addImage(imgData, 'PNG', margin, cursorY, imgWidth, imgHeight);
                            cursorY += imgHeight + 10;
                            resolve();
                        });
                    });
                };

                // Fonction principale pour générer le PDF
                (async () => {
                    // Ajouter le titre principal
                    pdf.setFontSize(16);
                    pdf.text(pdfTitle, pageWidth / 2, cursorY, { align: 'center' });
                    cursorY += 20;

                    // Ajouter le graphique de trésorerie
                    await addPlotlyToPdf('graphTresorerie', 'Trésorerie Mensuelle');

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
