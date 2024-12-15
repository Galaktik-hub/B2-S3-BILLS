<?php

    if (isset($_SESSION['numClient'])){
        $numClient = $_SESSION['numClient'];
    }

    // Si le PO veut voir la page du point de vue d'un client
    if (isset($_SESSION['PO_VIEW_CLIENT'])){
        $numClient = $_SESSION['PO_VIEW_CLIENT'];
    }

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

    if (count($remises) > 0) {
        $columns = array_keys($remises[0]);
        $remises_json = json_encode($remises);
        $columns_json = json_encode($columns);
    } else {
        $remises_json = "{}";
        $columns_json = "{}";
    }
?>