<?php

global $dbh;
session_start();
include("function.php");
checkIsAdmin();

if (!isset($_POST['numClient'])) {
    header('Location: admin.php');
    exit;
}

include('connexion.php');
$request = "UPDATE client SET numSiren = '$_POST[numSiren]', loginClient = '$_POST[loginClient]', raisonSociale = '$_POST[raisonSociale]' WHERE numClient = $_POST[numClient]";
$dbh->exec($request);
header("Location: admin.php?numClient=$_POST[numClient]");
exit;
