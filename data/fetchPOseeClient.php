<?php

if (!empty($clients)) {
    $clientDetailsSuppression = $clients[0];
}

// Si le formulaire de mise à jour est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateClient'])) {
    $numSiren = $_POST['numSiren'];
    $raisonSociale = $_POST['raisonSociale'];
    $loginClient = $_POST['loginClient'];

    $request = "UPDATE client SET numSiren = :numSiren, raisonSociale = :raisonSociale, loginClient = :loginClient WHERE numClient = :numClient";
    $stmt = $dbh->prepare($request);
    $stmt->bindParam(':numSiren', $numSiren);
    $stmt->bindParam(':raisonSociale', $raisonSociale);
    $stmt->bindParam(':loginClient', $loginClient);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();

    // Redirige pour vider les données POST et afficher un message de confirmation
    header("Location: productOwnerSeeClient.php?numClient=" . $numClient . "&updateSuccess=1");
    exit;
}

// Si la demande de suppression est confirmée
if (isset($_POST['check']) && isset($_POST['justificatif'])) {
    $justificatif = $_POST['justificatif'];
    $request = "INSERT INTO suppression (numClient, dateDemande, justificatif) VALUES (:numClient, CURDATE(), :justificatif)";
    $stmt = $dbh->prepare($request);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->bindParam(':justificatif', $justificatif);
    $stmt->execute();

    $stmtMail = $dbh->prepare("SELECT mail FROM admin WHERE isProductOwner = 0");
    $stmtMail->execute();

    $adminMails = $stmtMail->fetchAll(PDO::FETCH_ASSOC);

    foreach ($adminMails as $admin) {
        sendmail($admin['mail'], subjectDeletionClient(), bodyDeletionClient($numClient));
    }

    // Redirige pour vider les données POST et afficher la demande de suppression
    header("Location: productOwnerSeeClient.php?numClient=" . $numClient . "&deleteSuccess=1");

    exit;
}

// Si l'action est "loginAsClient", définir la variable de session et rediriger
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connectClient'])) {
    $_SESSION["PO_VIEW_CLIENT"] = $numClient; // Set session variable
    header("Location: home.php"); // Redirect to home.php
    exit;
}
