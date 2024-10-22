<?php

    $numClient = $_SESSION['numClient'];
    $date = date('Y-m-d');

    $query = "
        SELECT 
            (SELECT numSiren FROM client WHERE numClient = :numClient) as 'N° Siren', 
            (SELECT raisonSociale FROM client WHERE numClient = :numClient) as 'Raison Sociale', 
            (SELECT devise FROM remise WHERE numClient = :numClient LIMIT 1) as Devise,
            COUNT(numRemise) AS 'Nombre de Remises', 
            COALESCE(SUM(montantTotal), 0) AS 'Montant total' 
        FROM remise 
        WHERE numClient = :numClient";


    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();
    $remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($remises[0]);

    $remises_json = json_encode($remises);
    $columns_json = json_encode($columns);
?>