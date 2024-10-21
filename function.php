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

function head(){

    $forPO = (isset($_SESSION['isProductOwner']) && $_SESSION['isProductOwner'])? "<a href='productOwnerToClient.php'><button type='button' class='retour' ><p class='texte'>Espace Product Owner</p></button></a>" :"";
    echo "<header>
        <div class='superieur'>
            Bonjour ".$_SESSION['raisonSociale'].

        "$forPO
            <a href='deconnexion.php'><button type='button' class='deconnexion' ><p class='texte'>Déconnexion</p></button></a>
        </div>
        <div class='inferieur'>
            <a href='home.php' class='direction'><button type='button' class='nav'><p class='texte'>Accueil</p></button></a>
            <a href='remise.php' class='direction'><button type='button' class='nav'><p class='texte'>Remises</p></button></a>
            <a href='impaye.php' class='direction'><button type='button' class='nav'><p class='texte'>Impayés</p></button></a>
            <a href='stats.php' class='direction'><button type='button' class='nav'><p class='texte'>Statistiques</p></button></a>
        </div>
        <hr>
    </header>";
}

function head_A($po){
    echo "<header>
        <div class='superieur'>
            Bonjour ".$_SESSION['raisonSociale']. "
            <a href='deconnexion.php'><button type='button' class='deconnexion' ><p class='texte'>Déconnexion</p></button></a>
        </div>
        <div class='inferieur'>
            <a href='admin.php' class='direction'><button type='button' class='nav'><p class='texte'>Administration</p></button></a>
                
            <a href='insertClient.php' class='direction'><button type='button' class='nav'><p class='texte'>Insérer un nouveau client</p></button></a>";

            if($po==1){
                echo "
            <a href='productOwner.php' class='direction'><button type='button' class='nav'><p class='texte'>Trésorerie</p></button></a>
            <a href='productOwnerRemise.php' class='direction'><button type='button' class='nav'><p class='texte'>Remises</p></button></a>
            <a href='productOwnerImpaye.php' class='direction'><button type='button' class='nav'><p class='texte'>Impayés</p></button></a>";
            }
            echo"
            </div>
        <hr>
    </header>";
}

function head_C(){
    echo "
        <header class='superieur'>
            <h2 class='titre_h'> B.I.L.L.S. <h2>
        </header>
    ";
}

function nav_client() {
    echo "
    <nav class='vertical-navigation'>
        <ul class='navigation-items'>
            <a href='home.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/accueil.svg' alt='Icone Accueil' class='icon'>
                    <p>Accueil</p>
                </li>
            </a>
            <a href='remise.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/remises.svg' alt='Icone Remises' class='icon'>
                    <p>Remises</p>
                </li>
            </a>
            <a href='impaye.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/impayés.svg' alt='Icone Impayés' class='icon'>
                    <p>Impayés</p>
                </li>
            </a>
            <a href='stats.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/stats.svg' alt='Icone Statistiques' class='icon'>
                    <p>Statistiques</p>
                </li>
            </a>
            <a href='#' class='nav-item'>
                <li class='item'>
                    <img src='../Image/compte.svg' alt='Icone Compte' class='icon'>
                    <p>Compte</p>
                </li>
            </a>
        </ul>
    </nav>";
}

function nav_admin($po) {
    echo "
    <nav class='vertical-navigation'>
        <ul class='navigation-items'>
            <a href='admin.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/settings.svg' alt='Icone Admin' class='icon'>
                    <p>Administration</p>
                </li>
            </a>
            <a href='insertClient.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/plus.svg' alt='Icone Ajouter Client' class='icon'>
                    <p>Nouveau client</p>
                </li>
            </a>";

    if ($po == 1) {
        echo "
            <a href='productOwner.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/trésorerie.svg' alt='Icone Trésorerie' class='icon'>
                    <p>Trésorerie</p>
                </li>
            </a>
            <a href='productOwnerRemise.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/remises.svg' alt='Icone Remises' class='icon'>
                    <p>Remises</p>
                </li>
            </a>
            <a href='productOwnerImpaye.php' class='nav-item'>
                <li class='item'>
                    <img src='../Image/impayés.svg' alt='Icone Impayés' class='icon'>
                    <p>Impayés</p>
                </li>
            </a>";
    }

    echo "</ul>
    </nav>";
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

?>