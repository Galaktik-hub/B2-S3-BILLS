<?php
    $numClient = $_GET["numClient"];
    $query = "
        SELECT 
            numClient as 'N° Client', 
            numSiren as 'N° Siren', 
            raisonSociale as 'Raison Sociale', 
            loginClient as 'Identifiant' 
        FROM client 
        WHERE numClient = :numClient";

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();
    $client = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($client)){
        header("Location: admin.php");
        exit();
    }
    $column = array_keys($client[0]);

    $client_json = json_encode($client);
    $column_json = json_encode($column);

?>