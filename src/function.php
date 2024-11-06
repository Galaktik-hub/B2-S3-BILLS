<?php

function checkIsUser(){
    if(!(isset($_SESSION['numClient']))){
        header('Location: index.php');
    }
}

function checkIsAdmin(){
    if(!(isset($_SESSION['isAdmin'])) || !$_SESSION['isAdmin']){
        header('Location: index.php');
    }
}

function checkIsPO(){
    if(!(isset($_SESSION['isProductOwner'])) || !$_SESSION['isProductOwner']){
        header('Location: index.php');
    }
}

function head_login(){
    echo "
        <header class='superieur'>
            <h2 class='titre_h'> B.I.L.L.S. <h2>
        </header>
    ";
}

function nav_client() {
    $currentPage = basename($_SERVER['SCRIPT_NAME']);
    echo "
        <ul class='navigation-items'>
            <a href='home.php' class='nav-item " . ($currentPage == 'home.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/accueil.svg' alt='Icone Accueil' class='icon'>
                    <p>Accueil</p>
                </li>
            </a>
            <a href='remise.php' class='nav-item " . ($currentPage == 'remise.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/remises.svg' alt='Icone Remises' class='icon'>
                    <p>Remises</p>
                </li>
            </a>
            <a href='impaye.php' class='nav-item " . ($currentPage == 'impaye.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/impayés.svg' alt='Icone Impayés' class='icon'>
                    <p>Impayés</p>
                </li>
            </a>
            <a href='stats.php' class='nav-item " . ($currentPage == 'stats.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/stats.svg' alt='Icone Statistiques' class='icon'>
                    <p>Statistiques</p>
                </li>
            </a>
            <a href='account.php' class='nav-item " . ($currentPage == 'account.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/compte.svg' alt='Icone Compte' class='icon'>
                    <p>Compte</p>
                </li>
            </a>
        </ul>";
}

function nav_admin($po) {
    $currentPage = basename($_SERVER['SCRIPT_NAME']);
    echo "
        <ul class='navigation-items'>
            <a href='admin.php' class='nav-item " . ($currentPage == 'admin.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/settings.svg' alt='Icone Admin' class='icon'>
                    <p>Administration</p>
                </li>
            </a>
            <a href='insertClient.php' class='nav-item " . ($currentPage == 'insertClient.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/plus.svg' alt='Icone Ajouter Client' class='icon'>
                    <p>Nouveau client</p>
                </li>
            </a>";

    if ($po == 0) {
        echo "
            <a href='deleteClientHome.php' class='nav-item " . ($currentPage == 'deleteClientHome.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/cross_mark.svg' alt='Icone Suppression Clients' class='icon'>
                    <p>Suppressions</p>
                </li>
            </a>";
    }

    if ($po == 1) {
        echo "
            <a href='productOwner.php' class='nav-item " . ($currentPage == 'productOwner.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/trésorerie.svg' alt='Icone Trésorerie' class='icon'>
                    <p>Trésorerie</p>
                </li>
            </a>
            <a href='productOwnerRemise.php' class='nav-item " . ($currentPage == 'productOwnerRemise.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/remises.svg' alt='Icone Remises' class='icon'>
                    <p>Remises</p>
                </li>
            </a>
            <a href='productOwnerImpaye.php' class='nav-item " . ($currentPage == 'productOwnerImpaye.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/impayés.svg' alt='Icone Impayés' class='icon'>
                    <p>Impayés</p>
                </li>
            </a>
            <a href='statsPO.php' class='nav-item " . ($currentPage == 'statsPO.php' ? 'active' : '') . "'>
                <li class='item'>
                    <img src='../image/stats.svg' alt='Icone Statistiques' class='icon'>
                    <p>Statistiques</p>
                </li>
            </a>";
    }

    echo "</ul>";
}

function display_navigation() {
    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
        // Si l'utilisateur est admin, vérifier s'il est PO
        $po = isset($_SESSION['isProductOwner']) && $_SESSION['isProductOwner'] ? 1 : 0;
        nav_admin($po);
    } else {
        // Sinon, afficher la navigation utilisateur
        nav_client();
    }
}


function footer(){
    echo "<footer>
        <div class='contains'>
        </div>
    </footer>";
}

