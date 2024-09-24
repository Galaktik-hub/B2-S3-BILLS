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

    $forPO = (isset($_SESSION['isProductOwner']) && $_SESSION['isProductOwner'])?"<a href='productOwnerToClient.php'><button type='button' class='retour' ><p class='texte'>Espace Product Owner</p></button></a>":"";
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
            Bonjour ".$_SESSION['raisonSociale']."
            <a href='deconnexion.php'><button type='button' class='deconnexion' ><p class='texte'>Déconnexion</p></button></a>
        </div>
        <div class='inferieur'>
            <a href='admin.php' class='direction'><button type='button' class='nav'><p class='texte'>Administration</p></button></a>
                
            <a href='insertClient.php' class='direction'><button type='button' class='nav'><p class='texte'>Insérer un nouveau client</p></button></a>";

            if($po==1){
                echo"
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
            <h2 class='titre_h'> MyBank <h2>
        </header>
    ";
}


function footer(){
    echo "<footer>
        <div class='contains'>
        </div>
    </footer>";
}

?>