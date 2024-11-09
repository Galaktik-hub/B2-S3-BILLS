<?php
global $client, $dbh;
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include('links.php');
checkIsPO();
include('../data/fetchHomeAdmin.php');
include("../mail/sendMail.php");

$numClient = $_GET["numClient"];
$clientDetails = $client[0];
include('../data/fetchDeleteClient.php');

if (!empty($clients)) {
    $clientDetailsSuppression = $clients[0];
}

// Si le formulaire de mise à jour est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateClient'])) {
    $numSiren = $_POST['numSiren'];
    $raisonSociale = $_POST['raisonSociale'];
    $loginClient = $_POST['loginClient'];

    $request = "UPDATE client SET numSiren = :numSiren, raisonSociale = :raisonSociale, loginClient = :loginClient WHERE numClient = :numClient";
    $stmt = $dbh->prepare($request);
    $stmt->bindParam(':numSiren', $numSiren);
    $stmt->bindParam(':raisonSociale', $raisonSociale);
    $stmt->bindParam(':loginClient', $loginClient);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();

    // Redirige pour vider les données POST et afficher un message de confirmation
    header("Location: productOwnerSeeClient.php?numClient=" . $numClient . "&updateSuccess=1");
    exit;
}

// Si la demande de suppression est confirmée
if (isset($_POST['check']) && isset($_POST['justificatif'])) {
    $justificatif = $_POST['justificatif'];
    $request = "INSERT INTO suppression (numClient, dateDemande, justificatif) VALUES (:numClient, CURDATE(), :justificatif)";
    $stmt = $dbh->prepare($request);
    $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->bindParam(':justificatif', $justificatif);
    $stmt->execute();

    $loginAdmin = 'admin';
    $stmtMail = $dbh->prepare("SELECT mail FROM admin WHERE loginAdmin = :loginAdmin");
    $stmtMail->execute(['loginAdmin' => $loginAdmin]);

    $adminMail = $stmtMail->fetch(PDO::FETCH_ASSOC);

    sendmail($adminMail['mail'], subjectDeletionClient(), bodyDeletionClient($numClient));

    // Redirige pour vider les données POST et afficher la demande de suppression
    header("Location: productOwnerSeeClient.php?numClient=" . $numClient . "&deleteSuccess=1");

    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Espace PO - Détails du client</title>
</head>
<body>
<div class="container mt-5">
    <h1>Détails du client</h1>

    <!-- Afficher une alerte de succès si les informations ont été mises à jour -->
    <?php if (isset($_GET['updateSuccess']) && $_GET['updateSuccess'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Les informations du client ont été mises à jour avec succès.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <!-- Afficher une alerte de succès si la demande de suppression a été enregistrée -->
    <?php if (isset($_GET['deleteSuccess']) && $_GET['deleteSuccess'] == 1): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            La demande de suppression du client a été enregistrée avec succès.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Formulaire de mise à jour du client -->
    <form id="updateForm" method="POST" action="productOwnerSeeClient.php?numClient=<?php echo htmlspecialchars($numClient); ?>" onsubmit="return confirmUpdate()">
        <div class="mb-3">
            <label for="numClient" class="form-label">Numéro de Client</label>
            <input type="text" class="form-control" id="numClient" value="<?php echo htmlspecialchars($clientDetails['N° Client']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="numSiren" class="form-label">Numéro Siren</label>
            <input type="text" class="form-control" id="numSiren" name="numSiren" value="<?php echo htmlspecialchars($clientDetails['N° Siren']); ?>">
        </div>
        <div class="mb-3">
            <label for="raisonSociale" class="form-label">Raison Sociale</label>
            <input type="text" class="form-control" id="raisonSociale" name="raisonSociale" value="<?php echo htmlspecialchars($clientDetails['Raison Sociale']); ?>">
        </div>
        <div class="mb-3">
            <label for="loginClient" class="form-label">Identifiant</label>
            <input type="text" class="form-control" id="loginClient" name="loginClient" value="<?php echo htmlspecialchars($clientDetails['Identifiant']); ?>">
        </div>
        <button type="submit" name="updateClient" class="btn btn-primary">Confirmer les modifications</button>
    </form>

    <?php if (isset($clientDetailsSuppression['Date de la demande']) && isset($clientDetailsSuppression['Justificatif'])): ?>
        <p class="mt-4 text-danger"> <?php
            if (!isset($_GET['deleteSuccess'])){
                echo "Vous avez déjà demandé la suppression de ce compte.";
            } else {
                if ($_GET['deleteSuccess'] != 1 ){
                    echo "Vous avez déjà demandé la suppression de ce compte."; // au cas où deleteSuccess = 0 ou autre
                }
            } ?>
        </p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Date de la demande</th>
                    <td><?php echo htmlspecialchars($clientDetailsSuppression['Date de la demande']); ?></td>
                </tr>
                <tr>
                    <th>Raison</th>
                    <td><?php echo htmlspecialchars($clientDetailsSuppression['Justificatif']); ?></td>
                </tr>
            </table>
        </div>
    <?php else: ?>
        <!-- Bouton pour ouvrir le modal de suppression -->
        <button type="button" class="btn btn-danger mt-4" data-toggle="modal" data-target="#deleteModal">Demander la suppression du client</button>

        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="productOwnerSeeClient.php?numClient=<?php echo htmlspecialchars($numClient); ?>">
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer le client n°<?php echo htmlspecialchars($numClient); ?> ?</p>
                            <div class="mb-3">
                                <label for="justificatif" class="form-label">Raison de la suppression</label>
                                <textarea class="form-control" id="justificatif" name="justificatif" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="check" value="true">
                            <button type="submit" class="btn btn-primary">Oui, confirmer</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Scripts Bootstrap et confirmation de mise à jour -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Confirmation de mise à jour
    function confirmUpdate() {
        return confirm("Confirmer les modifications pour ce client ?");
    }
</script>
</body>
</html>
