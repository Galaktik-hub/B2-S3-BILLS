<?php

//fetchRemise.php
session_start();

include('../connexion.php');
$column = array('numSiren','numRemise', 'dateRemise' , 'raisonSociale', 'nbrTransaction', 'montantTotal', 'devise');

// Récupération des critères.
$numSiren = isset($_SESSION['numSiren'])? $_SESSION['numSiren']:"";
$debut = isset($_SESSION['debut.date'])? $_SESSION['debut.date']: "";
$fin = isset($_SESSION['fin.date'])? $_SESSION['fin.date']: date('Y-m-d');

$query = 'SELECT numSiren, numRemise, dateRemise,raisonSociale, nbrTransaction, montantTotal, devise 
            FROM `remise` NATURAL JOIN client  ';

//AND DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$date'"

if ($numSiren != "") {
    $query .= " WHERE CAST(numSiren as CHAR) LIKE '%$numSiren%' AND";
}
else {
    $query .= " WHERE ";
}
if ($debut != "" && $fin != "") {
    $query .= " DATE_FORMAT(dateRemise, '%Y-%m-%d') BETWEEN '$debut' AND '$fin' ";
} else if ($debut != "") {
    $query .= " DATE_FORMAT(dateRemise, '%Y-%m-%d') >= '$debut' ";
} else if ($fin != "") {
    $query .= " DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$fin' ";
}

if ($debut != "" || $fin != "") {
    $query .= "AND ";
}

//pour la recherche
if(isset($_POST['search']['value']))
{
    $query .= '
     (numRemise LIKE "%'.$_POST['search']['value'].'%" 
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
    $query .= ' ORDER BY numSiren ASC ';
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
    $sub_array[] = $row['numSiren'];
    $sub_array[] = $row['numRemise'];
    $sub_array[] = $row['dateRemise'];
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