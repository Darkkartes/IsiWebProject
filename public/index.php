<?php
require_once('../model/connect.php');
require_once('../model/model.php');
require_once('../vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader('../template');
$twig = new Twig\Environment($loader);

if (returnTrue()) {
    if (isset($_GET['name']) && $_GET['name'] == 'entreprise') {
        $entreprises = get_entreprises($db);
        echo $twig->render('view/entreprise.twig', ['entreprises' => $entreprises]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'stagiaire') {
        $etudiants = get_etudiants($db);
        echo $twig->render('view/stagiaire.twig', ['etudiants' => $etudiants]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'deconnexion') {
        echo $twig->render('view/deconnexion.twig');
    } else if (isset($_GET['name']) && $_GET['name'] == 'aide') {
        echo $twig->render('view/aide.twig');
    } else if (isset($_GET['name']) && $_GET['name'] == 'inscription') {
        if (
            isset($_POST['date_debut']) && !empty($_POST['date_debut'])
            && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
            && isset($_POST['type']) && !empty($_POST['type'])
            && isset($_POST['entreprises']) && !empty($_POST['entreprises'])
            && isset($_POST['stagiaires']) && !empty($_POST['stagiaires'])
            && isset($_POST['professeurs']) && !empty($_POST['professeurs'])
        ) {
            addStage($db);
        } else {
            $entreprises = get_entreprises($db);
            $stagiaires = get_etudiants($db);
            $professeurs = get_professeurs($db);
            echo $twig->render('view/inscription.twig', [
                'stagiaires' => $stagiaires,
                'entreprises' => $entreprises,
                'professeurs' => $professeurs
            ]);
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'detailsetu') {
        $stagiaire = get_etudiant_par_id($db);
        echo $twig->render('view/details_etu.twig', $stagiaire);
    } else if (isset($_GET['name']) && $_GET['name'] == 'detailsent') {
        $entreprise = get_entreprise_par_id($db);
        echo $twig->render('view/details_ent.twig', $entreprise);
    } else if (isset($_GET['name']) && $_GET['name'] == 'ajoutent') {
        echo $twig->render('view/ajout_ent.twig'); 
    } else if (isset($_GET['name']) && $_GET['name'] == 'ajoutetu') {
        echo $twig->render('view/ajout_etu.twig'); 
    } else {
        echo $twig->render('view/accueil.twig');
    }
} else {
    echo $twig->render('view/connexion.twig');
}
require_once('../model/close.php');
