<?php
session_start();
include('../include/function.php');
checkIsPO();

// Vérifie si les paramètres 'numClient' et 'raisonSociale' sont présents dans l'URL
if (!isset($_GET['numClient']) || !isset($_GET['raisonSociale'])) {
    // Si l'un des paramètres est manquant, initialise les variables de session avec des valeurs par défaut
    $_SESSION['raisonSociale'] = "Product Owner";
    unset($_SESSION['numClient']);
    unset($_SESSION['numSiren']);

    // Redirige l'utilisateur vers la page admin.php pour éviter de traiter des informations incomplètes
    header('Location: admin.php');
    exit;
}

// Si les paramètres sont présents, les affecte aux variables de session pour garder les informations
$_SESSION['numClient'] = $_GET['numClient'];
$_SESSION['raisonSociale'] = $_GET['raisonSociale']." (Product Owner)";
$_SESSION['numSiren'] = $_GET['numSiren'];

// Redirige vers la page home.php après avoir mis à jour les informations de session
header('Location: home.php');
exit;
