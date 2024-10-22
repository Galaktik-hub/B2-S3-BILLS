<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
checkIsPO();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/accueil_a.css">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>

</head>
<body>

<h3 class="titre">Impayés</h3>


<div class="container box">
    <form action="productOwnerImpaye.php" method="POST" class="imp">
        <label for="numSiren">Numéro SIREN</label>
        <input type="text" name="numSiren" id="numSiren">

        <input type="submit">
    </form>
    <?php

    if(isset($_POST['numSiren'])) {
        $_SESSION['numSiren'] = $_POST['numSiren'];
        $numSiren = $_SESSION['numSiren'];
    }
    else {
        unset($_SESSION['numSiren']);
        $numSiren = "";
    }

    echo "
        <ul>
                <li>Numéro SIREN : $numSiren</li>
        </ul>";

    ?>
    <br/>
<!--    <div class="table-responsive">-->
<!--        <table id="impaye_data" class="table table-bordered" data-stripe-classes="[]">-->
<!--            <thead class="thead-dark">-->
<!--            <tr>-->
<!--                <th>N° SIREN</th>-->
<!--                <th>Raison sociale</th>-->
<!--                <th>Montant total</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--        </table>-->
<!--    </div>-->
</div>

<div id="myGrid" class="ag-theme-quartz" style="width: 1400px; margin: auto; max-width: 100%; font-size: 15px"></div>
<script src="../Js/admin/productOwnerImpaye.js"></script>
</body>
</html>
<!--
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
                url:'../data/fetchImpayePO.php',
                type:"POST"
            },

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
                if(data[2] > -100){
                    $(row).css('background-color','white');
                }
                else if(data[2] > -1000){
                    $(row).css('background-color','rgba(255,255,0,0.50)');
                }
                else if(data[2] > -10000){
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
                    title: "EXTRAIT D IMPAYES PO "

                },
                {
                    extend: 'excelHtml5',
                    title: "EXTRAIT D IMPAYES PO "
                },
                {
                    extend: 'pdfHtml5',
                    title: "EXTRAIT D IMPAYES PO "
                }
            ],
            "lengthMenu": [ [10, 25, 50], [10, 25, 50] ]
        });

    });

</script>
-->