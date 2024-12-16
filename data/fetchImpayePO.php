<?php

// Préparation de la requête SQL pour récupérer les impayés
$query = "
    SELECT
        numSiren as 'N° Siren',
        raisonSociale as 'Raison Sociale',
        sum(montant) AS Montant
    FROM
        client
    NATURAL JOIN remise
    NATURAL JOIN transaction
    WHERE montant < 0";

$stmt = $dbh->prepare($query);
$stmt->execute();
$impayes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($impayes[0]);

// Conversion des impayés en JSON
$impayes_json = json_encode($impayes);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);

?>