<?php
session_start();
include('../include/function.php');
checkIsPO();
if(!isset($_GET['numClient']) || !isset($_GET['raisonSociale'])){
    $_SESSION['raisonSociale'] = "Product Owner";
    unset($_SESSION['numClient']);
    unset($_SESSION['numSiren']);

    header('Location: admin.php');
    exit;
}
$_SESSION['numClient'] = $_GET['numClient'];
$_SESSION['raisonSociale'] = $_GET['raisonSociale']." (Product Owner)";
$_SESSION['numSiren'] = $_GET['numSiren'];
header('Location: home.php');
exit;
