<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include('links.php');
checkIsAdmin();
include('../data/fetchHomeAdmin.php');
$numClient = $_GET["numClient"];
$clientDetails = $client[0];
include('../data/fetchDeleteClient.php');
if(!empty($clients)){
    $clientDetailsSupression = $clients[0];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

    <title>Espace Admin</title>
</head>
<body>
<div class="page">
    <div class="title">
        <h1> Détails du client </h1>
    </div>
    <table>
        <tr>
            <th>N° Client</th>
            <td><?php echo htmlspecialchars($clientDetails['N° Client']); ?></td>
        </tr>
        <tr>
            <th>N° Siren</th>
            <td><?php echo htmlspecialchars($clientDetails['N° Siren']); ?></td>
        </tr>
        <tr>
            <th>Raison Sociale</th>
            <td><?php echo htmlspecialchars($clientDetails['Raison Sociale']); ?></td>
        </tr>
        <tr>
            <th>Identifiant</th>
            <td><?php echo htmlspecialchars($clientDetails['Identifiant']); ?></td>
        </tr>
            <?php
            if (isset($clientDetailsSupression['Date de la demande']) && isset($clientDetailsSupression['Justificatif'])) {
            ?>
        <tr>
            <th>Date demande de suppression</th>
            <td><?php echo htmlspecialchars($clientDetailsSupression['Date de la demande']); ?></td>
        </tr>
        <tr>
            <th>Justificatif du PO</th>
            <td><?php echo htmlspecialchars($clientDetailsSupression['Justificatif']); ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (isset($clientDetailsSupression['Date de la demande']) && isset($clientDetailsSupression['Justificatif'])) {
        ?>
        <div class="formulaire">
            <form action="deleteClient.php" class="button_center" method="get">
                <input type="hidden" name="numClient" value="<?php echo htmlspecialchars($numClient); ?>">
                <button class="button" type="submit" >Suppression du compte client</button>
            </form>
        </div>
        <?php
    } else {
        ?>
        <div class="formulaire">
            <form action="deleteClient.php" class="button_center" method="get">
                <input type="hidden" name="numClient" value="<?php echo htmlspecialchars($numClient); ?>">
                <button class="button_disabled" type="submit" disabled >Suppression du compte client</button>
            </form>
            <p>Vous ne pouvez pas supprimer un utilisateur sans demande préalable du PO.</p>
        </div>
    <?php
    }
    ?>

</body>
</html>
