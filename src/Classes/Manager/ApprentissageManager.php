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

    public function update(Apprentissage $apprentissage) //:bool

    {
        // TODO
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
}


?>