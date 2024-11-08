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
        <h1>Bienvenue chez B.I.L.L.S.</h1>
    </div>
    <div class="content">
        <h2>Votre compte a été créé avec succès !</h2>
        <p>Bonjour,</p>
        <p>Nous avons le plaisir de vous informer qu'un compte a été créé pour vous sur notre plateforme <strong>B.I.L.L.S</strong> (Bilan des Impayés et Lettres de Licences avec Statistiques)</p>
        <p>Afin d'accéder à votre compte, nous vous invitons à <strong>changer votre mot de passe</strong> en utilisant le lien ci-dessous :</p>
        <p>
            <a class="button" href="http://localhost:63342/banque-tran/src/changePassword.php?pw=<?= $password ?>">Changer mon mot de passe</a>
        </p>
        <p>Nous vous recommandons de choisir un mot de passe <strong>sécurisé</strong> et de le garder <strong>confidentiel</strong>.</p>
        <p>Nous restons à votre disposition pour toute question ou assistance.</p>
        <p>Cordialement,</p>
        <p>L'équipe B.I.L.L.S</p>
    </div>
    <div class="note">
        <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller ce lien suivant dans votre navigateur :</p>
        <p><a href="http://localhost:63342/banque-tran/src/changePassword.php?pw=<?= $password ?>">http://localhost:63342/banque-tran/src/changePassword.php?pw=$pw</a></p>
    </div>
    <div class="footer">
        <p>&copy; B.I.L.L.S - Bilan des Impayés et Lettres de Licences avec Statistiques</p>
        <p>Ce message a été envoyé automatiquement, merci de ne pas y répondre.</p>
    </div>
</div>
</body>
</html>