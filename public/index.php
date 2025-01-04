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
        $specialites = get_specialites_par_entreprise($db);
        echo $twig->render('view/details_ent.twig', [
            'entreprise' => $entreprise,
            'specialites' => $specialites
        ]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'ajoutetu') {
        if (
            isset($_POST['nom']) && !empty($_POST['nom'])
            && isset($_POST['prenom']) && !empty($_POST['prenom'])
            && isset($_POST['utilisateur']) && !empty($_POST['utilisateur'])
            && isset($_POST['mdp']) && !empty($_POST['mdp'])
            && isset($_POST['classe']) && !empty($_POST['classe'])
        ) {
            addEtudiant($db);
        } else {
            echo $twig->render('view/ajout_etu.twig');
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'ajoutent') {
        if (
            isset($_POST['entreprise']) && !empty($_POST['entreprise'])
            && isset($_POST['rue']) && !empty($_POST['rue'])
            && isset($_POST['ville']) && !empty($_POST['ville'])
            && isset($_POST['code_postal']) && !empty($_POST['code_postal'])
            && isset($_POST['telephone']) && !empty($_POST['telephone'])
            && isset($_POST['mail']) && !empty($_POST['mail'])
            && isset($_POST['niveau']) && !empty($_POST['niveau'])
        ) {
            addEntreprise($db);
        } else {
            echo $twig->render('view/ajout_ent.twig');
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'deleteetu') {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            delete_etudiant($db);
        }
        echo $twig->render('view/stagiaire.twig');
    } else {
        echo $twig->render('view/accueil.twig');
    }
} else {
    echo $twig->render('view/connexion.twig');
}
require_once('../model/close.php');
