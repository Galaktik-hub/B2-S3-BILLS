<?php

    $numClient = $_SESSION['numClient'];
    $date = date('Y-m-d');

    $query = "
        SELECT 
            numRemise as 'N° Remise', 
            dateRemise as 'Date de Remise', 
            numSiren as 'N° Siren', 
            raisonSociale as 'Raison Sociale', 
            nbrTransaction as 'Nombre de Transactions', 
            montantTotal as 'Montant Total', 
            devise as Devise 
        FROM remise NATURAL JOIN client 
        WHERE numClient = :numClient ";


    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();
    $remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(empty($remises)){
        $columns = '';
        $remises_json = json_encode($remises);
        $columns_json = json_encode($columns);
    } else{
        $columns = array_keys($remises[0]);
        $remises_json = json_encode($remises);
        $columns_json = json_encode($columns);
    }
?>