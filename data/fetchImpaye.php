<?php

if (isset($_SESSION['numClient'])){
    $numClient = $_SESSION['numClient'];
}

// Si le PO veut voir la page du point de vue d'un client
if (isset($_SESSION['PO_VIEW_CLIENT'])){
    $numClient = $_SESSION['PO_VIEW_CLIENT'];
}

$date = date('Y-m-d');

// Préparation de la requête SQL pour récupérer les impayés
$query = "
    SELECT
        dateRemise as 'Date de Remise',
        numCarte as 'N° Carte',
        reseau as 'Réseau',
        numDossierImpaye as 'N° Dossier',
        transaction.devise as Devise,
        montant as 'Montant',
        libelleImpaye as 'Libelle'
    FROM
        remise as Remise
    NATURAL JOIN transaction
    NATURAL JOIN impaye as Impaye
    NATURAL JOIN codeimpaye
    WHERE numClient = :numClient";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
$stmt->execute();
$impayes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($impayes) > 0) {
    // Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
    $columns = array_keys($impayes[0]);
    // Conversion des lignes et colonnes en JSON
    $impayes_json = json_encode($impayes);
    $columns_json = json_encode($columns);
} else {
    $impayes_json = "{}";
    $columns_json = "{}";
}

?>