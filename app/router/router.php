<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TaskController.php';


session_start();

$request = $_GET['url'] ?? '';
$request = rtrim($request, '/');
$request = filter_var($request, FILTER_SANITIZE_URL);
$request = explode('/', $request);

$controller = 'AuthController';
$method = 'login';
$params = [];

if (!empty($request[0])) {
    switch($request[0]) {
        case 'register':
            $method = 'register';
            break;
        case 'logout':
            $method = 'logout';
            break;
        case 'tasks':
            $controller = 'TaskController';
            if (isset($request[1])) {
                switch($request[1]) {
                    case 'create':
                        $method = 'create';
                        break;
                    case 'store':
                        $method = 'store';
                        break;
                    case 'edit':
                        $method = 'edit';
                        $params[] = $request[2] ?? '';
                        break;
                    case 'update':
                        $method = 'update';
                        $params[] = $request[2] ?? '';
                        break;
                    case 'delete':
                        $method = 'delete';
                        $params[] = $request[2] ?? '';
                        break;
                    case 'filter':
                        $method = 'filter';
                        $params[] = $request[2] ?? '';
                        break;
                    default:
                        $method = 'index';
                }
            } else {
                $method = 'index';
            }
            break;
        default:
            $method = 'login';
    }
}

// Check if user is logged in for task routes
if ($controller === 'TaskController' && !isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$controller = new $controller;
call_user_func_array([$controller, $method], $params);
?>