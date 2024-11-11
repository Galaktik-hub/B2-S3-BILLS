<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 38rem;
            margin: auto;
            padding: 1.25rem;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #3e79e5;
            padding: 0.7rem;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 1.6rem;
        }
        .content {
            padding: 1.5rem;
        }
        .content h2 {
            color: #3e79e5;
            font-size: 1.3rem;
        }
        .content p {
            margin: 0.7rem 0;
            font-size: 1rem;
        }
        .content a {
            color: #ffffff;
            font-size: 1rem;
        }
        .button {
            display: inline-block;
            padding: 0.7rem 1rem;
            margin-top: 1rem;
            color: #ffffff;
            background-color: #3e79e5;
            text-decoration: none;
            border-radius: 0.25rem;
            font-weight: bold;
            font-size: 1rem;
        }
        .footer {
            margin-top: 1.5rem;
            font-size: 0.8rem;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Notification de suppression</h1>
    </div>
    <div class="content">
        <h2>Action requise : Confirmation de suppression</h2>
        <p>Bonjour,</p>
        <p>Une demande de suppression de compte a été initiée par le Product Owner. Veuillez procéder à la validation de cette requête.</p>
        <p>
            <strong>Note :</strong> Cette action est irréversible. Assurez-vous de vérifier toutes les informations avant de confirmer la suppression.
        </p>
        <p>
            <a class="button" href="http://localhost:63342/banque-tran/src/adminSeeClient.php?numClient=<?= $nC ?>">Confirmer la demande</a>
        </p>
        <p>Cordialement,</p>
        <p>L'équipe B.I.L.L.S.</p>
    </div>
    <div class="note">
        <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller ce lien suivant dans votre navigateur :</p>
        <p><a href="http://localhost:63342/banque-tran/src/adminSeeClient.php?numClient=<?= $nC ?>">http://localhost:63342/banque-tran/src/changePassword.php?pw=$pw</a></p>
    </div>
    <div class="footer">
        <p>&copy; B.I.L.L.S - Bilan des Impayés et Lettres de Licences avec Statistiques</p>
        <p>Ce message a été envoyé automatiquement, merci de ne pas y répondre.</p>
    </div>
</div>
</body>
</html>