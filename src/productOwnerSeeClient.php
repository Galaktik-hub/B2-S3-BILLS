<?php
global $client, $dbh;
session_start();
include('../include/function.php');
include('../include/connexion.php');
include("../include/navbar.php");
include('../include/links.php');
checkIsPO();
include('../data/fetchHomeAdmin.php');
include("../mail/sendMail.php");

// Récupère le numéro du client à partir de l'URL puis ses informations
$numClient = $_GET["numClient"];
$clientDetails = $client[0];
include('../data/fetchDeleteClient.php');
include('../data/fetchPOseeClient.php');
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
<div class="container">

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

    <div class="form-container">
        <h1 class="form-title">Détails du client</h1>

        <!-- Formulaire pour la mise à jour des informations du client -->
        <form id="updateForm" method="POST" action="productOwnerSeeClient.php?numClient=<?php echo htmlspecialchars($numClient); ?>" onsubmit="return confirmUpdate()">
            <div class="form-group">
                <label for="id_client">N° Client</label>
                <input type="text" id="id_client" name="id_client" value="<?php echo htmlspecialchars($clientDetails['N° Client']); ?>" placeholder="Numéro Client" disabled>
            </div>

            <div class="form-group">
                <label for="siren">Siren</label>
                <input type="text" id="numSiren" name="numSiren" minlength="9" maxlength="9" value="<?php echo htmlspecialchars($clientDetails['N° Siren']); ?>" placeholder="Entrer le Siren">
            </div>

            <div class="form-group">
                <label for="raisonSociale">Raison Sociale</label>
                <input type="text" id="raisonSociale" name="raisonSociale" value="<?php echo htmlspecialchars($clientDetails['Raison Sociale']); ?>" placeholder="Entrer la Raison Sociale">
            </div>

            <div class="form-group">
                <label for="identifiant">Identifiant</label>
                <input type="text" id="loginClient" name="loginClient" value="<?php echo htmlspecialchars($clientDetails['Identifiant']); ?>" placeholder="Entrer l'Identifiant">
            </div>

            <p class='error' hidden>Les mots de passe ne correspondent pas.</p>
            <!-- Affichage des messages d'erreur ou de succès si disponibles -->
            <?php
            if (!empty($errorMsg)) {
                echo $errorMsg;
            }

            if (!empty($successMsg)) {
                echo $successMsg;
            }
            ?>
            <button type="submit" name="updateClient" class="btn-submit">Mettre à jour</button>

        </form>
    </div>

    <!-- Si une demande de suppression a été faite, affiche les détails de la demande -->
    <?php if (isset($clientDetailsSuppression['Date de la demande']) && isset($clientDetailsSuppression['Justificatif'])): ?>
        <p class="mt-4 text-danger"> <?php
            // Vérifie si une demande de suppression a déjà été enregistrée
            if (!isset($_GET['deleteSuccess'])){
                echo "Vous avez déjà demandé la suppression de ce compte.";
            } else {
                if ($_GET['deleteSuccess'] != 1 ){
                    echo "Vous avez déjà demandé la suppression de ce compte."; // au cas où deleteSuccess = 0 ou autre
                }
            } ?>
        </p>

        <!-- Affichage de la demande de suppresion en cours -->
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
        <!-- Si aucune demande de suppression n'a été faite, propose un bouton pour en faire une -->
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

    <!-- Formulaire pour se connecter au compte du client -->
    <form method="POST" action="">
        <button type="submit" name="connectClient" class="btn btn-primary mt-4">Se connecter au compte de ce client</button>
    </form>
</div>

<!-- Scripts Bootstrap et confirmation de mise à jour -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Fonction de confirmation de mise à jour des informations du client
    function confirmUpdate() {
        return confirm("Confirmer les modifications pour ce client ?");
    }
</script>
</body>
</html>
