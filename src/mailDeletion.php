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
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #3e79e5;
            padding: 10px 0;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #3e79e5;
        }
        .content p {
            margin: 10px 0;
        }
        .content a {
            color: #ffffff;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 15px;
            color: #ffffff;
            background-color: #3e79e5;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
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
        <p><a href="http://localhost:63342/banque-tran/src/changePassword.php?pw=<?= $nC ?>">http://localhost:63342/banque-tran/src/changePassword.php?pw=$pw</a></p>
    </div>
    <div class="footer">
        <p>&copy; B.I.L.L.S - Bilan des Impayés et Lettres de Licences avec Statistiques</p>
        <p>Ce message a été envoyé automatiquement, merci de ne pas y répondre.</p>
    </div>
</div>
</body>
</html>