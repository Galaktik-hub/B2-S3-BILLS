<?php
global $dbh, $key;
session_start();
include('../include/function.php');
include('../credentials/recaptcha.php');

// Vérification si un utilisateur est déjà connecté et redirection en fonction du rôle
if(isset($_SESSION['isAdmin'])){
    // Redirection vers la page admin si l'utilisateur est admin mais pas Product Owner
    if($_SESSION['isAdmin'] && !$_SESSION['isProductOwner']){
        header('Location: admin.php');
        exit;
    }
    // Redirection vers la page Product Owner si l'utilisateur est Product Owner
    else if($_SESSION['isAdmin'] && $_SESSION['isProductOwner']){
        header('Location: productOwner.php');
        exit;
    }
    // Redirection vers la page d'accueil si l'utilisateur n'est ni admin ni Product Owner (donc Commerçant)
    else {
        header('Location: home.php');
        exit;
    }
}

// Vérification de la soumission du formulaire de connexion
if(isset($_POST['login'])){
    $recaptchaResponse = $_POST['g-recaptcha-response']; // La réponse du reCAPTCHA
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
        $captchaError = false;

        include('../include/connexion.php');

        // Récupération des informations utilisateur
        $login = $_POST['login'];
        $password  = $_POST['password'];
        // Hachage du mot de passe avec SHA256
        $pwd_hash = hash('sha256',$password);

        // Requête pour récupérer tous les clients
        $request = 'SELECT * FROM client;';
        $resultLoginsUser = $dbh->query($request);

        // Requête pour récupérer tous les admins
        $request = 'SELECT * FROM admin;';
        $resultLoginsAdmin = $dbh->query($request);

        // Compteur pour limiter le nombre de tentatives de connexion
        if (!isset($_SESSION['limitation'])) {
            // Initialisation à 1 si aucune tentative précédente
            $_SESSION['limitation'] = 1;
        }
        else {
            $_SESSION['limitation'] = $_SESSION['limitation'] +1;
        }

        // Vérification des identifiants pour les utilisateurs
        while($line=$resultLoginsUser->fetch()){
            if(($login == $line['loginClient']) && ($pwd_hash == $line['passwordClient'])) {
                $resultLoginsUser->closeCursor(); // Fermeture du curseur après une correspondance

                // Enregistrement des informations dans la session
                $_SESSION['numClient'] = $line['numClient'];
                $_SESSION['raisonSociale'] = $line['raisonSociale'];
                $_SESSION['numSiren'] = $line['numSiren'];
                // L'utilisateur n'est pas un admin
                $_SESSION['isAdmin'] = false;
                $_SESSION['limitation'] = 0;
                // Redirection vers la page d'accueil
                header('Location: home.php');
                exit;
            }
        }

        // Vérification des identifiants pour les admins
        while($line=$resultLoginsAdmin->fetch()) {
            if (($login == $line['loginAdmin']) && ($pwd_hash == $line['passwordAdmin'])) {
                $resultLoginsAdmin->closeCursor(); // Fermeture du curseur après une correspondance

                // Initialisation des variables de session pour l'admin
                $_SESSION['numClient'] = null;
                $_SESSION['isProductOwner'] = $line['isProductOwner'];

                // Si l'admin est également Product Owner, on le définit comme tel
                if ($_SESSION['isProductOwner']) {
                    $_SESSION['raisonSociale'] = "Product Owner";
                } else {
                    $_SESSION['raisonSociale'] = "ADMIN";
                }
                // L'utilisateur est un admin
                $_SESSION['isAdmin'] = true;
                // Redirection vers la page d'admin
                header('Location: admin.php');
                exit;
            }
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

        <title>Connexion</title>
    </head>
    <body>

        <!-- Appel de la fonction pour afficher le header -->
        <?php head_login()?>

        <div class="text_center">
            <form class="form-signin" action="index.php" method="post">
                <h1 class="petit_titre">Connexion</h1>
                <label for="inputEmail" class="sr-only">Identifiant</label>
                <input type="text" id="inputEmail" class="form-control mb-1 mt-3" placeholder="Identifiant" name="login" required autofocus>
                <label for="inputPassword" class="sr-only">Mot de passe</label>
                <div class="mdp">
                    <input type="password" id="inputPassword" class="form-control mb-4" placeholder="Mot de passe" name="password" required>
                    <!-- Icône d'œil pour afficher/cacher le mot de passe -->
                    <svg id ="oeil" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash oeil-login" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z"/>
                        <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                    </svg>
                </div>
                <!-- reCaptcha Google -->
                <div class="g-recaptcha" data-sitekey="6Lcl_pIqAAAAAHEcRzGdYDvjUOoJMMluexYWr-BV"></div>
                <button class="connect" type="submit">Se connecter</button>
            </form>
            <p>Mot de passe oublié ? Cliquez <a href="motDePasseOublie.php">ici</a>.</p>
        </div>

        <!-- Script pour l'affichage du mot de passe -->
        <script src="../js/oeil.js"></script>

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
        if(isset($_POST['login'])){
            // Vérification du nombre d'essais et gestion des erreurs
            // Change "3" dans les conditions pour modifier le nombre de tentatives autorisées avant de bloquer
            if ($captchaError) {
                // Si le reCAPTCHA n'est pas validé, on affiche un message d'erreur
                echo "<div class='d-flex justify-content-center'><p class='erreur alert alert-warning w-50'>Veuillez valider le reCAPTCHA avant de vous connecter.</p></div>";
            }
            // Si le nombre de tentatives est inférieur à 3, on affiche un message d'erreur avec le nombre d'essais restants
            if ((isset($_SESSION['limitation'])) && ($_SESSION['limitation'] < 3)) {
                echo "<div class='d-flex justify-content-center'><p class='erreur alert alert-warning w-50'>Mauvais identifiant ou mot de passe, encore ";
                // Calcul du nombre d'essais restants
                echo 3-$_SESSION['limitation'];
                echo ' essai(s)</p></div>';
            }
            // Si le nombre de tentatives est supérieur ou égal à 3, on affiche un message d'erreur et on bloque l'utilisateur pendant 30 secondes
            if ((isset($_SESSION['limitation'])) && ($_SESSION['limitation'] >= 3)) {
                echo "<div class='d-flex justify-content-center'><p class='erreur alert alert-danger w-50'>Vous devez attendre 30 secondes avant de recommencer</p></div>";
                // Libération de la mémoire tampon de sortie et exécution de flush() pour forcer l'affichage du message
                ob_end_flush();
                flush();
                // On met en pause l'exécution pendant 30 secondes
                sleep(30);
                // Réinitialisation du compteur de tentatives après la période d'attente
                $_SESSION['limitation'] = 0;
            }
        }
        ?>
    </body>
</html>
