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

try {
    if (isset($_POST['email'])&&(isset($_POST['password']))){
        $db = new PDO($dsn, $usr, $pwd);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $newuser = new UserManager($db);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $newuser->addUser($_POST['email'], $password);
        header('Location: connect.php');
    }
} catch(PDOException $e) {
    print('erreur de connection : ' . $e->getMessage());
}
echo $twig->render('addUser.html.twig', [
    'title' => 'Nouvel utilisateur',
    'error' => $error,
    ]
);    

?>



