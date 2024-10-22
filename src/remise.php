<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include('links.php');
checkIsUser();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/remise_u.css">

    <title>Espace Utilisateur</title>
</head>
<body>


<h3 class="titre">Remises</h3>


<div id="myGrid" class="ag-theme-quartz" style="width: 1300px; margin: auto; max-width: 100%; font-size: 15px"></div>

<script src="../Js/user/remise.js"></script>
</body>
</html>
