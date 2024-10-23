<?php
include('../connexion.php');
if(!isset($_POST['numRemise'])){
    echo "<div>Pas de Remise</div>";
    exit;
}

$response = "
            <h3>Détail des transactions de la remise n°$_POST[numRemise]</h3>
            <table class='table table-striped'>
                <tr class='thead-dark'>
                      <th>N° transaction</th>
                      <th>Montant</th>
                      <th>Devise</th>
                      <th>N° carte</th>
                      <th>N° autorisation</th>
                      <th>Reséau</th>
                      <th>N° dossier impayé</th>
                      <th>Libellé impayé</th>
                </tr>
            <tbody>";
$request = "SELECT t.*, i.numDossierImpaye, ci.libelleImpaye 
            FROM transaction t 
                LEFT JOIN impaye i ON t.numTransaction = i.numTransaction 
                LEFT JOIN codeimpaye ci ON i.codeImpaye = ci.codeImpaye 
            WHERE numRemise=$_POST[numRemise]";
$result = $dbh->query($request);
if($result->rowCount() == 0){
    $response = "Remise vide";
}
while($line = $result->fetch()){
    $class =  $line['numDossierImpaye']?"style='background-color:#FF513E'":"";
    $response .= "
    <tr $class>
        <td>$line[numTransaction]</td>
        <td>$line[montant]</td>
        <td>$line[devise]</td>
        <td>$line[numCarte]</td>
        <td>$line[numAutorisation]</td>
        <td>$line[reseau]</td>
        <td>$line[numDossierImpaye]</td>
        <td>$line[libelleImpaye]</td>
    </tr>";
}
$response .= "</tbody></table>";
echo "<div>$response</div>";
?>




