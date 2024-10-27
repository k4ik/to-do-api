<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/con.php'; 
use Controller\TasksController;

$tasksController = new TasksController($pdo);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($requestMethod) {
    case 'GET':
        if (count($uri) === 1 && $uri[0] === 'tasks') {
            echo $tasksController->view_tasks();
        }
        break;

    case 'POST':
        if (count($uri) === 1 && $uri[0] === 'tasks') {
            echo $tasksController->create_task();
        }
        break;

    case 'PUT':
        if (count($uri) === 2 && $uri[0] === 'tasks') {
            $id = (int)$uri[1];
            echo $tasksController->update_task($id);
        }
        break;

    case 'DELETE':
        if (count($uri) === 2 && $uri[0] === 'tasks') {
            $id = (int)$uri[1];
            echo $tasksController->delete_task($id);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
        break;
}
