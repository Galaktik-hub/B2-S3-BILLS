<?php
global $dbh;
session_start();
include('../include/function.php');
include('../include/connexion.php');

if (isset($_POST['new_mdp']) && isset($_POST['pw'])) {
    $newpw = hash('sha256', $_POST['new_mdp']);
    $req = $dbh->prepare("UPDATE `client` SET passwordClient = :newpw WHERE numClient = :numClient");
    if ($req->execute(array(':newpw' => $newpw, ':numClient' => $_SESSION['numClient']))) {
        $req = $dbh->prepare("DELETE FROM `mdptemp` WHERE numClient = :numClient");
        $req->execute(array(':numClient' => $_SESSION['numClient']));
        header('location: index.php');
    }
}

if (!isset($_GET['pw'])) {
    header('location: index.php');
}

//Check if the unique key that the user has is a key that links to an account
$pw = $_GET['pw'];
$req = $dbh->prepare("SELECT * FROM mdptemp WHERE pw = :pw");
if (!($req->execute(array(':pw' => $pw)))) {
    header('location: index.php');
}
$line = $req->fetch(PDO::FETCH_OBJ);
$_SESSION['numClient'] = $line->numClient;
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favico -->
        <link rel="icon" href="../image/logo.ico" type="image/x-icon">

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
                <h2 class="petit_titre">Changement de mot de passe</h2>
                <div class="mdp mdp-top">
                    <input type="password" id="new_mdp" class="form-control mb-2" placeholder="Nouveau mot de passe" name="new_mdp" required>
                    <svg id ="oeil" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash oeil-new" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z"/>
                        <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                    </svg>
                </div>
                <div class="mdp">
                    <input type="password" id="repeatmdp" class="form-control mb-4" placeholder="Confirmer le mot de passe" name="repeatmdp" required>
                    <svg id ="oeil" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash oeil-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z"/>
                        <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                    </svg>
                </div>

                <!--Hidden input to pass the old password value-->
                <input type="hidden" name="pw" value="<?php echo htmlspecialchars($pw); ?>">

                <button class="connect" type="submit" disabled>Enregistrer</button>
            </form>
        </div>

        <script src="../js/oeil.js"></script>

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
