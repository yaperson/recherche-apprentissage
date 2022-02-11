<?php
session_start();
$_SESSION["connecter"] = false;
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
unset($_SESSION["connecter"]);
unset($_SESSION["user_id"]);
session_destroy();
header('Location: index.html');