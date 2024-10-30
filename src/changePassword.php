<?php
global $dbh;
session_start();
include('function.php');
include('connexion.php');

if (isset($_POST['new_mdp']) && isset($_POST['pw'])) {
    $newpw = hash('sha256', $_POST['new_mdp']);
    $req = $dbh->prepare("UPDATE `client` SET passwordClient = :newpw WHERE passwordClient = :oldpw");
    if ($req->execute(array(':newpw' => $newpw, ':oldpw' => $_POST['pw']))) {
        $req = $dbh->prepare("DELETE FROM `mdptemp` WHERE pw = :oldpw");
        $req->execute(array(':oldpw' => $_POST['pw']));
        header('location: index.php');
    }
}

if (!isset($_GET['pw'])) {
    header('location: index.php');
}

//Check if the unique key that the user has is a key that links to an account
$pw = $_GET['pw'];
$req = $dbh->prepare("SELECT * FROM client WHERE passwordClient = :pw");
if (!($req->execute(array(':pw' => $pw)))) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Bootstrap core CSS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

        <!-- Custom styles for this template -->
        <link href="../css/connexion.css" rel="stylesheet">
        <link rel="preload" href="../image/fond_accueil.jpg" as="image">

        <title>Connexion</title>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const newMdpField = document.getElementById("new_mdp");
                const repeatMdpField = document.getElementById("repeatmdp");
                const updateButton = document.querySelector(".connect");

                function checkForChanges() {
                    const passwordEntered =
                        newMdpField.value === repeatMdpField.value &&
                        newMdpField.value !== "" &&
                        newMdpField.value !== "";

                    if (passwordEntered) {
                        updateButton.disabled = false;
                    } else {
                        updateButton.disabled = true;
                    }
                }

                function checkPasswordsMatch() {
                    if (newMdpField.value !== "" && newMdpField.value === repeatMdpField.value) {
                        repeatMdpField.style.borderColor = "green";
                        errorMsg.hidden = true;
                    } else if (repeatMdpField.value !== "") {
                        repeatMdpField.style.borderColor = "red";
                        errorMsg.hidden = false;
                    } else {
                        repeatMdpField.style.borderColor = "";
                        errorMsg.hidden = true;
                    }
                }

                newMdpField.addEventListener("input", () => {
                    checkForChanges();
                    checkPasswordsMatch();
                });
                repeatMdpField.addEventListener("input", () => {
                    checkForChanges();
                    checkPasswordsMatch();
                });

                updateButton.disabled = true;
            });
        </script>


        <?php head_login()?>
        <div class="text_center">
            <form class="form-signin" action="changePassword.php?pw=<?php echo $pw?>" method="post">
                <h1 class="petit_titre">Changement de mot de passe</h1>
                <div class="form-group">
                    <label for="new_mdp">Mot de passe</label>
                    <input type="password" id="new_mdp" name="new_mdp" placeholder="Entrer le mot de passe">
                </div>

                <div class="form-group">
                    <label for="repeatmdp">Confirmer le mot de passe</label>
                    <input type="password" id="repeatmdp" name="repeatmdp" placeholder="Répéter le mot de passe">
                </div>

                <!--Hidden input to pass the old password value-->
                <input type="hidden" name="pw" value="<?php echo htmlspecialchars($pw); ?>">

                <button class="connect" type="submit" disabled>Changer de mot de passe</button>
            </form>
        </div>

        <footer>
            <div class='contains d-flex justify-content-around align-items-center'>
                <p><a href='https://www.linkedin.com/in/alexis-telle/' id='linkedIn' target='_blank'>Alexis Telle</a></p>
                <p><a href='https://www.linkedin.com/in/julien-synaeve/' target='_blank'>Julien Synaeve</a></p>
                <p><a href='https://www.linkedin.com/in/champaulta/' target='_blank'>Alexis Champault</a></p>
                <p><a href='https://www.linkedin.com/in/elankeethan/' target='_blank'>Kirushikesan</a></p>
                <p><a href='https://www.linkedin.com/in/victorsts/' target='_blank'>Victor Santos</a></p>
            </div>
        </footer>
    </body>
</html>
