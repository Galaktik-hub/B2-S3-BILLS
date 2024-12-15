<?php
global $dbh, $key;
session_start();
include('../include/function.php');
include('../credentials/recaptcha.php');

// Vérification de l'état de l'admin dans la session
if(isset($_SESSION['isAdmin'])){
    // Si l'utilisateur est un admin mais pas un PO, il est redirigé vers la page admin
    if($_SESSION['isAdmin'] && !$_SESSION['isProductOwner']){
        header('Location: admin.php');
        exit;
    }
    // Si l'utilisateur est à la fois admin et PI, il est redirigé vers la page productOwner
    else if($_SESSION['isAdmin'] && $_SESSION['isProductOwner']){
        header('Location: productOwner.php');
        exit;
    }
    else {
        header('Location: home.php');
        exit;
    }
}

// Si le formulaire est soumis (login est défini)
if(isset($_POST['login'])) {
    // Récupère la réponse du reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptchaSecret = $key; // Clé secrète reCAPTCHA

    // Validation de la réponse avec l'API Google
    $recaptchaVerify = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}"
    );
    $recaptchaVerify = json_decode($recaptchaVerify, true);

    // Vérifiez le statut de succès
    if (!$recaptchaVerify['success']) {
        $captchaError = true;
    } else {
        // Si la validation reCAPTCHA réussit, on continue le processus
        $captchaError = false;

        include('../include/connexion.php');
        include('../mail/sendMail.php');

        // Recherche du login dans la base de données
        $login = $_POST['login'];
        $request = 'SELECT * FROM client;';
        $result = $dbh->query($request);

        // Génération d'un mot de passe aléatoire et de son hash
        $random_mdp = create_random_password();
        $pwd_hash = hash('sha256', $random_mdp);

        try {
            // Parcours des résultats de la requête pour vérifier si le login existe
            while ($line = $result->fetch()) {
                if ($login == $line['loginClient']) {
                    // Si le login existe, on récupère le numéro client
                    $numClient = $line['numClient'];

                    // Insertion du mot de passe temporaire dans la table mdptemp
                    $insert_mdp_temp = $dbh->prepare("INSERT INTO `mdptemp` (`numClient`, `mail`, `pw`) VALUES (:unumclient, :umail, :upw);");
                    $insert_mdp_temp->execute(array(':unumclient' => $numClient, ':umail' => $line['mail'], ':upw' => $pwd_hash));

                    // Envoi d'un email avec les instructions de réinitialisation du mot de passe
                    sendmail($line['mail'], subjectModificationMdp(), bodyModificationMdp($pwd_hash));
                }
            }
        } catch (Exception $e) {
            echo "<p class='error'>" . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- Favico -->
        <link rel="icon" href="../image/logo.ico" type="image/x-icon">

        <!-- Bootstrap core CSS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

        <!-- Custom styles for this template -->
        <link href="../css/connexion.css" rel="stylesheet">
        <link rel="preload" href="../image/fond_accueil.jpg" as="image">

        <title>Mot de passe oublié</title>
    </head>
    <body>

        <!-- Appel de la fonction pour afficher le header -->
        <?php head_login()?>
        <div class="text_center">
            <form class="form-signin" action="motDePasseOublie.php" method="post">
                <h1 class="petit_titre">Mot de passe oublié</h1>
                <label for="inputEmail" class="sr-only">Identifiant</label>
                <input type="text" id="inputEmail" class="form-control mb-1 mt-3" placeholder="Identifiant" name="login" required autofocus>
                <div class="g-recaptcha" data-sitekey="6Lcl_pIqAAAAAHEcRzGdYDvjUOoJMMluexYWr-BV"></div>
                <button class="connect" type="submit">Se connecter</button>
            </form>
        </div>

        <!-- Footer avec des liens vers les profils LinkedIn -->
        <footer>
            <div class='contains d-flex justify-content-around align-items-center'>
                <p><a href='https://www.linkedin.com/in/alexis-telle/' id='linkedIn' target='_blank'>Alexis Telle</a></p>
                <p><a href='https://www.linkedin.com/in/julien-synaeve/' target='_blank'>Julien Synaeve</a></p>
                <p><a href='https://www.linkedin.com/in/champaulta/' target='_blank'>Alexis Champault</a></p>
                <p><a href='https://www.linkedin.com/in/elankeethan/' target='_blank'>Kirushikesan</a></p>
                <p><a href='https://www.linkedin.com/in/victorsts/' target='_blank'>Victor Santos</a></p>
            </div>
        </footer>
        <?php
        // Affichage du message de succès ou d'erreur après soumission du formulaire
        if(isset($_POST['login'])){
            if ($captchaError) {
                echo "<div class='d-flex justify-content-center'><p class='erreur alert alert-warning w-50'>Veuillez valider le reCAPTCHA.</p></div>";
            } else {
                echo "<div class='d-flex justify-content-center'><p class='erreur alert alert-success w-50'>Un mail avec les instructions pour réinitialiser votre
                  mot de passe vous a été envoyé.</p></div>";
            }
        }
        ?>
    </body>
</html>
