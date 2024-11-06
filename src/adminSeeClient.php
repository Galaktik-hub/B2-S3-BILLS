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
if(isset($_POST['check'])){
    include('connexion.php');
    $request = "DELETE FROM client WHERE numClient = :numClient";
    $stmt = $dbh->prepare($request);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: deleteClientHome.php?numClient=' . $numClient);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
            <!-- Button pour ouvrir le modal -->
            <button type="button" class="button" data-toggle="modal" data-target="#exampleModal">
                Supprimer le client
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation de suppression</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer le client n°<?= htmlspecialchars($numClient) ?> ?<br>
                                Vous devez avoir l'autorisation du Product Owner.</p>
                            <p>En cliquant sur "Oui", vous affirmez avoir l'accord du P.O.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="adminSeeClient.php?numClient=<?= htmlspecialchars($numClient) ?>" method="POST">
                                <input type="hidden" name="check" value="true">
                                <button type="submit" class="btn btn-primary">Oui</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="formulaire">
            <form action="#" class="button_center" method="get">
                <input type="hidden" name="numClient" value="<?php echo htmlspecialchars($numClient); ?>">
                <button class="button_disabled" type="submit" disabled >Suppression du compte client</button>
            </form>
            <p>Vous ne pouvez pas supprimer un utilisateur sans demande préalable du PO.</p>
        </div>
    <?php
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

