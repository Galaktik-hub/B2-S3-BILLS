<?php

// Détermine la date en fonction de l'URL ou de la date actuelle
$date = isset($_GET['date']) ? $_GET['date'] : date('Y');
// Type de graphique en barre par défaut (barre ou courbe)
$graph = isset($_GET['graph']) ? $_GET['graph'] : "bar";

// Récupération de la raison sociale du client connecté
$queryClient = "SELECT raisonSociale FROM client WHERE numClient = ?";
$stmtClient = $dbh->prepare($queryClient);

// Vérifie si l'utilisateur est connecté (numClient)
if (isset($_SESSION['numClient'])){
    $numClient = $_SESSION['numClient'];
}

// Si le PO veut voir la page du point de vue d'un client
if (isset($_SESSION['PO_VIEW_CLIENT'])){
    $numClient = $_SESSION['PO_VIEW_CLIENT'];
}

// Exécution de la requête pour récupérer la raison sociale du client
$stmtClient->execute([$numClient]);
$clientData = $stmtClient->fetch(PDO::FETCH_ASSOC);
$raisonSociale = $clientData['raisonSociale'];

// Requête pour obtenir la trésorerie (montant total) par mois pour l'année sélectionnée
$queryTreasury = "
    SELECT MONTH(dateRemise) AS month, 
           COALESCE(SUM(montantTotal), 0) AS total_tresorerie
    FROM remise 
    WHERE YEAR(dateRemise) = ? AND numClient = ?
    GROUP BY MONTH(dateRemise)
    ORDER BY month
";
$stmt = $dbh->prepare($queryTreasury);
$stmt->execute([$date, $numClient]);
$tresorerieData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Extraction des données pour le graphique
$months = array_map(fn($d) => $d['month'], $tresorerieData);
$totals = array_map(fn($d) => $d['total_tresorerie'], $tresorerieData);

// Requête pour les motifs d'impayés pour l'année sélectionnée
$queryMotifs = "
    SELECT ci.libelleImpaye AS motif, COUNT(i.numTransaction) AS count 
    FROM impaye i
    JOIN codeimpaye ci ON i.codeImpaye = ci.codeImpaye
    JOIN remise r ON i.numTransaction = r.numRemise
    WHERE YEAR(r.dateRemise) = ? AND r.numClient = ?
    GROUP BY ci.libelleImpaye
";
$stmtMotifs = $dbh->prepare($queryMotifs);
$stmtMotifs->execute([$date, $numClient]);
$motifsData = $stmtMotifs->fetchAll(PDO::FETCH_ASSOC);
