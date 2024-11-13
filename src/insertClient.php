<?php
global $dbh;
session_start();
include('../include/function.php');
include('../include/connexion.php');
include("../include/navbar.php");
include("../mail/sendMail.php");
checkIsAdmin();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/insertClient.css">

        <title>Espace Admin</title>
    </head>
    <body>
        <div class="page-container">
            <?php
            if($_SESSION['isProductOwner']==0){
                $po=0;
            }
            else{
                $po=1;
            }
             ?>
            <div class="page-content">
                <h1 class="titre">Insérer un client</h1>

                <form action="insertClient.php" method="POST">
                    <div class="form-group">
                        <label for="numSiren">Siren</label>
                        <input type="text" id="numSiren" minlength="9" maxlength="9" name="numSiren" required placeholder="Entrer le numéro siren">
                    </div>
                    <div class="form-group">
                        <label for="raisonSociale">Raison sociale</label>
                        <input type="text" id="raisonSociale" name="raisonSociale" maxlength="20" required placeholder="Entrer la raison sociale">
                    </div>
                    <div class="form-group">
                        <label for="loginClient">Login client</label>
                        <input type="text" id="loginClient" name="loginClient" maxlength="50" required placeholder="Entrer le login client">
                    </div>
                    <div class="form-group">
                        <label for="mailClient">Email</label>
                        <input type="email" id="mailClient" name="mailClient" required placeholder="Entrer l'email">
                    </div>
                    <div class="buttons">
                        <input type="reset" value="Annuler" class="interact">
                        <input type="submit" value="Ajouter" class="interact">
                    </div>

                    <?php
                    if (isset($_POST['numSiren']) && isset($_POST['raisonSociale']) && isset($_POST['loginClient']) && isset($_POST['mailClient'])) {
                        $siret = $_POST['numSiren'];
                        $rs = $_POST['raisonSociale'];
                        $login = $_POST['loginClient'];
                        $email = $_POST['mailClient'];
                        $random_mdp = create_random_password();
                        $pw = hash('sha256', $random_mdp);

                        // Préparation de l'insertion dans la table client
                        $insert = $dbh->prepare("INSERT INTO `client` (`numClient`, `numSiren`, `loginClient`, `passwordClient`, `raisonSociale`, `mail`) VALUES (NULL, :usiret, :ulogin, :upw, :urs, :umail);");

                        try {
                            if ($insert->execute(array(':usiret' => $siret, ':ulogin' => $login, ':upw' => $pw, ':urs' => $rs, ':umail' => $email))) {
                                $numClient = $dbh->lastInsertId();

                                $insert_mdp_temp = $dbh->prepare("INSERT INTO `mdptemp` (`numClient`, `mail`, `pw`) VALUES (:unumclient, :umail, :upw);");
                                $insert_mdp_temp->execute(array(':unumclient' => $numClient, ':umail' => $email, ':upw' => $pw));

                                sendmail($email, subjectCreationMdp(), bodyCreationMdp($pw));

                                echo "<p class='success'>Insertion du client réussie !</p>";
                            }
                        } catch (Exception $e) {
                            echo "<p class='error'>" . $e->getMessage() . "</p>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>