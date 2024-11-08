<?php
require_once('../connect.php');
require_once('../model/model.php');

require_once('../close.php');
require_once('../vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader('../template/view');
$twig   = new Twig\Environment($loader);
echo $twig->render('accueil.twig');
