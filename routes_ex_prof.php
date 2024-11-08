<?php
use App\Controller\UserController;

// Récupérer les paramètres de l'URL
$action = $_GET['action'] ?? null; // Action de la route
$id = $_GET['id'] ?? null;         // ID dans les routes (ex: pour 'edit', 'delete')

// Initialisation du contrôleur
$controller = null;
$method = null;

switch ($action) {
    case 'create':
        $controller = 'UserController';
        $method = 'createUser';
        break;
    case 'edit':
        $controller = 'UserController';
        $method = 'editUser';
        break;
    case 'update':
        $controller = 'UserController';
        $method = 'updateUser';
        break;
    case 'delete':
        $controller = 'UserController';
        $method = 'deleteUser';
        break;
    default:
        $controller = 'UserController';
        $method = 'listUsers';  // Par défaut afficher la liste
        break;
}

// Vérifier si le contrôleur et la méthode sont définis et appelés
if ($controller && $method) {
    require_once '../config/database.php'; // Connexion à la base de données
    $controllerClass = 'App\\Controller\\' . $controller;
    $controllerObject = new $controllerClass($pdo);

    // Appeler la méthode du contrôleur avec l'ID si besoin
    if ($action == 'edit' || $action == 'update' || $action == 'delete') {
        $controllerObject->$method($id);
    } else {
        $controllerObject->$method();
    }
} else {
    echo "404 Not Found";
}
