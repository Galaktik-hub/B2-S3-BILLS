<?PHP
/* Connexion au serveur et à la base de données */
include('parametre.php');
// Connexion avec avec PDO
$host="127.0.0.1";
$user="root";
$pwd="";
$db="banque";
try{
    $con='mysql:host='.$host.';dbname='.$db;
    $dbh = new PDO($con,$user,$pwd,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->exec('SET NAMES utf8');
}
catch(Exception $e){
    die('Connexion impossible à la base de données !'.$e->getMessage());
}
?>