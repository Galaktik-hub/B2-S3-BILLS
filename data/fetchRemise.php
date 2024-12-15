<?php

// Vérifie si le 'numClient' est défini dans la session et l'affecte à la variable $numClient
if (isset($_SESSION['numClient'])){
    $numClient = $_SESSION['numClient'];
}

// Si le (PO) veut voir la page du point de vue d'un client, on remplace le numClient par celui de la vue client
if (isset($_SESSION['PO_VIEW_CLIENT'])){
    $numClient = $_SESSION['PO_VIEW_CLIENT'];
}

$date = date('Y-m-d');

// Requête SQL pour récupérer les informations sur les remises liées à un client spécifique
$query = "
    SELECT 
        numRemise as 'N° Remise', 
        dateRemise as 'Date de Remise', 
        numSiren as 'N° Siren', 
        raisonSociale as 'Raison Sociale', 
        nbrTransaction as 'Nombre de Transactions', 
        montantTotal as 'Montant Total', 
        devise as Devise 
    FROM remise NATURAL JOIN client 
    WHERE numClient = :numClient ";


$stmt = $dbh->prepare($query);
$stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
$stmt->execute();
$remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si des remises ont été trouvées, les encode en JSON
if (count($remises) > 0) {
    // Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
    $columns = array_keys($remises[0]);

    // Conversion des clients en JSON
    $remises_json = json_encode($remises);
    // Conversion des colonnes en JSON
    $columns_json = json_encode($columns);
} else {
    $remises_json = "{}";
    $columns_json = "{}";
}
?>