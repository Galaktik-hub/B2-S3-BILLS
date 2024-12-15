<?php
// Exécution de la requête SQL pour récupérer les informations de suppression des clients
$query = "
    SELECT
        numClient as 'N° Client',
        dateDemande as 'Date de la demande',
        justificatif as 'Justificatif'
    FROM suppression";

$stmt = $dbh->prepare($query);
$stmt->execute();

// Récupération des résultats sous forme de tableau associatif
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérification si la liste des clients est vide
if(empty($clients)){
    // Si aucun client n'est trouvé, les colonnes sont vides
    $columns = '';
    $clients_json = json_encode($clients);
    $columns_json = json_encode($columns);
}else{
    // Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
    $columns = array_keys($clients[0]);

    // Conversion des clients en JSON
    $clients_json = json_encode($clients);
    // Conversion des colonnes en JSON
    $columns_json = json_encode($columns);
}

?>