<?php

    $query = "
        SELECT 
            numSiren as 'N° Siren', 
            numRemise as 'N° Remise', 
            dateRemise as 'Date de Remise',
            raisonSociale as 'Raison Sociale', 
            nbrTransaction as 'Nombre de Transactions', 
            montantTotal as 'Montant Total', 
            devise as Devise 
            FROM remise NATURAL JOIN client";

    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($remises[0]);

    $remises_json = json_encode($remises);
    $columns_json = json_encode($columns);

?>