<?php


//fetchRemise.php
session_start();
include('../connexion.php');
$column = array('numSiren', 'raisonSociale', 'montant');

// Récupération des critères.
$numSiren = isset($_SESSION['numSiren'])? $_SESSION['numSiren']:"";

$query = "SELECT
    numSiren,
    raisonSociale,
    sum(montant) AS montant
FROM
    `client`
NATURAL JOIN `remise`
NATURAL JOIN `transaction`
WHERE montant < 0

";


if ($numSiren != "") {
    $query .= " AND CAST(numSiren as CHAR) LIKE '%$numSiren%' ";
}


//pour la recherche
if(isset($_POST['search']['value']))
{
    $query .= '
     AND (numSiren LIKE "%'.$_POST['search']['value'].'%" 
     OR raisonSociale LIKE "%'.$_POST['search']['value'].'%" 
     OR montant LIKE "%'.$_POST['search']['value'].'%"
     )  
     ';
}

$query .= ' GROUP BY numClient ';

//pour les flèches
if(isset($_POST['order']))
{
    $query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= ' ORDER BY numSiren DESC ';
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
    $sub_array[] = $row['raisonSociale'];
    $sub_array[] = $row['montant'];


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