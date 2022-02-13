<?php
require_once '../../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Classes\Manager\UserManager;

$logger = new Logger('add user');

$logger->pushHandler(new StreamHandler(__DIR__.'/../../../log/app.log', Logger::DEBUG));  // création anonyme

$loader = new FilesystemLoader('../../../templates');

$twig = new Environment($loader, ['cache' => '../../../cache']);

$error = '';

require_once("../../conf.php");

session_start();
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    try {
        if (isset($_POST['email'])&&(isset($_POST['password']))){
            $db = new PDO($dsn, $usr, $pwd);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $newuser = new UserManager($db);
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $newuser->addUser($email, $password);

            $logger->info('New user created', [$email]);
            
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
} else {
    header("connect.php");
    session_destroy();
}

?>



