<?php

//fetch.php
session_start();

include('../connexion.php');

$column = array('numSiren', 'raisonSociale', 'number', 'devise', 'sum');

// Récupération des critères.
//$numClient = $_SESSION['numClient'];
$date = isset($_SESSION['home.datePO'])? $_SESSION['home.datePO']: date('Y-m-d');

$query = "SELECT numSiren, 
                raisonSociale , 
        (SELECT devise FROM remise WHERE numClient=1 LIMIT 1) as devise,
        COUNT(numRemise) AS number, 
        COALESCE(SUM(montantTotal), 0) AS sum 
        FROM `remise` RIGHT JOIN client 
            ON remise.numClient = client.numClient 
        WHERE DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$date'
        GROUP BY client.numClient" ;


$query1 = '';

//pour les flèches
if(isset($_POST['order']))
{
    $query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= ' ORDER BY numSiren ASC ';
}

if($_POST['length'] != -1)
{
    $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $dbh->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $dbh->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

foreach($result as $row)
{
    $sub_array = array();
    $sub_array[] = $row['numSiren'];
    $sub_array[] = $row['raisonSociale'];
    $sub_array[] = $row['number'];
    $sub_array[] = $row['devise'];
    $sub_array[] = $row['sum'];

    $data[] = $sub_array;
}

function count_all_data($connect)
{
    return 0;
}


$output = array(
    'draw'    => intval($_POST['draw']),
    'recordsTotal'  => count_all_data($dbh),
    'recordsFiltered' => $number_filter_row,
    'data'    => $data
);

echo json_encode($output);

?>