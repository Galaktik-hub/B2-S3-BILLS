<?php
    session_start();
    include('function.php');
    include('connexion.php');
    include("navbar.php");
    include('links.php');
    checkIsAdmin();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">
        <script type="text/javascript">
            $(document).ready( function () {
                $('#table_id').DataTable({
                    "oLanguage": {
                        "sInfo" : "Affichage de _START_ à _END_ clients sur un total de _TOTAL_.",
                        "sLengthMenu": "Afficher _MENU_ clients",
                        "sSearch":"Rechercher",
                    },
                });
            } );
        </script>

        <title>Espace Admin</title>
    </head>
    <body>

        <?php
//            $po=0;
//            if($_SESSION['isProductOwner']){
//            $po=1;
//            }
//            head_A($po);
//            if(isset($_GET['numClient'])){
//                $request = "Select * From client where numClient = $_GET[numClient]";
//                $result = $dbh->query($request);
//                $user = $result->fetch();
//
//                $numClient = $_GET['numClient'];
//                echo "<div class='client'><h3>Détail de l'utilisateur n°$user[numClient] - $user[raisonSociale]</h3>";
//
//
//                if($_SESSION['isProductOwner']){
//                    echo "     <a href='productOwnerToClient.php?numClient=$user[numClient]&raisonSociale=$user[raisonSociale]&numSiren=$user[numSiren]' class='lien'><button class='connect'>Se connecter au compte de ce client</button></a>";
//                }
//
//                echo "
//                <form action='updateClient.php' method='POST'>
//                <table class='tab'>
//                    <tr>
//                        <th>Numéro Client</th>
//                        <td>$user[numClient]<input type='hidden' name='numClient' value='$user[numClient]'</td>
//                    </tr>
//                    <tr>
//                        <th>Numéro Siren</th>
//                        <td><input type='text' minlength='9' maxlength='9' name='numSiren' required value='$user[numSiren]'></td>
//                    </tr>
//                    <tr>
//                        <th>Raison Sociale</th>
//                        <td><input type='text' name='raisonSociale' maxlength='50' required value='$user[raisonSociale]'></td>
//                    </tr>
//                    <tr>
//                        <th>Identifiant</th>
//                        <td><input type='text' name='loginClient' maxlength='50' required value='$user[loginClient]'></td>
//                    </tr>";
//
//            if($_SESSION['isProductOwner']){
//                echo "
//                    <tr>
//                        <td class='lien'><input type='reset' value='Annuler les modifications' class='interact'></td>
//                        <td class='lien'><input type='submit' value='Mettre à jour les données' class='interact'></td>
//                    </tr>
//                " ;
//            }
//
//                echo "
//                </table>
//                </form> "   ;
//
//                if(!($_SESSION['isProductOwner'])){
//                    echo "<a href='deleteClient.php?numClient=$numClient' class='lien_suppr'><button class='suppr'>Supprimer ce client</button></a></div>";
//                }
//            }
//            else {
//                echo "
//
//            <h3 class='titre'>Liste des comptes utilisateurs</h3>
//            <div class='utilisateurs'>
//            <table id='table_id' class='table table-striped' data-stripe-classes='[]'>
//                <thead class='thead-dark'>
//                    <tr>
//                        <th>Numéro Client</th>
//                        <th>Siren</th>
//                        <th>Raison Sociale</th>
//                        <th>Login</th>
//                    </tr>
//                </thead>
//            <tbody>";
//
//                $request = "Select * From client";
//                $result = $dbh->query($request);
//                foreach($result as $user){
//                    echo "
//            <tr>
//                <td><a href='admin.php?numClient=$user[numClient]'>$user[numClient]</a></td>
//                <td>$user[numSiren]</td>
//                <td>$user[raisonSociale]</td>
//                <td>$user[loginClient]</td>
//            </tr>
//            ";
//                }
//                echo '</tbody></table></div>';
//            }
//        footer();?>

        <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>

        <script src="../js/admin/admin.js"></script>
    </body>
</html>