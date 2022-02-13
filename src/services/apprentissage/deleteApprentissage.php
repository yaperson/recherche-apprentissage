<?php
require_once '../../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\ApprentissageManager;

$logger = new Logger('main');

$logger->pushHandler(new StreamHandler(__DIR__.'/../../../log/app.log', Logger::INFO));  // création anonyme

$loader = new FilesystemLoader('../../../templates');

$twig = new Environment($loader, ['cache' => '../../../cache']);

$error = '';

require_once("../../conf.php");

session_start();
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    try {
        if (isset($_POST['id'])){
            $id = $_POST['id'];
            $db = new PDO($dsn, $usr, $pwd);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $newApprentissage = new ApprentissageManager($db);
            $newApprentissage->deleteApprentissage($id);

            $logger->info('delete opportunity from database, opportunity ID :', ['opportunity ID : '.$id . ' | action start by user ID : '. $_SESSION['user_id']]);

            header('Location: apprentissageList.php');
        }
    } catch(PDOException $e) {
        print('erreur de connection : ' . $e->getMessage());
    }
} else {
    header("connect.php");
    session_destroy();
}


?>



