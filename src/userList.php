<?php
session_start();

require_once '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\UserManager;

$logger = new Logger('main');

$logger->pushHandler(new StreamHandler(__DIR__.'/../log/app.log', Logger::DEBUG));  // création anonyme

$logger->info('Start...');

$loader = new FilesystemLoader('../templates');

$twig = new Environment($loader, ['cache' => '../cache']);

$error = '';

require_once("conf.php");
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    try {
        $db = new PDO($dsn, $usr, $pwd);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $UserManager = new UserManager($db);
        $user = $UserManager->getList();
    } catch(PDOException $e) {
        $error = 'erreur de connection : ' . $e->getMessage();
    }
    echo $twig->render('userList.html.twig', [
        'title' => 'Liste des utilisateurs',
        'users' => $user,
        'error' => $error,
        ]
    );
} else {
    header("connect.php");
    session_destroy();
}