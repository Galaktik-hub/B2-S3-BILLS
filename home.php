<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    checkIsUser();
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/home.css">


    <title>Accueil</title>
</head>

<body>
    <div class="page-top">
        <h1>Bonjour Carrefour</h1>
        <h2>Trésorerie du samedi 12 octobre 2024</h2>
        <form >
            <input type="date" id="date" name="date" class="date" required>
            <button type="submit" class="button">
                Envoyer
            </button>
        </form>

        <div class="card-solde">
            <table>
                <thead>
                <tr>
                    <th>N° Siren</th>
                    <th>Raison Sociale</th>
                    <th>Nombre de Remises</th>
                    <th class="no-sort">Devise</th>
                    <th>Montant Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>987654321</td>
                    <td> Carrerfour </td>
                    <td>5</td>
                    <td>EUR</td>
                    <td>3000.00</td>
                </tr>
                </tbody>
            </table>
        </div>

            <button class="button" onclick="window.location.href='test.html';">
                <p>CSV</p>
            </button>
            <button class="button" onclick="window.location.href='test.html';">
                <p>Excel</p>
            </button>
            <button class="button" onclick="window.location.href='test.html';">
                <p>PDF</p>
            </button>
    </div>
</body>
</html>
