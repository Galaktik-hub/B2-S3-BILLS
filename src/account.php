<?php
    session_start();
    include('../include/function.php');
    include('../include/connexion.php');
    include('../include/navbar.php');
    checkIsUser();
    include('../data/fetchAccount.php');

    $is_disabled = "";
    if (isset($_SESSION['PO_VIEW_CLIENT']) || $_SESSION['numClient'] == 1) {
        $is_disabled = " disabled";
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
        <script>
            // Script JavaScript pour vérifier la correspondance des mots de passe
            document.addEventListener("DOMContentLoaded", function() {
                // Initialisation des éléments HTML nécessaires
                const mailField = document.getElementById("mail");
                const newMdpField = document.getElementById("new_mdp");
                const repeatMdpField = document.getElementById("repeatmdp");
                const updateButton = document.querySelector(".btn-submit");
                const initialMail = "<?php echo $mail ?>";
                const errorMsg = document.querySelector('.error');

                // Vérifie si des changements ont été faits sur l'adresse email ou le mot de passe
                function checkForChanges() {
                    const mailChanged = mailField.value !== initialMail;
                    const passwordEntered =
                        newMdpField.value === repeatMdpField.value &&
                        newMdpField.value !== "";

                    // Active ou désactive le bouton en fonction des changements détectés
                    updateButton.disabled = !(mailChanged || passwordEntered);
                }

                // Fonction pour valider visuellement la correspondance des mots de passe
                function checkPasswordsMatch() {
                    if (newMdpField.value !== "" && newMdpField.value === repeatMdpField.value) {
                        // Bordure verte si les mots de passe correspondent
                        repeatMdpField.style.borderColor = "green";
                        // Cache le message d'erreur
                        errorMsg.hidden = true;
                    } else if (repeatMdpField.value !== "") {
                        // Bordure rouge si les mots de passe diffèrent
                        repeatMdpField.style.borderColor = "red";
                        errorMsg.hidden = false;
                    } else {
                        // Réinitialise les bordures si aucun mot de passe
                        repeatMdpField.style.borderColor = "";
                        errorMsg.hidden = true;
                    }
                }

                // Ajout des événements pour surveiller les saisies utilisateur
                mailField.addEventListener("input", checkForChanges);
                newMdpField.addEventListener("input", () => {
                    checkForChanges();
                    checkPasswordsMatch();
                });
                repeatMdpField.addEventListener("input", () => {
                    checkForChanges();
                    checkPasswordsMatch();
                });

                // Désactive le bouton par défaut
                updateButton.disabled = true;
            });
        </script>

        <div class="form-container">
            <h1>Compte Client</h1>
            <?php
            if (isset($_SESSION['PO_VIEW_CLIENT'])) {
                // Message informatif en mode visualisation PO
                echo "<h4>Vous ne pouvez pas modifier les informations du client en mode visualisation.</h4>";
            }
            ?>

            <!-- Formulaire pour modifier les informations du compte -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="siren">Siren</label>
                    <input type="text" id="siren" name="siren" value="<?php echo $siren ?>" placeholder="Entrer le Siren" disabled> <!-- Champ non modifiable -->
                </div>

                <div class="form-group">
                    <label for="raisonSociale">Raison Sociale</label>
                    <input type="text" id="raisonSociale" name="raisonSociale" value="<?php echo $raisonSociale ?>" placeholder="Entrer la Raison Sociale" disabled> <!-- Champ non modifiable -->
                </div>

                <div class="form-group">
                    <label for="identifiant">Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant" value="<?php echo $loginClient ?>" placeholder="Entrer l'Identifiant" disabled> <!-- Champ non modifiable -->
                </div>

                <div class="form-group">
                    <label for="mail">Adresse mail</label>
                    <input type="email" id="mail" name="mail" value="<?php echo $mail ?>" placeholder="Entrer votre adresse mail" <?php echo $is_disabled; ?>>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="new_mdp" name="new_mdp" placeholder="Entrer le mot de passe" <?php echo $is_disabled; ?>>
                </div>

                <div class="form-group">
                    <label for="repeatmdp">Confirmer le mot de passe</label>
                    <input type="password" id="repeatmdp" name="repeatmdp" placeholder="Répéter le mot de passe" <?php echo $is_disabled; ?>>
                </div>

                <p class='error' hidden>Les mots de passe ne correspondent pas.</p>
                <?php
                    // Affichage des messages d'erreur ou de succès s'ils existent
                    if (!empty($errorMsg)) {
                        echo $errorMsg;
                    }

                    if (!empty($successMsg)) {
                        echo $successMsg;
                    }
                ?>
                <button type="submit" class="btn-submit">Mettre à jour</button>

            </form>
        </div>
    </body>
</html>
