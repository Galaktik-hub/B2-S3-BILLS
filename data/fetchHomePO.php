<?php
// Exécution de la requête SQL pour récupérer les informations des clients
$query = "
    SELECT 
        numClient as 'N° Client', 
        numSiren as 'N° Siren', 
        raisonSociale as 'Raison Sociale', 
        loginClient as 'Identifiant' 
    FROM client";

$stmt = $dbh->prepare($query);
$stmt->execute();

// Récupération des résultats sous forme de tableau associatif
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($clients[0]);

// Conversion des clients en JSON
$clients_json = json_encode($clients);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);

?>