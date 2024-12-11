<?php
require_once('../model/connect.php');
require_once('../model/model.php');
require_once('../vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader('../template');
$twig   = new Twig\Environment($loader);

if (returnFalse()) {
    if (isset($_GET['name']) && $_GET['name'] == 'entreprise') {
        echo $twig->render('view/entreprise.twig');
    } else if (isset($_GET['name']) && $_GET['name'] == 'stagiaire') {
        echo $twig->render('view/stagiaire.twig');
    } else if (isset($_GET['name']) && $_GET['name'] == 'deconnexion') {
        echo $twig->render('view/deconnexion.twig');
    } else if (isset($_GET['name']) && $_GET['name'] == 'aide') {
        echo $twig->render('view/aide.twig');
    } else if (isset($_GET['name']) && $_GET['name'] == 'inscription') {
        echo $twig->render('view/inscription.twig');
    } else {
        echo $twig->render('view/accueil.twig');
    }
} else {
    echo $twig->render('view/connexion.twig');
}
require_once('../model/close.php');
