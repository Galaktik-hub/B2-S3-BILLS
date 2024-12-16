<?php
global $dbh;
$numRemise = $_GET['numRemise'];

// Préparation de la requête SQL pour récupérer les transactions liées à la remise spécifiée
$query = "SELECT 
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

// Vérification si aucune transaction n'est trouvée, rediriger vers la page des remises
if (empty($transactions)) {
    header("Location: remise.php");
    exit();
}

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($transactions[0]);

// Conversion des transactions en JSON
$transactions_json = json_encode($transactions);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);