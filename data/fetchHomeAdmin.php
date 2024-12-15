<?php
$numClient = $_GET["numClient"];

// Prépare la requête SQL pour récupérer les détails du client avec l'identifiant numClient
$query = "
    SELECT 
        numClient as 'N° Client', 
        numSiren as 'N° Siren', 
        raisonSociale as 'Raison Sociale', 
        loginClient as 'Identifiant' 
    FROM client 
    WHERE numClient = :numClient";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
$stmt->execute();
$client = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si aucun client n'est trouvé, redirige vers la page admin.php
if(empty($client)) {
    header("Location: admin.php");
    exit();
}

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$column = array_keys($client[0]);

// Conversion des clients en JSON
$client_json = json_encode($client);
// Conversion des colonnes en JSON
$column_json = json_encode($column);

?>