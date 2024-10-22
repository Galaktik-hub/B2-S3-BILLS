<?php

    $query = "
        SELECT
            numSiren as 'N° Siren',
            raisonSociale as 'Raison Sociale',
            sum(montant) AS Montant
        FROM
            client
        NATURAL JOIN remise
        NATURAL JOIN transaction
        WHERE montant < 0";

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $impayes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($impayes[0]);

    $impayes_json = json_encode($impayes);
    $columns_json = json_encode($columns);

?>