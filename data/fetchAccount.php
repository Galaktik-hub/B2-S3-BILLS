<?php
    if (isset($_SESSION['numClient'])){
        $numClient = $_SESSION['numClient'];
    }

    // Si le PO veut voir la page du point de vue d'un client
    if (isset($_SESSION['PO_VIEW_CLIENT'])){
        $numClient = $_SESSION['PO_VIEW_CLIENT'];
    }

    try {
        $req = $dbh->prepare('SELECT numSiren, raisonSociale, loginClient, mail FROM client WHERE numClient = :numClient');

        $req->bindParam(':numClient', $numClient, PDO::PARAM_INT);
        $req->execute();
        $client = $req->fetch(PDO::FETCH_ASSOC);

        // Si des données client sont trouvées, les assigner à des variables pour l'affichage
        if($client) {
            $siren = $client['numSiren'];
            $raisonSociale = $client['raisonSociale'];
            $loginClient = $client['loginClient'];
            $mail = $client['mail'];
        } else {
            echo "Erreur : Impossible de récupérer les informations du compte.";
        }
    } catch (Exception $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

    $successMsg = $errorMsg = "";

    // Vérification si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération de ses nouvelles informations pour traitements
        $new_mail = !empty($_POST['mail']) ? $_POST['mail'] : null;
        $new_mdp = !empty($_POST['new_mdp']) ? $_POST['new_mdp'] : null;
        $new_repeatmdp = !empty($_POST['repeatmdp']) ? $_POST['repeatmdp'] : null;

        // Vérification de la correspondance des mots de passe
        if ($new_mdp !== $new_repeatmdp) {
            $errorMsg = "<p class='error'>Les mots de passe ne correspondent pas.</p>";
        } else {
            $query = "UPDATE client SET ";
            $fields = []; // Liste des champs à mettre à jour

            if ($new_mail && $new_mail !== $mail) {
                $fields[] = "mail = :mail";
            }
            if ($new_mdp) {
                $hashed_password = hash('sha256', $new_mdp);
                $fields[] = "passwordClient = :new_mdp";
            }

            // Exécute la mise à jour si au moins un champ est modifié
            if (!empty($fields)) {
                // Génération de la requête finale
                $query .= implode(', ', $fields) . " WHERE numClient = :numClient";
                $stmt = $dbh->prepare($query);

                // Liaisons des paramètres nécessaires
                if ($new_mail && $new_mail !== $mail) {
                    $stmt->bindParam(':mail', $new_mail);
                }
                if ($new_mdp && $new_mdp === $new_repeatmdp) {
                    $stmt->bindParam(':new_mdp', $hashed_password);
                }

                $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);

                // Exécution de la requête et gestion des messages utilisateur
                if ($stmt->execute()) {
                    $successMsg = "<p class='success'>Informations mises à jour avec succès.</p>";
                    // Met à jour l'email localement si la mise à jour est réussie
                    $mail = $new_mail;
                } else {
                    $errorMsg = "<p class='error'>Erreur lors de la mise à jour des informations.</p>";
                }
            }
        }
    }
?>