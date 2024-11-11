<?php
global $dbh;
$numRemise = $_GET['numRemise'];
$query = "SELECT 
                t.numTransaction AS 'N° Transaction',
                t.montant AS 'Montant',
                t.devise AS 'Devise',
                t.numCarte AS 'N° Carte',
                t.numAutorisation AS 'N° Autorisation',
                t.reseau AS 'Réseau'
              FROM transaction t
              LEFT JOIN impaye i ON t.numTransaction = i.numTransaction
              LEFT JOIN codeimpaye ci ON i.codeImpaye = ci.codeImpaye
              WHERE t.numRemise = :numRemise";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':numRemise', $numRemise);
$stmt->execute();

$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($transactions)) {
    header("Location: productOwnerRemise.php");
    exit();
}

$columns = array_keys($transactions[0]);

$transactions_json = json_encode($transactions);
$columns_json = json_encode($columns);