function create_random_password(): string {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    $password = '';

    for ($i = 0; $i < 100; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $password;
}

function subjectCreationMdp(): string {
    return "Bienvenue chez B.I.L.L.S : Accédez à votre compte dès maintenant";
}

function bodyCreationMdp($pw) : string {
    return <<<HTML
    <!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #333;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    width: 100%;
                    max-width: 600px;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #3e79e5;
                    padding: 10px 0;
                    text-align: center;
                    color: #ffffff;
                }
                .header h1 {
                    margin: 0;
                    font-size: 1.6rem;
                }
                .content {
                    padding: 20px;
                }
                .content h2 {
                    color: #3e79e5;
                    font-size: 1.3rem;
                }
                .content p {
                    margin: 10px 0;
                    font-size: 1rem;
                }
                .content a {
                    color: #ffffff;
                    font-size: 1rem;
                }
                .button {
                    display: inline-block;
                    padding: 10px 15px;
                    margin-top: 15px;
                    color: #ffffff;
                    background-color: #3e79e5;
                    text-decoration: none;
                    border-radius: 4px;
                    font-weight: bold;
                    font-size: 1rem;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 0.8rem;
                    text-align: center;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Bienvenue chez B.I.L.L.S.</h1>
                </div>
                <div class="content">
                    <h2>Votre compte a été créé avec succès !</h2>
                    <p>Bonjour,</p>
                    <p>Nous avons le plaisir de vous informer qu'un compte a été créé pour vous sur notre plateforme <strong>B.I.L.L.S</strong> (Bilan des Impayés et Lettres de Licences avec Statistiques)</p>
                    <p>Afin d'accéder à votre compte, nous vous invitons à <strong>changer votre mot de passe</strong> en utilisant le lien ci-dessous :</p>
                    <p>
                        <a class="button" href="http://localhost:63342/banque-tran/src/changePassword.php?pw=$pw">Changer mon mot de passe</a>
                    </p>
                    <p>Nous vous recommandons de choisir un mot de passe <strong>sécurisé</strong> et de le garder <strong>confidentiel</strong>.</p>
                    <p>Nous restons à votre disposition pour toute question ou assistance.</p>
                    <p>Cordialement,</p>
                    <p>L'équipe B.I.L.L.S</p>
                </div>
                <div class="note">
                    <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller ce lien suivant dans votre navigateur :</p>
                    <p><a href="http://localhost:63342/banque-tran/src/changePassword.php?pw=$pw">http://localhost:63342/banque-tran/src/changePassword.php?pw=$pw</a></p>
                </div>
                <div class="footer">
                    <p>&copy; B.I.L.L.S - Bilan des Impayés et Lettres de Licences avec Statistiques</p>
                    <p>Ce message a été envoyé automatiquement, merci de ne pas y répondre.</p>
                </div>
            </div>
        </body>
    </html>
    HTML;
}

function subjectDeleteClient(): string {
    return "Confirmation de demande de suppression de compte initiée par le PO";
}

function bodyDeleteClient($numClient): string {
    return <<<HTML
    <!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #333;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    width: 100%;
                    max-width: 600px;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #3e79e5;
                    padding: 10px 0;
                    text-align: center;
                    color: #ffffff;
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                }
                .content {
                    padding: 20px;
                }
                .content h2 {
                    color: #3e79e5;
                }
                .content p {
                    margin: 10px 0;
                }
                .content a {
                    color: #ffffff;
                }
                .button {
                    display: inline-block;
                    padding: 10px 15px;
                    margin-top: 15px;
                    color: #ffffff;
                    background-color: #3e79e5;
                    text-decoration: none;
                    border-radius: 4px;
                    font-weight: bold;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    text-align: center;
                    color: #777;
                }
            </style>
        </head>
    <body>
        <div class="container">
              <div class="header">
                    <h1>Notification de suppression</h1>
              </div>
              <div class="content">
                    <h2>Action requise : Confirmation de suppression</h2>
                    <p>Bonjour,</p>
                    <p>Une demande de suppression de compte a été initiée par le Product Owner. Veuillez procéder à la validation de cette requête.</p>
                    <p>
                  <strong>Note :</strong> Cette action est irréversible. Assurez-vous de vérifier toutes les informations avant de confirmer la suppression.
                </p>
                <p>
                  <a class="button" href="http://localhost:63342/banque-tran/src/adminSeeClient.php?numClient=$numClient">Confirmer la demande</a>
                </p>
                <p>Cordialement,</p>
                <p>L'équipe B.I.L.L.S.</p>
              </div>
              <div class="footer">
                <p>&copy; B.I.L.L.S - Bilan des Impayés et Lettres de Licences avec Statistiques</p>
                <p>Ce message a été envoyé automatiquement, merci de ne pas y répondre.</p>
              </div>
        </div>
    </body>
    </html>
    HTML;
}