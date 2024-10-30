<?php
global $dbh;
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include("../mail/sendMail.php");
checkIsAdmin();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">

        <title>Espace Admin</title>
    </head>
    <body>
        <?php
        if($_SESSION['isProductOwner']==0){
            $po=0;
        }
        else{
            $po=1;
        }
         ?>
         <h3 class="titre">Insérer un client</h3>
         <div class="client">
            <form action="insertClient.php" method="POST">
                <table class="tab">
                    <tr>
                        <th>Siren</th>
                        <td><input type="text" minlength="9" maxlength="9" name="numSiren" required></td>
                    </tr>
                    <tr>
                        <th>Raison Sociale</th>
                        <td><input type="text" name="raisonSociale" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <th>Identifiant</th>
                        <td><input type="text" name="loginClient" maxlength="50" required></td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td><input type="email" name="mailClient" required></td>
                    </tr>
                    <tr>
                        <td class="lien"><input type="reset" value="Annuler" class="interact"></td>
                        <td class="lien"><input type="submit" value="Ajouter" class="interact"></td>
                    </tr>
                    </table>
                </form>
        </div>
    </body>
</html>

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

            echo "<div class='alert alert-success w-25' role='alert'>Insertion du client réussi</div>";
        }
    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
    }
}
?>