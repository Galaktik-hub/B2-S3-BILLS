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
    <link rel="stylesheet" type="text/css" href="Css/Remise_U.css">


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


<h3 class="titre">Remises</h3>
<?php

    if(isset($_POST['numRemise'])) {
        $_SESSION['numRemise'] = $_POST['numRemise'];
        $numRemise = $_SESSION['numRemise'];
    }
    else {
        unset($_SESSION['numRemise']);
        $numRemise = "";
    }

    if(isset($_POST['debut'])){
        $_SESSION['remise.debut'] = $_POST['debut'];
        $debut = $_SESSION['remise.debut'];
    }
    else {
        //$debut = date('Y-m-d');
        unset($_SESSION['remise.debut']);
        $debut = "";
    }

    if(isset($_POST['fin'])){
        $_SESSION['remise.fin'] = $_POST['fin'];
        $fin = $_SESSION['remise.fin'];
    }
    else {
        //$fin = date('Y-m-d');
        unset($_SESSION['remise.fin']);
        $fin = "";
    }
    ?>

<div class="container box">
    <form action="remise.php" method="POST" class="imp">
        <label for="numRemise">Numéro de Remise</label>
        <input type="text" name="numRemise" id="numRemise">

        <label for="debut">Du</label>
        <input type="date" name="debut" id="debut" <?php echo "value='".$debut."' max='".date('Y-m-d')."'";  ?>>

        <label for="fin">Au</label>
        <input type="date" name="fin" id="fin" <?php echo "value='".$fin."' max='".date('Y-m-d')."'";  ?>>

        <input type="submit">
    </form>

<?php
    echo "
        <ul>
                <li>Numéro de Remise : $numRemise</li>
                <li>Début : $debut</li>
                <li>Fin : $fin</li>
        </ul>";
    if($debut > $fin && $fin != null){
        echo "<div class='alert alert-danger' role='alert'>La date de début doit être inférieure à la date de fin</div>";
        exit;
    }
        $title = "LISTE DES REMISES DE L ENTREPRISE $_SESSION[raisonSociale] N° SIREN $_SESSION[numSiren]";
    ?>
    <br/>
    <div class="table-responsive">
        <table id="remiseData" class="table table-bordered" data-stripe-classes="[]">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th>Numéro de Remise</th>
                <th>Date de la remise</th>
                <th>N° Siren</th>
                <th>Raison Sociale</th>
                <th>Nombre de Transactons</th>
                <th>Montant Total</th>
                <th class="no-sort">Devise</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<br />
<br />
<div>Icons made by <a href="https://www.flaticon.com/authors/vectors-market" title="Vectors Market">Vectors Market</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
</body>
</html>

<script>
    /* Formatting function for row details - modify as you need */
    function format (callback, d) {
        var numRemise = d[0];
        const url = "Data/fetchTransaction.php";
        var data = { numRemise:numRemise,}

        $.post(url, data, function(response){
            callback($(response)).show();
        });
    }

    $(document).ready(function() {
        var table = $('#remiseData').DataTable( {
            "ajax" : {
                url:'Data/fetchRemise.php',
                type:"POST"
            },
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "0" },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" },
                { "data": "6" },
            ],
            "order": [[1, 'asc']],
            "processing" : true,
            "serverSide" : true,
            paging: true,
            ordering:  true,
            searching: true,
            bInfo: true,

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
                    "previous": "Précedent",
                },
            },

            "createdRow": function( row, data, dataIndex) {
                if (data[5] < 0) {
                    $(row).css('background-color','#FF513E');
                }
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: "<?php echo $title; ?>",

                },
                {
                    extend: 'excelHtml5',
                    title: "<?php echo $title; ?>",
                },
                {
                    extend: 'pdfHtml5',
                    title: "<?php echo $title; ?>",
                }
            ],
            "lengthMenu": [ [10, 25, 50], [10, 25, 50] ],
        } );


        // Add event listener for opening and closing details
        $('#remiseData tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                //row.child( format(row.data()) ).show();
                format(row.child, row.data());
                tr.addClass('shown');
            }
        } );
    } );
</script>