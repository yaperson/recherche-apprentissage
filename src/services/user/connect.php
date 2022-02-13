<?php
session_start();
$_SESSION["connecter"] = FALSE;

require_once '../../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\UserManager;

$logger = new Logger('connect');

$logger->pushHandler(new StreamHandler(__DIR__.'/../../../log/app.log', Logger::INFO));  // création anonyme

$loader = new FilesystemLoader('../../../templates');

$twig = new Environment($loader, ['cache' => '../../../cache']);

$error = '';

require_once("../../conf.php");

try {
    if (isset($_POST['email'])&&(isset($_POST['password']))){
        $db = new PDO($dsn, $usr, $pwd);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $newuser = new UserManager($db);
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
        $user = htmlspecialchars($_POST['email'], ENT_QUOTES);
        // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $newuser->connectUser($user, $password);

        $logger->info('New connection from ', ['user : '.$user => ' IP [ '.$newuser->getIp() . ']']);

    }
} catch(PDOException $e) {
    print('erreur de connection : ' . $e->getMessage());

    $logger->warning('Connection problem from', [$user => $newuser->getIp()]);
}     
echo $twig->render('connect.html.twig', [
    'title' => 'Connectez vous !!!!!!!!',
    'error' => $error,
    ]
);    

