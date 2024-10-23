<?php

    $query = "
        SELECT 
            numClient as 'N° Client', 
            numSiren as 'N° Siren', 
            raisonSociale as 'Raison Sociale', 
            loginClient as 'Identifiant' 
        FROM client";

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($clients[0]);

    $clients_json = json_encode($clients);
    $columns_json = json_encode($columns);

?>