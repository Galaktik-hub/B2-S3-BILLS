<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $dbh;
    session_start();
    include('../include/connexion.php');

    $queryRemise = "SELECT * FROM remise";
    $stmtRemise = $dbh->prepare($queryRemise);
    $stmtRemise->execute();

    $numberDeleted = 0;
    $numberUpdated = 0;

    while ($remiseData = $stmtRemise->fetch(PDO::FETCH_ASSOC)) {
        $numRemise = $remiseData['numRemise'];
        echo "Début du traitement de la remise: " . $numRemise ."\n";
        $queryTransac = "SELECT * FROM transaction WHERE numRemise = ?";
        $stmtTransac = $dbh->prepare($queryTransac);
        $stmtTransac->execute([$numRemise]);
        $numberTransac = 0;
        $sumTransac = 0;
        while ($transacData = $stmtTransac->fetch(PDO::FETCH_ASSOC)) {
            $numberTransac++;
            $sumTransac += $transacData['montant'];
        }
        if ($numberTransac == 0){
            $queryDeletedRemise = "DELETE FROM remise WHERE numRemise = ?";
            $stmtDeletedRemise = $dbh->prepare($queryDeletedRemise);
            $stmtDeletedRemise->execute([$numRemise]);
            $numberDeleted++;
            echo "Une remise vient d'être supprimé: N°" . $numRemise ."\n";
        } else {
            $queryUpdateRemise = "UPDATE remise SET nbrTransaction = ?, montantTotal = ? WHERE numRemise = ?";
            $stmtUpdateRemise = $dbh->prepare($queryUpdateRemise);
            $stmtUpdateRemise->execute([$numberTransac, $sumTransac, $numRemise]);
            $numberUpdated++;
            echo "Une remise vient d'être mise à jour: N°" . $numRemise ."\n";
        }
    }
    $message = "La mise à jour a été effectué avec succès.\nNombre d'entrées supprimées: " . $numberDeleted . "\nNombre d'entrées mises à jour: " . $numberUpdated;
} else {
    $message = "";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exécution du Script</title>
</head>
<body>
    <h1>Exécuter le Script Correctif</h1>
    <form method="post" action="">
        <button type="submit">Exécuter le Script</button>
    </form>
    <?php if (!empty($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>

