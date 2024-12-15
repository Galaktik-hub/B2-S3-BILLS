<?php

// Vérifie si la variable $clients est non vide et récupère les détails du premier client
if (!empty($clients)) {
    $clientDetailsSuppression = $clients[0];
}

// Si le formulaire de mise à jour est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateClient'])) {
    // Récupère les données du formulaire pour la mise à jour du client
    $numSiren = $_POST['numSiren'];
    $raisonSociale = $_POST['raisonSociale'];
    $loginClient = $_POST['loginClient'];

    // Requête SQL pour mettre à jour les informations du client
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

// Si la demande de suppression est confirmée (case cochée et justificatif fourni)
if (isset($_POST['check']) && isset($_POST['justificatif'])) {
    // Récupère le justificatif pour la suppression
    $justificatif = $_POST['justificatif'];

    // Insertion de la demande de suppression dans la base de données
    $request = "INSERT INTO suppression (numClient, dateDemande, justificatif) VALUES (:numClient, CURDATE(), :justificatif)";
    $stmt = $dbh->prepare($request);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->bindParam(':justificatif', $justificatif);
    $stmt->execute();

    // Récupère les mails des admins pour les notifier de la demande de suppression
    $stmtMail = $dbh->prepare("SELECT mail FROM admin WHERE isProductOwner = 0");
    $stmtMail->execute();

    $adminMails = $stmtMail->fetchAll(PDO::FETCH_ASSOC);

    // Envoi de l'email à chaque administrateur pour les informer de la demande de suppression
    foreach ($adminMails as $admin) {
        sendmail($admin['mail'], subjectDeletionClient(), bodyDeletionClient($numClient));
    }

    // Redirige pour vider les données POST et afficher la demande de suppression
    header("Location: productOwnerSeeClient.php?numClient=" . $numClient . "&deleteSuccess=1");

    exit;
}

// Si l'action est "loginAsClient", définit la variable de session et redirige vers l'accueil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connectClient'])) {
    // Définit la variable de session pour afficher le client
    $_SESSION["PO_VIEW_CLIENT"] = $numClient;
    // Redirige vers la page d'accueil
    header("Location: home.php");
    exit;
}
