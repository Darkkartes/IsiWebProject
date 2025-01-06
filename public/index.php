<?php
require_once('../model/connect.php');
require_once('../model/model.php');
require_once('../vendor/autoload.php');
$loader = new Twig\Loader\FilesystemLoader('../template');
$twig = new Twig\Environment($loader);
session_start();
$twig->addGlobal('session', $_SESSION);

$connected = $_SESSION;

if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    if (isset($_GET['name']) && $_GET['name'] == 'entreprise') {
        $entreprises = get_entreprises($db);
        echo $twig->render('view/entreprise.twig', ['entreprises' => $entreprises, 'connected' => $connected]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'stagiaire') {
        $etudiants = get_etudiants($db);
        echo $twig->render('view/stagiaire.twig', ['etudiants' => $etudiants, 'connected' => $connected]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'deconnexion') {
        session_destroy();
        header('Location: index.php');
        exit();
    } else if (isset($_GET['name']) && $_GET['name'] == 'aide') {
        echo $twig->render('view/aide.twig', ['connected' => $connected]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'inscription') {
        if ($_SESSION['role'] == 'professeur') {
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
                    'professeurs' => $professeurs,
                    'connected' => $connected
                ]);
            }
        } else {
            echo "<script>alert('Sorry, you do not have permission to register a student.'); window.location.href='index.php';</script>";
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'detailsetu') {
        if ($_SESSION['role'] == 'professeur' || $_SESSION['id'] == $_GET['id']) {
            $stagiaire = get_etudiant_par_id($db);
            echo $twig->render('view/details_etu.twig', ['stagiaire' => $stagiaire, 'connected' => $connected]);
        } else {
            echo "<script>alert('Sorry, you do not have permission to view this student.'); window.location.href='index.php?name=stagiaire';</script>";
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'detailsent') {
        $entreprise = get_entreprise_par_id($db);
        $specialites = get_specialites_par_entreprise($db);
        echo $twig->render('view/details_ent.twig', [
            'entreprise' => $entreprise,
            'specialites' => $specialites,
            'connected' => $connected
        ]);
    } else if (isset($_GET['name']) && $_GET['name'] == 'ajoutetu') {
        if ($_SESSION['role'] == 'professeur') {
            if (
                isset($_POST['nom']) && !empty($_POST['nom'])
                && isset($_POST['prenom']) && !empty($_POST['prenom'])
                && isset($_POST['utilisateur']) && !empty($_POST['utilisateur'])
                && isset($_POST['mdp']) && !empty($_POST['mdp'])
                && isset($_POST['classe']) && !empty($_POST['classe'])
            ) {
                addEtudiant($db);
            } else {
                echo $twig->render('view/ajout_etu.twig', ['connected' => $connected]);
            }
        } else {
            echo "<script>alert('Sorry, you do not have permission to add a student.'); window.location.href='index.php?name=stagiaire';</script>";
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'ajoutent') {
        if ($_SESSION['role'] == 'professeur') {
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
                echo $twig->render('view/ajout_ent.twig', ['connected' => $connected]);
            }
        } else {
            echo "<script>alert('Sorry, you do not have permission to add an enterprise.'); window.location.href='index.php?name=entreprise';</script>";
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'deleteetu') {
        if ($_SESSION['role'] == 'professeur') {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                delete_etudiant($db);
            }
            echo $twig->render('view/stagiaire.twig', ['connected' => $connected]);
        } else {
            echo "<script>alert('Sorry, you do not have permission to delete a student.'); window.location.href='index.php?name=stagiaire';</script>";
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'deleteent') {
        if ($_SESSION['role'] == 'professeur') {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                delete_entreprise($db);
            }
            echo $twig->render('view/entreprise.twig', ['connected' => $connected]);
        } else {
            echo "<script>alert('Sorry, you do not have permission to delete an enterprise.'); window.location.href='index.php?name=entreprise';</script>";
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'rechercheetu') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiants = get_etudiants_recherche($db);
            echo $twig->render('view/stagiaire.twig', ['etudiants' => $etudiants, 'connected' => $connected]);
        } else {
            $professeurs = get_professeurs($db);
            $entreprises = get_entreprises($db);
            echo $twig->render('view/recherche_etu.twig', [
                'professeurs' => $professeurs,
                'entreprises' => $entreprises,
                'connected' => $connected
            ]);
        }
    } else if (isset($_GET['name']) && $_GET['name'] == 'modifetu') {
        if ($_SESSION['role'] == 'professeur' || $_SESSION['id'] == $_GET['id']) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (
                    isset($_POST['nom']) && !empty($_POST['nom'])
                    && isset($_POST['prenom']) && !empty($_POST['prenom'])
                    && isset($_POST['utilisateur']) && !empty($_POST['utilisateur'])
                    && isset($_POST['mdp']) && !empty($_POST['mdp'])
                    && isset($_POST['classe']) && !empty($_POST['classe'])
                ) {
                    modifEtudiant($db);
                }
                $etudiant = get_etudiant_par_id($db);
                echo $twig->render('view/modif_etu.twig', ['etudiant' => $etudiant, 'connected' => $connected]);
            } else {
                $etudiant = get_etudiant_par_id($db);
                echo $twig->render('view/modif_etu.twig', ['etudiant' => $etudiant, 'connected' => $connected]);
            }
        } else {
            echo "<script>alert('Sorry, you do not have permission to modify this student.'); window.location.href='index.php?name=stagiaire';</script>";
        }
    } else {
        echo $twig->render('view/accueil.twig', ['connected' => $connected]);
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            isset($_POST['login']) && !empty($_POST['login'])
            && isset($_POST['mdp']) && !empty($_POST['mdp'])
        ) {
            if ($_POST['role'] == 'etudiant') {
                connexionEtudiant($db);
            } else if ($_POST['role'] == 'professeur') {
                connexionProfesseur($db);
            }
            if ($_SESSION['connected']) {
                echo $twig->render('view/accueil.twig', ['connected' => $connected]);
            } else {
                echo $twig->render('view/connexion.twig', ['connected' => $connected]);
            }
        } else {
            echo $twig->render('view/connexion.twig', ['connected' => $connected]);
        }
    } else {
        echo $twig->render('view/connexion.twig', ['connected' => $connected]);
    }
}
require_once('../model/close.php');
