<?php 
require_once('connect.php'); 
require_once('model/model.php');

$users  = get_users($db);
require_once('close.php'); 
require_once('vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader('view'); 
$twig   = new Twig\Environment($loader); 
echo $twig->render('index.twig');