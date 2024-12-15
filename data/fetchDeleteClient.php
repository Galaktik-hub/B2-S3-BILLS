<?php
// Prépare la requête SQL pour récupérer les informations de suppression pour un client spécifique
$query = "
    SELECT
        numClient as 'N° Client',
        dateDemande as 'Date de la demande',
        justificatif as 'Justificatif'
    FROM suppression
    WHERE numClient = :numClient";

$stmt = $dbh->prepare($query);
$stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
$stmt->execute();

// Si la variable $client est vide (aucun résultat trouvé), initialise un tableau vide
if(empty($client)){
    $client = [];
}else{
    // Si des résultats sont trouvés, récupère les données sous forme de tableau associatif
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>