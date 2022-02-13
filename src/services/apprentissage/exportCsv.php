<?php
header('Content-Type: text/csv;');
header('Content-Disposition: attachment; filename="Liste-candidature.csv"');
require_once("../../conf.php");

try {
    $db = new PDO($dsn, $usr, $pwd);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
} 
catch (PDOException $e){
    print($e->getMessage());
}
$Requete = $db->prepare("SELECT id, entreprise, contact, lieux, poste, teletravail, candidature FROM apprentissage");
$Requete->execute();
$data = $Requete->fetchAll();
?>
"Entreprise";"contact";"lieux";"poste";"teletravail";"candidature"; 
<?php 
foreach($data as $d){
    echo '"'.$d->entreprise.'";"'.$d->contact.'";"'.$d->lieux.'";"'.$d->poste.'";"'.$d->teletravail.'";"'.$d->candidature.'"'.";\n";
}
?>
