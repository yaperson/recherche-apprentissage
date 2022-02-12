<?php
require_once '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\ApprentissageManager;

$logger = new Logger('main');

$logger->pushHandler(new StreamHandler(__DIR__.'/../log/app.log', Logger::DEBUG));  // création anonyme

$logger->info('Start...');

$loader = new FilesystemLoader('../templates');

$twig = new Environment($loader, ['cache' => '../cache']);

$error = '';

require_once("conf.php");

session_start();
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    try {
        if (isset($_POST['id'])){
            $db = new PDO($dsn, $usr, $pwd);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $newApprentissage = new ApprentissageManager($db);
            $newApprentissage->deleteApprentissage($_POST['id']);
            header('Location: apprentissageList.php');
        }
    } catch(PDOException $e) {
        print('erreur de connection : ' . $e->getMessage());
    }
    echo $twig->render('addApprentissage.html.twig', [
        'title' => 'Supprimer',
        'error' => $error,
        ]
    ); 
} else {
    header("connect.php");
    session_destroy();
}


?>



