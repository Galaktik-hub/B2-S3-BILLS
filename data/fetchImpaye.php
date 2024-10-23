<?php

    $numClient = $_SESSION['numClient'];
    $date = date('Y-m-d');

    $query = "
        SELECT
            dateRemise as 'Date de Remise',
            numCarte as 'N° Carte',
            reseau as 'Réseau',
            numDossierImpaye as 'N° Dossier',
            transaction.devise as Devise,
            montant as 'Montant',
            libelleImpaye as 'Libelle'
        FROM
            remise as Remise
        NATURAL JOIN transaction
        NATURAL JOIN impaye as Impaye
        NATURAL JOIN codeimpaye
        WHERE numClient = :numClient";

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();
    $impayes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columns = array_keys($impayes[0]);

    $impayes_json = json_encode($impayes);
    $columns_json = json_encode($columns);

?>