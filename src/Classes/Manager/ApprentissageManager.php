<?php
namespace App\Classes\Manager;

use PDO;
use App\Classes\Entity\Apprentissage;

class ApprentissageManager
{
    private $_db;

    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    public function setDb($db): ApprentissageManager
    {
        $this->_db = $db;
        return $this;
    }

    public function addApprentissage($entreprise, $contact, $lieux, $poste, $teletravail, $candidature)
    {
        // Netoyge des donnés envoyées
        // $email = strip_tags($_POST['email']);
        // $password = strip_tags($_POST['password']);

        $stmt = $this->_db->prepare("INSERT INTO apprentissage (entreprise, contact, lieux, poste, teletravail, candidature) VALUE (?, ?, ?, ?, ?, ?);");
        $stmt->bindParam(1, $entreprise);
        $stmt->bindParam(2, $contact);
        $stmt->bindParam(3, $lieux);
        $stmt->bindParam(4, $poste);
        $stmt->bindParam(5, $teletravail);
        $stmt->bindParam(6, $candidature);

        // Appel de la procédure stockée
        $stmt->execute();
    }

    public function deleteApprentissage($id) //:bool

    {
        $stmt = $this->_db->prepare("DELETE FROM `apprentissage` WHERE id = ?;");
        $stmt->bindParam(1, $id);

        $stmt->execute();
    }

    public function updateApprentissage($entreprise, $contact, $lieux, $poste, $teletravail, $candidature) //:bool

    {        
        $stmt = $this->_db->prepare("UPDATE apprentissage (entreprise, contact, lieux, poste, teletravail, candidature) VALUE (?, ?, ?, ?, ?, ?);");
        $stmt->bindParam(1, $entreprise);
        $stmt->bindParam(2, $contact);
        $stmt->bindParam(3, $lieux);
        $stmt->bindParam(4, $poste);
        $stmt->bindParam(5, $teletravail);
        $stmt->bindParam(6, $candidature);
    }

    public function getList(): array
    {
        $apprentissageList = array();

        $request = $this->_db->query('SELECT id, entreprise, contact, lieux, poste, teletravail, candidature FROM apprentissage;');
        while ($ligne = $request->fetch(PDO::FETCH_ASSOC)) {
            $apprentissage = new Apprentissage($ligne);
            $apprentissageList[] = $apprentissage;
        }
        return $apprentissageList;
    }

    public function getOne(): array
    {
        $apprentissageList = array();
        $apprentissage_id = $_GET['id'];
        $request = $this->_db->prepare('SELECT id, entreprise, contact, lieux, poste, teletravail, candidature FROM apprentissage WHERE id = ?;');

        $request->bindParam(1, $apprentissage_id);
        $request->execute();

        while ($ligne = $request->fetch(PDO::FETCH_ASSOC)) {
            $apprentissage = new Apprentissage($ligne);
            $apprentissageList[] = $apprentissage;
        }
        return $apprentissageList;
    }
}


?>