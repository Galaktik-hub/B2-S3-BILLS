<?php
global $dbh;
$numRemise = $_GET['numRemise'];

// Requête SQL pour récupérer les transactions liées à un numéro de remise spécifique
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

// Vérifie si aucune transaction n'a été trouvée, et redirige l'utilisateur vers la page productOwnerRemise.php
if (empty($transactions)) {
    header("Location: productOwnerRemise.php");
    exit();
}

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($transactions[0]);

// Conversion des transactiosn en JSON
$transactions_json = json_encode($transactions);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);