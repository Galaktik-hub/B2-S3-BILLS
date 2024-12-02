<?php

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
