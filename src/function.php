<?php

function checkIsUser(){
    if (!(isset($_SESSION['PO_VIEW_CLIENT']))) {
        if(!(isset($_SESSION['numClient']))){
            header('Location: index.php');
        }
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
                    <p>
                        <span id='notificationDot' class='notification-dot' style='display: none;'></span>
                        Suppressions
                    </p>
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
    // Si le PO veut voir la page du point de vue d'un client
    if (isset($_SESSION['PO_VIEW_CLIENT'])) {
        nav_client();
    } else {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            // Si l'utilisateur est admin, vérifier s'il est PO
            $po = isset($_SESSION['isProductOwner']) && $_SESSION['isProductOwner'] ? 1 : 0;
            nav_admin($po);
        } else {
            // Sinon, afficher la navigation utilisateur
            nav_client();
        }
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
    ob_start();
    $password = htmlspecialchars($pw); // sécuriser la variable
    include 'mailWelcome.php';
    return ob_get_clean();
}

function subjectDeletionClient(): string {
    return "Confirmation de demande de suppression de compte initiée par le PO";
}

function bodyDeletionClient($nC): string {
    ob_start();
    $numClient = htmlspecialchars($nC); // sécuriser la variable
    include 'mailDeletion.php';
    return ob_get_clean();
}