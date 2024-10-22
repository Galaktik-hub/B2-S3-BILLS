<?php
session_start();
include('function.php');
include('connexion.php');
include('navbar.php');
checkIsUser();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siren = !empty($_POST['siren']) ? $_POST['siren'] : null;
    $raisonSociale = !empty($_POST['raisonSociale']) ? $_POST['raisonSociale'] : null;
    $identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : null;
    $motDePasse = !empty($_POST['motDePasse']) ? $_POST['motDePasse'] : null;
    $repeatMotDePasse = !empty($_POST['repeatMotDePasse']) ? $_POST['repeatMotDePasse'] : null;

    // Validation des mots de passe
    if ($motDePasse !== $repeatMotDePasse) {
        echo "<p class='error'>Les mots de passe ne correspondent pas.</p>";
    } else {
        // Mise à jour ou ajout du client dans la base de données selon les champs remplis
        $query = "UPDATE clients SET ";
        $fields = [];

        if ($siren) {
            $fields[] = "siren = '$siren'";
        }
        if ($raisonSociale) {
            $fields[] = "raison_sociale = '$raisonSociale'";
        }
        if ($identifiant) {
            $fields[] = "identifiant = '$identifiant'";
        }
        if ($motDePasse) {
            $hashed_password = password_hash($motDePasse, PASSWORD_DEFAULT);
            $fields[] = "mot_de_passe = '$hashed_password'";
        }

        if (!empty($fields)) {
            $query .= implode(', ', $fields) . " WHERE client_id = ".$_SESSION['client_id'];
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<p class='success'>Informations mises à jour avec succès.</p>";
            } else {
                echo "<p class='error'>Erreur lors de la mise à jour des informations.</p>";
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
    <title>Modifier Informations Client</title>
</head>
<body>

<div class="form-container">
    <h1>Ajouter/Modifier Client</h1>

    <form method="POST" action="">
        <div class="form-group">
            <label for="siren">Siren :</label>
            <input type="text" id="siren" name="siren" placeholder="Entrer le Siren">
        </div>

        <div class="form-group">
            <label for="raisonSociale">Raison Sociale :</label>
            <input type="text" id="raisonSociale" name="raisonSociale" placeholder="Entrer la Raison Sociale">
        </div>

        <div class="form-group">
            <label for="identifiant">Identifiant :</label>
            <input type="text" id="identifiant" name="identifiant" placeholder="Entrer l'Identifiant">
        </div>

        <div class="form-group">
            <label for="motDePasse">Mot de passe :</label>
            <input type="password" id="motDePasse" name="motDePasse" placeholder="Entrer le mot de passe">
        </div>

        <div class="form-group">
            <label for="repeatMotDePasse">Répéter le mot de passe :</label>
            <input type="password" id="repeatMotDePasse" name="repeatMotDePasse" placeholder="Répéter le mot de passe">
        </div>

        <button type="submit" class="btn-submit">Mettre à jour</button>
    </form>
</div>

</body>
</html>
