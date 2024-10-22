<?php
session_start();
include('function.php');
include('connexion.php');
include('navbar.php');
checkIsUser();

try {
    $req = $dbh->prepare('SELECT numSiren, raisonSociale, loginClient, mail FROM client WHERE numClient = :numClient');

    $req->bindParam(':numClient', $_SESSION['numClient'], PDO::PARAM_INT);
    $req->execute();
    $client = $req->fetch(PDO::FETCH_ASSOC);

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = !empty($_POST['mail']) ? $_POST['mail'] : null;
    $identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : null;
    $mdp = !empty($_POST['mdp']) ? $_POST['mdp'] : null;
    $repeatmdp = !empty($_POST['repeatmdp']) ? $_POST['repeatmdp'] : null;

    if ($mdp !== $repeatmdp) {
        $errorMsg = "<p class='error'>Les mots de passe ne correspondent pas.</p>";
    } else {
        $query = "UPDATE client SET ";
        $fields = [];

        if ($mail) {
            $fields[] = "mail = :mail";
        }
        if ($raisonSociale) {
            $fields[] = "raisonSociale = :raisonSociale";
        }
        if ($identifiant) {
            $fields[] = "loginClient = :loginClient";
        }
        if ($mdp) {
            $hashed_password = hash('sha256', $mdp);
            $fields[] = "passwordClient = :mdp";
        }

        if (!empty($fields)) {
            $query .= implode(', ', $fields) . " WHERE numClient = :numClient";
            $stmt = $dbh->prepare($query);

            // Lier les valeurs aux paramètres de la requête
            if ($mail) {
                $stmt->bindParam(':mail', $mail);
            }
            if ($raisonSociale) {
                $stmt->bindParam(':raisonSociale', $raisonSociale);
            }
            if ($identifiant) {
                $stmt->bindParam(':loginClient', $identifiant);
            }
            if ($mdp) {
                $stmt->bindParam(':mdp', $hashed_password);
            }

            $stmt->bindParam(':numClient', $_SESSION['numClient'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                $successMsg = "<p class='success'>Informations mises à jour avec succès.</p>";
            } else {
                $errorMsg = "<p class='error'>Erreur lors de la mise à jour des informations.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/account.css">
    <title>Espace Client</title>
</head>
<body>

<div class="form-container">
    <h1>Compte Client</h1>

    <form method="POST" action="">
        <div class="form-group">
            <label for="siren">Siren</label>
            <input type="text" id="siren" name="siren" value="<?php echo $siren ?>" placeholder="Entrer le Siren" disabled>
        </div>

        <div class="form-group">
            <label for="raisonSociale">Raison Sociale</label>
            <input type="text" id="raisonSociale" name="raisonSociale" value="<?php echo $raisonSociale ?>" placeholder="Entrer la Raison Sociale" disabled>
        </div>

        <div class="form-group">
            <label for="identifiant">Identifiant</label>
            <input type="text" id="identifiant" name="identifiant" value="<?php echo $loginClient ?>" placeholder="Entrer l'Identifiant" disabled>
        </div>

        <div class="form-group">
            <label for="mail">Adresse mail</label>
            <input type="text" id="mail" name="mail" value="<?php echo $mail ?>" placeholder="Entrer votre adresse mail">
        </div>

        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" placeholder="Entrer le mot de passe">
        </div>

        <div class="form-group">
            <label for="repeatmdp">Confirmer le mot de passe</label>
            <input type="password" id="repeatmdp" name="repeatmdp" placeholder="Répéter le mot de passe">
        </div>

        <button type="submit" class="btn-submit">Mettre à jour</button>
        <?php
        if (!empty($errorMsg)) {
            echo $errorMsg;
        }

        if (!empty($successMsg)) {
            echo $successMsg;
        }
        ?>
    </form>
</div>

</body>
</html>
