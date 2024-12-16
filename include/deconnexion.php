<?php
// Script de déconnexion (Soit du point de vue PO, soit de sa session)

session_start();

if (isset($_SESSION['PO_VIEW_CLIENT'])){
    // Arrêt de la visualisation PO
    unset($_SESSION['PO_VIEW_CLIENT']);
    header('Location: ../src/admin.php');
    exit;
}

if(!isset($_SESSION['isAdmin'])){
    header('Location: ../src/index.php');
    exit;
}

session_unset();

session_destroy();

header("Location: ../src/index.php");
