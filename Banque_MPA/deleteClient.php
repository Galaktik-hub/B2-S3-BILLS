<?php
session_start();
include("function.php");
checkIsAdmin();
if(!isset($_GET['numClient'])){
    header('Location: admin.php');
    exit;
}
$numClient = $_GET['numClient'];

echo "

        <p>Etes-vous sûr de vouloir supprimer le client n°$numClient ? <br>Vous devez avoir l'autorisation du Product Owner </p>
        <p>En cliquant sur Oui vous affirmez avoir l'accord du P.O.</p>
        <a href='deleteClient.php?numClient=$numClient&check=true'><button>Oui</button></a>
        <a href='admin.php?numClient=$numClient'><button>Non</button></a>
";


// Après validation de l'administrateur
if(isset($_GET['check'])){
    include('connexion.php');
    $request = "Delete From client where numClient=$numClient";
    $dbh->exec($request);
    header('Location: admin.php');
    exit;
}
?>

