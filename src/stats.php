<?php
global $dbh;
session_start();
include('function.php');
include('connexion.php');
include('navbar.php');
checkIsUser();
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="../css/statistiques.css" rel="stylesheet">
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <title>Espace Client</title>
    </head>
    <body>
        <div class="container">
            <?php
                if(isset($_GET['date']) && isset($_GET['graph'])){
                    $date=$_GET['date'];
                    $graph=$_GET['graph'];
                }
                else if(isset($_GET['date'])){
                    $date=$_GET['date'];
                    $graph="bar";
                }
                else if(isset($_GET['graph'])){
                    $date=date('Y');
                    $graph=$_GET['graph'];
                }
                else{
                    $date=date('Y');
                    $graph="bar";
                }

                $numClient = $_SESSION['numClient'];
                $somme_impaye=array();
                $somme_total=array();
                $liste_libelle=array();
                $nombre_impaye=array();
                $color_list=array();
                $count=0;

                for($i=1;$i<13;$i++){
                    $temp=date('Y-m');
                    if($i<10){
                        $temp=$date."-0".$i;
                    }
                    else{
                        $temp=$date."-".$i;
                    }

                    $request = "Select sum(montant) as somme from transaction,remise where transaction.numRemise=remise.numRemise and montant<0 and DATE_FORMAT(dateRemise, '%Y-%m') = '".$temp."' and numClient=$numClient";
                    $result = $dbh->query($request);
                    $ligne=$result->fetch();
                    array_push($somme_impaye,abs(intval($ligne['somme'])));

                    $request = "Select COALESCE(SUM(montant), 0) as somme from transaction,remise where transaction.numRemise=remise.numRemise and DATE_FORMAT(dateRemise, '%Y-%m') = '".$temp."' and numClient=$numClient";
                    $result = $dbh->query($request);
                    $ligne = $result->fetch();
                    array_push($somme_total,intval($ligne['somme']));
                }

                $request = "Select libelleImpaye from codeimpaye";
                $result = $dbh->query($request);
                while($ligne = $result->fetch()){
                    array_push($liste_libelle,$ligne['libelleImpaye']);
                }

                foreach($liste_libelle as $i){
                    $request = "Select count(*) as imp from impaye,codeimpaye,remise,transaction where impaye.codeImpaye=codeimpaye.codeImpaye and libelleImpaye='$i' and impaye.numTransaction=transaction.numTransaction and transaction.numRemise=remise.numRemise and DATE_FORMAT(dateRemise, '%Y') = '".$date."'and numClient=$numClient";
                    $result = $dbh->query($request);
                    while($ligne = $result->fetch()){
                        if($ligne['imp']=="0"){
                            array_push($nombre_impaye,0);
                            $count+=1;
                        }
                        else{
                            array_push($nombre_impaye,$ligne['imp']);
                        }
                    }
                    $rand1=rand(50,200);
                    $rand2=rand(50,200);
                    $rand3=rand(50,200);
                    $color="rgba($rand1,$rand2,$rand3)";
                    array_push($color_list,$color);
                }?>
            <h1 class="title">Statistiques de votre compte</h1>

            <form method='get' action='stats.php'>
                <p>Choix de l'année  <select name="date">
                        <?php for($i=1950;$i<date('Y')+1;$i++){
                            if($i==$date){
                                echo "<option selected='on'>$i</option>";
                            }
                            else{
                                echo "<option>$i</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" value="Valider" class="grp"> </p>
            </form>
        </div>
    </body>
</html>
