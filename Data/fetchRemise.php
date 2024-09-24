<?php

//fetchRemise.php
session_start();

include('../connexion.php');
$column = array('numRemise', 'dateRemise', 'numSiren', 'raisonSociale', 'nbrTransaction', 'montantTotal', 'devise');

// Récupération des critères.
$numClient = $_SESSION['numClient'];
$numRemise = isset($_SESSION['numRemise'])? $_SESSION['numRemise']:"";
$debut = isset($_SESSION['remise.debut'])? $_SESSION['remise.debut']: "";
$fin = isset($_SESSION['remise.fin'])? $_SESSION['remise.fin']: date('Y-m-d');

$query = "SELECT numRemise, dateRemise, numSiren, raisonSociale, nbrTransaction, montantTotal, devise 
            FROM `remise` NATURAL JOIN client  
            WHERE numClient = $numClient ";

//AND DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$date'"

if ($numRemise != "") {
    $query .= " AND CAST(numRemise as CHAR) LIKE '%$numRemise%' ";
}
if ($debut != "" && $fin != "") {
    $query .= " AND DATE_FORMAT(dateRemise, '%Y-%m-%d') BETWEEN '$debut' AND '$fin' ";
} else if ($debut != "") {
    $query .= "AND DATE_FORMAT(dateRemise, '%Y-%m-%d') >= '$debut' ";
} else if ($fin != "") {
    $query .= "AND DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$fin' ";
}


//pour la recherche
if(isset($_POST['search']['value']))
{
    $query .= '
     AND (numRemise LIKE "%'.$_POST['search']['value'].'%" 
     OR nbrTransaction LIKE "%'.$_POST['search']['value'].'%" 
     OR montantTotal LIKE "%'.$_POST['search']['value'].'%"
     OR numSiren LIKE "%'.$_POST['search']['value'].'%"
     OR raisonSociale LIKE "%'.$_POST['search']['value'].'%"   
     OR devise LIKE "%'.$_POST['search']['value'].'%" 
     OR dateRemise LIKE "%'.$_POST['search']['value'].'%")  
     ';
}


//pour les flèches
if(isset($_POST['order']))
{
    $query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= ' ORDER BY numRemise DESC ';
}

$query1 = '';

if($_POST['length'] != -1)
{
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
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
    $sub_array[] = $row['numRemise'];
    $sub_array[] = $row['dateRemise'];
    $sub_array[] = $row['numSiren'];
    $sub_array[] = $row['raisonSociale'];
    $sub_array[] = $row['nbrTransaction'];
    $sub_array[] = $row['montantTotal'];
    $sub_array[] = $row['devise'];

    $data[] = $sub_array;
}

function count_all_data($connect)
{
    return 0;
}


$output = array(
    //'draw'    => intval($_POST['draw']),
    'recordsTotal'  => count_all_data($dbh),
    'recordsFiltered' => $number_filter_row,
    'data'    => $data
);

echo json_encode($output);

?>