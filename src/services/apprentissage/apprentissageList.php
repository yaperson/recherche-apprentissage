<?php
require_once '../../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\ApprentissageManager;
use App\Classes\Manager\UserManager;
use App\Classes\Entity\User;

$logger = new Logger('main');

$logger->pushHandler(new StreamHandler(__DIR__.'/../../../log/app.log', Logger::DEBUG));  // création anonyme

$logger->info('Start...');

$loader = new FilesystemLoader('../../../templates');

$twig = new Environment($loader, ['cache' => '../../../cache']);

$error = '';

require_once("../../conf.php");

session_start();
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    try {
        $db = new PDO($dsn, $usr, $pwd);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $ApprentissageManager = new ApprentissageManager($db);
        $UserManager = new UserManager($db);

        $user = $UserManager->getOne();
        $apprentissage = $ApprentissageManager->getList();

    } catch(PDOException $e) {
        $error = 'erreur de connection : ' . $e->getMessage();
    }
    echo $twig->render('apprentissageList.html.twig', [
        'title' => 'Liste des opportunités',
        'apprentissages' => $apprentissage,
        'user' => $user,
        'error' => $error,
        ]
    );
} else {
    header("connect.php");
    session_destroy();
}