<?php
global $dbh;
session_start();
include('../include/connexion.php');

$queryRemise = "SELECT * FROM remise";
$stmtRemise = $dbh->prepare($queryRemise);
$stmtRemise->execute();

while($remiseData = $stmtRemise->fetch(PDO::FETCH_ASSOC)) {
    $numRemise = $remiseData->numRemise;
    $queryTransac = "SELECT * FROM transaction WHERE numRemise = ?";
    $stmtTransac = $dbh->prepare($queryTransac);
    $stmtTransac->execute([$numRemise]);
    $numberTransac = 0;
    $sumTransac = 0;
    while($transacData = $stmtTransac->fetch(PDO::FETCH_ASSOC)) {
        $numberTransac++;
        $sumTransac += $transacData->montant;
    }
    $queryUpdateRemise = "UPDATE remise SET nbrTransaction = ? AND montantTotal = ? WHERE numRemise = ?";
    $stmtUpdateRemise = $dbh->prepare($queryUpdateRemise);
    $stmtUpdateRemise->execute([$numberTransac, $sumTransac, $numRemise]);
}

