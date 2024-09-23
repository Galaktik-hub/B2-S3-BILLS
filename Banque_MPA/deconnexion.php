<?php
session_start();
if(!isset($_SESSION['isAdmin'])){
    header('Location: index.php');
    exit;
}

session_unset();

session_destroy();

header("Location: index.php");
?>