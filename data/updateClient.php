<?php

global $dbh;
session_start();
include("../include/function.php");
checkIsAdmin();

// Vérification si le paramètre 'numClient' est présent dans la requête POST
if (!isset($_POST['numClient'])) {
    header('Location: admin.php');
    exit;
}

include('../include/connexion.php');

// Préparation de la requête SQL pour mettre à jour les informations du client
$request = "UPDATE client SET numSiren = :numSiren, loginClient = :loginClient, raisonSociale = :raisonSociale WHERE numClient = :numClient";

$stmt = $dbh->prepare($request);
$stmt->bindParam(':numSiren', $_POST['numSiren']);
$stmt->bindParam(':loginClient', $_POST['loginClient']);
$stmt->bindParam(':raisonSociale', $_POST['raisonSociale']);
$stmt->bindParam(':numClient', $_POST['numClient']);
$stmt->execute();

// Redirection vers la page d'administration avec l'identifiant du client dans l'URL
header("Location: admin.php?numClient=$_POST[numClient]");
exit;
