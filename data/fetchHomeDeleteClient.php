<?php

$query = "
    SELECT
        numClient as 'N° Client',
        dateDemande as 'Date de la demande',
        justificatif as 'Justificatif'
    FROM suppression";


$stmt = $dbh->prepare($query);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$columns = array_keys($clients[0]);

$clients_json = json_encode($clients);
$columns_json = json_encode($columns);

?>