<?php
session_start();
include('function.php');
include('connexion.php');
checkIsUser();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/Accueil_U.css">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>



    <title>Espace Utilisateur</title>
</head>
<body>
<?php head();
?>
<?php

if(isset($_POST['date'])){
    $_SESSION['home.date'] = $_POST['date'];
    $date = $_SESSION['home.date'];
}
else {
    $date = date('Y-m-d');
    unset($_SESSION['home.date']);
}
setlocale (LC_TIME, 'fr_FR.utf8','fra');
echo "<h3 class='titre'>Trésorerie du ".strftime('%A %e %B %Y', strtotime($date))."</h3>";

?>





    <div class="container box">
        <form action="home.php" method="POST" class="imp">
            <input type="date" name="date" <?php echo "value='".$date."' max='".date('Y-m-d')."'";  ?>>
            <input type="submit">
        </form>
    <br/>
        <div class="table-responsive">
            <table id="customer_data" class="table table-bordered" data-stripe-classes="[]">
                <thead class="thead-dark">
                    <tr>
                        <th>N° Siren</th>
                        <th>Raison Sociale</th>
                        <th>Nombre de Remises</th>
                        <th class="no-sort">Devise</th>
                        <th>Montant Total</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
    <br />
    <br />
</body>
</html>

<script type="text/javascript" language="javascript" >

    $(document).ready(function(){


        $('#customer_data').DataTable({
            "processing" : true,
            "serverSide" : true,
            paging: false,
            ordering:  true,
            searching:false,
            bInfo:false,
            "ajax" : {
                url:'Data/fetchHome.php',
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
                if (data[4] < 0) {
                    $(row).css('background-color','#FF513E');
                }
            },
            
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: 'EXTRAIT DE TRESORERIE DU ' + '<?php echo $date; ?>'

                },
                {
                    extend: 'excelHtml5',
                    title: 'EXTRAIT DE TRESORERIE DU ' + '<?php echo $date; ?>'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'EXTRAIT DE TRESORERIE DU ' + '<?php echo $date; ?>'
                }
            ],
            "lengthMenu": [ [10, 25, 50], [10, 25, 50] ]
        });

    });

</script>