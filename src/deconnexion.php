<?php
session_start();

if (isset($_SESSION['PO_VIEW_CLIENT'])){
    // Arrêt de la visualisation PO
    unset($_SESSION['PO_VIEW_CLIENT']);
    header('Location: admin.php');
    exit;
}

if(!isset($_SESSION['isAdmin'])){
    header('Location: index.php');
    exit;
}

session_unset();

session_destroy();

header("Location: index.php");
?>