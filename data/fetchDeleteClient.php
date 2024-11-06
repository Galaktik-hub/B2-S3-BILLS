<?php
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
if(empty($client)){
    $client = [];
}else{
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
}




?>