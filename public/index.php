<?php

session_start();
if(!isset($_SESSION['admin']))
    $_SESSION['admin'] = false;
if(!isset($_SESSION['page']))
    $_SESSION['page'] = 1;
if(!isset($_GET['page']))
    $_SESSION['page'] = 1;

require_once __DIR__.'/../vendor/autoload.php';

use app\Router;
use app\controllers\MainController;

$router = new Router();

$router->get('/', [MainController::class, 'index']);
$router->get('/shop', [MainController::class, 'shop']);

$router->get('/login', [MainController::class, 'login']);
$router->post('/login', [MainController::class, 'login']);
$router->get('/logout', [MainController::class, 'logout']);

$router->get('/admin', [MainController::class, 'adminIndex']);
$router->post('/admin', [MainController::class, 'adminIndex']);
$router->get('/admin/create', [MainController::class, 'create']);
$router->get('/admin/update', [MainController::class, 'update']);
$router->post('/admin/create', [MainController::class, 'create']);
$router->post('/admin/update', [MainController::class, 'update']);
$router->post('/admin/delete', [MainController::class, 'delete']);

$router->resolve();

?>