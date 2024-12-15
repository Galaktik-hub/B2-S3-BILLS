<?php

// Définition de la requête SQL pour récupérer les remises et informations associées
$query = "
    SELECT 
        numSiren as 'N° Siren', 
        numRemise as 'N° Remise', 
        dateRemise as 'Date de Remise',
        raisonSociale as 'Raison Sociale', 
        nbrTransaction as 'Nombre de Transactions', 
        montantTotal as 'Montant Total', 
        devise as Devise 
        FROM remise NATURAL JOIN client";

$stmt = $dbh->prepare($query);
$stmt->execute();
$remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($remises[0]);

// Conversion des remises en JSON
$remises_json = json_encode($remises);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);

?>