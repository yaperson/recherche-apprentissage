<?php
require_once '../../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\ApprentissageManager;

$logger = new Logger('new opportunity');

$logger->pushHandler(new StreamHandler(__DIR__.'/../../../log/app.log', Logger::INFO));  // création anonyme

$loader = new FilesystemLoader('../../../templates');

$twig = new Environment($loader, ['cache' => '../../../cache']);

$error = '';

require_once("../../conf.php");

session_start();
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    try {
        if (isset($_POST['entreprise'])&&(isset($_POST['contact']))){
            $db = new PDO($dsn, $usr, $pwd);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $newOpportunity = new ApprentissageManager($db); //entreprise, contact, lieux, poste, teletravail, candidature
            $newOpportunity->addApprentissage($_POST['entreprise'], $_POST['contact'], $_POST['lieux'], $_POST['poste'], $_POST['teletravail'], $_POST['candidature']);

            $logger->info('Add opportunity in database' , [ 'user ID : ' . $_SESSION['user_id'] , 'Opportunity name : ' . $_POST['poste'] ]);

            header('Location: apprentissageList.php');
        }
    } catch(PDOException $e) {
        print('erreur de connection : ' . $e->getMessage());
    }
    echo $twig->render('addApprentissage.html.twig', [
        'title' => 'Nouvel opportunitée',
        'error' => $error,
        ]
    ); 
} else {
    header("connect.php");
    session_destroy();
}


?>



