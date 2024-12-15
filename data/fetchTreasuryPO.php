<?php

// Prépare la requête SQL pour récupérer les informations des clients et calculer leur trésorerie
$query = "
    SELECT numSiren as 'N° Siren', 
            raisonSociale 'Raison Sociale', 
    (SELECT devise FROM remise WHERE numClient=1 LIMIT 1) as Devise,
    COUNT(numRemise) AS 'Nombre de Remises', 
    COALESCE(SUM(montantTotal), 0) AS 'Montant Total'
    FROM remise RIGHT JOIN client 
        ON remise.numClient = client.numClient 
    GROUP BY client.numClient";

$stmt = $dbh->prepare($query);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($clients[0]);

// Conversion des clients en JSON
$clients_json = json_encode($clients);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);

?>