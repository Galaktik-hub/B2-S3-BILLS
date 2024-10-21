<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
checkIsUser();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/Impayes_U.css">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>

    <title>Espace Utilisateur</title>
</head>
<body>
<?php //head();
?>

<?php

    if(isset($_POST['debut'])){
        $_SESSION['impaye.debut'] = $_POST['debut'];
        $debut = $_SESSION['impaye.debut'];
    }
    else {
        //$debut = date('Y-m-d');
        unset($_SESSION['impaye.debut']);
        $debut = "";
    }

    if(isset($_POST['fin'])){
        $_SESSION['impaye.fin'] = $_POST['fin'];
        $fin = $_SESSION['impaye.fin'];
    }
    else {
        //$fin = date('Y-m-d');
        unset($_SESSION['impaye.fin']);
        $fin = "";
    }
    ?>
<h3 class="titre">Impayés</h3>


<!--<div class="container box">-->
<!--    <form action="impaye.php" method="POST">-->
<!--        <label for="debut">Du</label>-->
<!--        <input type="date" name="debut" id="debut"  --><?php //echo "value='".$debut."' max='".date('Y-m-d')."'";  ?><!--
<!---->
<!--        <label for="fin">Au</label>-->
<!--        <input type="date" name="fin" id="fin"  --><?php //echo "value='".$fin."' max='".date('Y-m-d')."'";  ?><!--
<!---->
<!--        <input type="submit">-->
<!--    </form>-->
<!---->
<!--    --><?php
//    echo "
//        <ul>
//                <li>Début : $debut</li>
//                <li>Fin : $fin</li>
//        </ul>";
//
//    if($debut > $fin  && $fin != null){
//        echo "<div class='alert alert-danger' role='alert'>La date de début doit être inférieure à la date de fin</div>";
//        exit;
//    }
//    $title = "LISTE DES IMPAYES DE L ENTREPRISE $_SESSION[raisonSociale] N° SIREN $_SESSION[numSiren]";
//    ?>
<!--    <br/>-->
<!--    <div class="table-responsive">-->
<!--        <table id="impaye_data" class="table table-bordered" data-stripe-classes="[]">-->
<!--            <thead class="thead-dark">-->
<!--            <tr>-->
<!--                <th>Dossier impayé</th>-->
<!--                <th class="no-sort">N° SIREN</th>-->
<!--                <th>Date</th>-->
<!--                <th>N° Carte</th>-->
<!--                <th>Réseau</th>-->
<!--                <th class="no-sort">Devise</th>-->
<!--                <th>Montant</th>-->
<!--                <th>Libellé impayé</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!---->
<!--        </table>-->
<!--    </div>-->
<!--</div>-->

    <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>
    <script src="Js/impaye.js"></script>
</body>
</html>

<script type="text/javascript" language="javascript" >

    $(document).ready(function(){


        $('#impaye_data').DataTable({
            "processing" : true,
            "serverSide" : true,
            paging: true,
            ordering:  true,
            searching: true,
            bInfo: true,
            "ajax" : {
                url:'Data/fetchImpaye.php',
                type:"POST"
            },

            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }],

            "language": {
                "emptyTable": "Pas de donnée",
                "info": "Affichage de _START_ à _END_ lignes parmis _TOTAL_",
                "infoEmpty": "Affichage de 0 sur 0 ligne",
                "infoFiltered": "",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ lignes   ",
                "loadingRecords": "Chargement...",
                "processing": "Chargement...",
                "search": "Recherche:",
                "zeroRecords": "Aucune donnée trouvée",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précedent"
                },
            },

            "createdRow": function( row, data, dataIndex) {
                if(data[6] > -10){
                    $(row).css('background-color','white');
                }
                else if(data[6] > -100){
                    $(row).css('background-color','rgba(255,255,0,0.50)');
                }
                else if(data[6] > -1000){
                    $(row).css('background-color','rgba(255,165,0,0.50)');
                }
                else {
                    $(row).css('background-color','rgba(255,0,0,0.50)');
                }
            },


            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: "<?php echo $title; ?>"

                },
                {
                    extend: 'excelHtml5',
                    title: "<?php echo $title; ?>"
                },
                {
                    extend: 'pdfHtml5',
                    title: "<?php echo $title; ?>"
                }
            ],
            "lengthMenu": [ [10, 25, 50], [10, 25, 50] ]
        });

    });

</script>