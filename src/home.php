<?php
session_start();
include('function.php');
include('connexion.php');
include('navbar.php');
checkIsUser();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/home.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


    <title>Espace Utilisateur</title>
</head>
<body>
<div class="page-top">
    <h1>Bonjour <?php echo $_SESSION['raisonSociale']?> </h1>
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
    echo "<h2>Trésorerie du ".strftime('%A %e %B %Y', strtotime($date))."</h2>";

    ?>
    <form >
        <input type="date" id="date" name="date" class="date" required>
        <button type="submit" class="button">
            Envoyer
        </button>
    </form>

    <div class="card-solde">
        <table id="customer_data" data-stripe-classes="[]">
            <thead>
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
    <div id="buttons-container"></div>
</div>

<br />
<br />
</body>
</html>
<!--
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        // Initialiser le DataTable pour le tableau principal
        var table = $('#customer_data').DataTable({
            "processing": true,
            "serverSide": true,
            paging: false,
            ordering: true,
            searching: false,
            bInfo: false,
            "ajax": {
                url: '../data/fetchHome.php',
                type: "POST"
            },
            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }],
            "language": {
                "emptyTable": "Pas de donnée",
                "info": "Affichage de _START_ à _END_ lignes parmi _TOTAL_",
                "infoEmpty": "Affichage de 0 sur 0 ligne",
                "infoFiltered": "",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ lignes",
                "loadingRecords": "Chargement...",
                "processing": "Chargement...",
                "search": "Recherche:",
                "zeroRecords": "Aucune donnée trouvée",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
            },
            "createdRow": function(row, data, dataIndex) {
                if (data[4] < 0) {
                    $(row).css('background-color', '#FF513E');
                }
            },
            // Exclure les boutons de l'initialisation du tableau
            dom: 'lrtip'
        });

        // Initialiser les boutons
        new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'csvHtml5',
                    title: 'EXTRAIT DE TRESORERIE DU ' + '<?php echo $date; ?>',
                    className: 'button'
                },
                {
                    extend: 'excelHtml5',
                    title: 'EXTRAIT DE TRESORERIE DU ' + '<?php echo $date; ?>',
                    className: 'button'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'EXTRAIT DE TRESORERIE DU ' + '<?php echo $date; ?>',
                    className: 'button'
                }
            ]
        });

        // Attacher les boutons en dehors du tableau
        table.buttons().container().appendTo('#buttons-container');
    });
</script>
-->


