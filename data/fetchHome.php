<?php

// Si la session contient le numéro du client, on le récupère
if (isset($_SESSION['numClient'])){
    $numClient = $_SESSION['numClient'];
}

// Si un PO veut voir la page d'un client spécifique, on utilise ce numéro
if (isset($_SESSION['PO_VIEW_CLIENT'])){
    $numClient = $_SESSION['PO_VIEW_CLIENT'];
}

// Initialisation de la variable date à la date du jour
$date = date('Y-m-d');

// Requête SQL pour récupérer les informations sur le client et ses remises
$query = "
    SELECT 
        (SELECT numSiren FROM client WHERE numClient = :numClient) as 'N° Siren', 
        (SELECT raisonSociale FROM client WHERE numClient = :numClient) as 'Raison Sociale', 
        (SELECT devise FROM remise WHERE numClient = :numClient LIMIT 1) as Devise,
        COUNT(numRemise) AS 'Nombre de Remises', 
        COALESCE(SUM(montantTotal), 0) AS 'Montant Total' 
    FROM remise 
    WHERE numClient = :numClient";

// Préparation et exécution de la requête SQL
$stmt = $dbh->prepare($query);
$stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
$stmt->execute();
$remises = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si des remises sont trouvées, on enregistre le numéro Siren dans la session
if (!empty($remises)) {
    // Enregistre le numéro Siren dans la session (s'il existe)
    $_SESSION['numSiren'] = $remises[0]['numSiren'] ?? null;
}

// Récupère les noms des colonnes du résultat pour les utiliser dans l'interface utilisateur
$columns = array_keys($remises[0]);

// Conversion des remises en JSON
$remises_json = json_encode($remises);
// Conversion des colonnes en JSON
$columns_json = json_encode($columns);
?>