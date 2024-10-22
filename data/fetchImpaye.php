<?php

//fetchRemise.php
session_start();

include('../connexion.php');
$column = array('numDossierImpaye', 'numSiren', 'dateRemise', 'numCarte', 'reseau', 'devise', 'montant', 'libelleImpaye');

// Récupération des critères.
$numClient = $_SESSION['numClient'];
$debut = isset($_SESSION['impaye.debut'])? $_SESSION['impaye.debut']: "";
$fin = isset($_SESSION['impaye.fin'])? $_SESSION['impaye.fin']: date('Y-m-d');

$query = "SELECT
    dateRemise,
    numCarte,
    reseau,
    numDossierImpaye,
    transaction.devise,
    montant,
    libelleImpaye
FROM
    `remise`
NATURAL JOIN `transaction`
NATURAL JOIN `impaye`
NATURAL JOIN `codeimpaye`
WHERE numClient = $numClient";

//AND DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$date'"

if ($debut != "" && $fin != "") {
    $query .= " AND DATE_FORMAT(dateRemise, '%Y-%m-%d') BETWEEN '$debut' AND '$fin' ";
} else if ($debut != "") {
    $query .= " AND DATE_FORMAT(dateRemise, '%Y-%m-%d') >= '$debut' ";
} else if ($fin != "") {
    $query .= " AND DATE_FORMAT(dateRemise, '%Y-%m-%d') <= '$fin' ";
}


//pour la recherche
if(isset($_POST['search']['value']))
{
    $query .= '
     AND (dateRemise LIKE "%'.$_POST['search']['value'].'%" 
     OR numCarte LIKE "%'.$_POST['search']['value'].'%" 
     OR reseau LIKE "%'.$_POST['search']['value'].'%"
     OR numDossierImpaye LIKE "%'.$_POST['search']['value'].'%"
     OR devise LIKE "%'.$_POST['search']['value'].'%"   
     OR montant LIKE "%'.$_POST['search']['value'].'%"
     OR libelleImpaye LIKE "%'.$_POST['search']['value'].'%")  
     ';
}


//pour les flèches
if(isset($_POST['order']))
{
    $query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= ' ORDER BY numDossierImpaye DESC ';
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
    $sub_array[] = $row['numDossierImpaye'];
    $sub_array[] = $_SESSION['numSiren'];
    $sub_array[] = $row['dateRemise'];
    $sub_array[] = $row['numCarte'];
    $sub_array[] = $row['reseau'];
    $sub_array[] = $row['devise'];
    $sub_array[] = $row['montant'];
    $sub_array[] = $row['libelleImpaye'];

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