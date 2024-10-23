<?php

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

    $columns = array_keys($clients[0]);

    $clients_json = json_encode($clients);
    $columns_json = json_encode($columns);

?>