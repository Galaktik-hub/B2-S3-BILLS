<?php
session_start();
include('function.php');
include('connexion.php');
include("navbar.php");
include('links.php');
checkIsUser();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/impayes_u.css">

    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>

    <title>Espace Client</title>
</head>
<body>

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


    <div id="myGrid" class="ag-theme-quartz" style="width: 1200px; margin: auto; max-width: 100%; font-size: 15px"></div>
    <script src="../js/user/impaye.js"></script>
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
                url:'../data/fetchImpaye.php',
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