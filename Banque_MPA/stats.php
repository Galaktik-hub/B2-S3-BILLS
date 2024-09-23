<?php
    session_start();
    include('function.php');
    include('connexion.php');
    checkIsUser();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
		
    <link href="Css/Statistiques_U.css" rel="stylesheet">
    <script src="Js/graph.js"> </script>
    <title>Statistiques</title>
</head>
<body>
    <?php head();
    ?>
    <h3 class="titre">Statistiques</h3>
    <?php
        if(isset($_GET['date'])&&isset($_GET['graph'])){
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
        }

    ?>
    <div class="container box">
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

        <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
        
        <?php
        echo"
        Choix du type de graphique 
        <a href='stats.php?date=$date&graph=bar' class='choix'><button class='grp'>Graphique en barre</button></a>
        <a href='stats.php?date=$date&graph=line' class='choix'><button class='grp'>Graphique en ligne</button></a>
        <ul class='liste'>
            <li>Date selectionnée : $date</li>
            <li>Type de graphe selectionné: ";
            if( $graph=='bar'){
                echo'Barre';
            }
            elseif($graph=='line'){
                echo'Ligne';
            }
            echo"</li>
        </ul>";
        ?>
        <button onClick="imprimer('page-content')" class="grp">PDF</button>
    </div>


    <?php 
    $impaye=json_encode($somme_impaye);
    $total=json_encode($somme_total);
    $type=json_encode($graph);

    $libelle=json_encode($liste_libelle);
    $imp=json_encode($nombre_impaye);
    $all_color=json_encode($color_list);
    echo"
    <script>
        $(document).ready(function() {
            var ctx = $('#chart-line');
            var myLineChart = new Chart(ctx, {
                type: $type ,
                data: {
                    labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                    datasets: [{
                        data: $impaye ,
                        label: 'Impayés',
                        backgroundColor: 'red',
                    }, {
                        data: $total,
                        label: 'Chiffre d\'affaire',
                        backgroundColor: 'green'
                    }]
                },
                options: {
                    title: {
                        display: false,
                        text: 'Evolution des impayés'
                    }
                }
            });
        });

        $(document).ready(function() {
            var ctx = $('#chart-pie');
            var myLineChart = new Chart(ctx, {
                type: 'pie' ,
                data: {
                    labels: $libelle,
                    datasets: [{
                        data: $imp ,
                        backgroundColor: $all_color,
                    }]
                },
                options: {
                    title: {
                        display: false,
                        text: 'Repartion des impayés'
                    }
                }
            });
        });
    </script>";
    ?>

    <script>
        function imprimer(divName) {
            window.print();
        }
    </script>


            <div class="row">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="col-sm-8 col-md-6">
                            <div class="card-body">
                                <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                    </div>
                                </div>
                                <p style="text-align:center"> Evolution des impayés</p>
                                <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                            </div>
                       
                            <div class="card-body">
                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                        </div>
                                    </div>
                                    <p style="text-align:center"> Répartition des impayés</p>
                                    <?php if($count!=sizeof($nombre_impaye)){
                                                echo"
                                                <canvas id='chart-pie' width='299' height='200' class='chartjs-render-monitor' style='display: block; width: 299px; height: 200px;'></canvas>
                                                ";
                                                }
                                                else{
                                                    echo"
                                                    <p>Il n'y a pas de données disponible</p>
                                                    ";
                                                }
                                    ?>
                            </div>
                    </div>
                </div>
            </div>


</body>
</html>