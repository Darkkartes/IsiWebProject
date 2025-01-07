<?php
/**
 * Retrieves an array of entreprises from the database.
 *
 * @param PDO $db The database connection object.
 * @return array An array of enterprises' information.
 */
function get_entreprises($db)
{
    $sql = 'SELECT 
    entreprise.num_entreprise,
    entreprise.raison_sociale,
    entreprise.rue_entreprise,
    entreprise.ville_entreprise,
    entreprise.cp_entreprise,
    entreprise.site_entreprise,
    entreprise.nom_resp,
    GROUP_CONCAT(specialite.libelle SEPARATOR \',\') AS specialites
    FROM 
    spec_entreprise
    JOIN 
    entreprise USING (num_entreprise)
    JOIN 
    specialite USING (num_spec)
    GROUP BY 
    entreprise.num_entreprise, entreprise.raison_sociale
    ORDER BY entreprise.raison_sociale;';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * Retrieves an array of the information and specialities of the entreprise whose id is stored in $_GET['id'].
 * @param PDO $db The database connection object.
 * @return array An array of the entreprise's information and its specialities.
 */
function get_specialites_par_entreprise($db)
{
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT 
                    entreprise.num_entreprise,
                    entreprise.raison_sociale,
                    entreprise.rue_entreprise,
                    entreprise.site_entreprise,
                    entreprise.nom_resp,
                    GROUP_CONCAT(specialite.libelle SEPARATOR \',\') AS specialites
                FROM spec_entreprise
                JOIN entreprise USING (num_entreprise)
                JOIN specialite USING (num_spec)
                WHERE entreprise.num_entreprise = :id
                GROUP BY entreprise.num_entreprise, entreprise.raison_sociale
                ORDER BY entreprise.raison_sociale;';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    return $result;
}

/**
 * Retrieves the information of the entreprise whose id is stored in $_GET['id'].
 * @param PDO $db The database connection object.
 * @return array An array of the entreprise's information.
 */
function get_entreprise_par_id($db)
{
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `entreprise` where num_entreprise = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    return $result;
}

/**
 * Retrieves the information of the student whose id is stored in $_GET['id'].
 * @param PDO $db The database connection object.
 * @return array An array of the student's information.
 */
function get_etudiant_par_id($db)
{
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `etudiant` where num_etudiant = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    return $result;
}

/**
 * Retrieves the information of the students.
 * @param PDO $db The database connection object.
 * @return array An array of the students' information.
 */
function get_etudiants($db)
{
    $sql = 'SELECT DISTINCT
                nom_etudiant, 
                prenom_etudiant, 
                GROUP_CONCAT(entreprise.raison_sociale SEPARATOR \', \') AS raison_sociale,
                GROUP_CONCAT(CONCAT (professeur.nom_prof, \' \', professeur.prenom_prof)) AS nom_prof,
                num_etudiant
            FROM 
                etudiant 
            LEFT JOIN 
                stage USING (num_etudiant) 
            LEFT JOIN 
                professeur USING (num_prof) 
            LEFT JOIN 
                entreprise USING (num_entreprise)
            GROUP BY 
                num_etudiant, nom_etudiant, prenom_etudiant, raison_sociale, nom_prof, prenom_prof
            ORDER BY 
                nom_etudiant;';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * Delete the student whose id is stored in $_GET['id'] of the database.
 * @param PDO $db The database connection object.
 * @return void
 */
function delete_etudiant($db)
{
    $id = strip_tags($_GET['id']);

    $sql = 'DELETE FROM `stage` where num_etudiant = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $sql = 'DELETE FROM `etudiant` where num_etudiant = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $_SESSION['message'] = 'Etudiant supprimé';
    header('Location: index.php?name=stagiaire');
}

/**
 * Delete the entreprise whose id is stored in $_GET['id'] of the database.
 * @param PDO $db The database connection object.
 * @return void
 */
function delete_entreprise($db)
{
    $id = strip_tags($_GET['id']);

    $sql = 'DELETE FROM `spec_entreprise` where num_entreprise = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $sql = 'DELETE FROM `stage` where num_entreprise = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $sql = 'DELETE FROM `entreprise` where num_entreprise = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $_SESSION['message'] = 'Entreprise supprimée';
    header('Location: index.php?name=entreprise');
}

/**
 * Retrieves the information of stages from the database.
 * @param PDO $db The database connection object.
 * @return array An array of the stages' information.
 */
function get_stages($db)
{
    $sql = 'SELECT * FROM `stage`';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * Retrieves the information of the stage whose id is stored in $_GET['id'].
 * @param PDO $db The database connection object.
 * @return array An array of the stage's information.
 */
function get_stage_par_id($db)
{
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `stage` where num_stage = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * Retrieves an array of the teachers of the database.
 * @param PDO $db The database connection object.
 * @return void An array of the teachers' information.
 */
function get_professeurs($db)
{
    $sql = 'SELECT * FROM `professeur` order by nom_prof';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * Add a stage to the database using the information stored with the get method.
 * @param PDO $db The database connection object.
 * @return void
 */
function addStage($db)
{
    $debut_stage = strip_tags($_POST['date_debut']);
    $fin_stage = strip_tags($_POST['date_fin']);
    if (isset($_POST['description'])) {
        $description = strip_tags($_POST['description']);
    } else {
        $description = null;
    }
    $type_stage = strip_tags($_POST['type']);
    if (isset($_POST['observation'])) {
        $observation = strip_tags($_POST['observation']);
    } else {
        $observation = null;
    }
    $nom_entreprise = strip_tags($_POST['entreprises']);
    $nom_stagiare = strip_tags($_POST['stagiaires']);
    $nom_prof = strip_tags($_POST['professeurs']);
    $sql = 'SELECT num_entreprise FROM `entreprise` where raison_sociale = :nom_entreprise';
    $query = $db->prepare($sql);
    $query->bindValue(':nom_entreprise', $nom_entreprise, PDO::PARAM_STR);
    $query->execute();
    $num_entreprise = $query->fetch();
    $sql = 'SELECT num_etudiant FROM `etudiant` where nom_etudiant = :nom_stagiare';
    $query = $db->prepare($sql);
    $query->bindValue(':nom_stagiare', $nom_stagiare, PDO::PARAM_STR);
    $query->execute();
    $num_stagiare = $query->fetch();
    $sql = 'SELECT num_prof FROM `professeur` where nom_prof = :nom_prof';
    $query = $db->prepare($sql);
    $query->bindValue(':nom_prof', $nom_prof, PDO::PARAM_STR);
    $query->execute();
    $num_prof = $query->fetch();
    $sql = 'INSERT INTO `stage` (debut_stage, fin_stage, desc_projet, type_stage, observation_stage, num_entreprise, num_etudiant, num_prof) 
            VALUES (:debut_stage, :fin_stage, :desc_projet, :type_stage, :observation_stage, :num_entreprise, :num_etudiant, :num_prof)';
    $query = $db->prepare($sql);
    $query->bindValue(':debut_stage', $debut_stage, PDO::PARAM_STR);
    $query->bindValue(':fin_stage', $fin_stage, PDO::PARAM_STR);
    $query->bindValue(':desc_projet', $description, PDO::PARAM_STR);
    $query->bindValue(':type_stage', $type_stage, PDO::PARAM_STR);
    $query->bindValue(':observation_stage', $observation, PDO::PARAM_STR);
    $query->bindValue(':num_entreprise', $num_entreprise['num_entreprise'], PDO::PARAM_STR);
    $query->bindValue(':num_etudiant', $num_stagiare['num_etudiant'], PDO::PARAM_STR);
    $query->bindValue(':num_prof', $num_prof['num_prof'], PDO::PARAM_STR);
    $query->execute();
    $_SESSION['message'] = 'Stage ajouté';
    header('Location: index.php');
}

/**
 * Add a student to the database using the information stored with the get method.
 * @param PDO $db The database connection object.
 * @return void
 */
function addEtudiant($db)
{
    $nom = strip_tags($_POST['nom']);
    $prenom = strip_tags($_POST['prenom']);
    $nom_utilisateur = strip_tags($_POST['utilisateur']);
    $mdp = strip_tags($_POST['mdp']);
    if (isset($_POST['date']) && !empty($_POST['date'])) {
        $date_diplome = strip_tags($_POST['date']);
    } else {
        $date_diplome = null;
    }
    $classe = strip_tags($_POST['classe']);

    $sql = 'INSERT INTO `etudiant` (nom_etudiant, prenom_etudiant, annee_obtention, login, mdp, num_classe) 
            VALUES (:nom, :prenom, :diplome, :login, :mdp, :classe)';
    $query = $db->prepare($sql);

    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':login', $nom_utilisateur, PDO::PARAM_STR);
    $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $query->bindValue(':classe', $classe, PDO::PARAM_STR);
    $query->bindValue(':diplome', $date_diplome, $date_diplome === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

    $query->execute();
    $_SESSION['message'] = 'Etudiant ajouté';
    header('Location: index.php?name=stagiaire');
}

/**
 * Update the student whose id is stored in $_GET['id'], using the information stored with the get method.
 * @param PDO $db The database connection object.
 * @return void
 */
function modifEtudiant($db)
{
    $id = strip_tags($_GET['id']);
    $nom = strip_tags($_POST['nom']);
    $prenom = strip_tags($_POST['prenom']);
    $nom_utilisateur = strip_tags($_POST['utilisateur']);
    $mdp = strip_tags($_POST['mdp']);
    $classe = strip_tags($_POST['classe']);

    $sql = 'UPDATE `etudiant` 
            SET nom_etudiant = :nom, 
                prenom_etudiant = :prenom,
                login = :login, 
                mdp = :mdp, 
                num_classe = :classe 
            WHERE num_etudiant = :id';
    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':login', $nom_utilisateur, PDO::PARAM_STR);
    $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $query->bindValue(':classe', $classe, PDO::PARAM_STR);

    $query->execute();
    $_SESSION['message'] = 'Etudiant modifié';
    header('Location: index.php?name=stagiaire');
}

/**
 * Add an entreprise to the database using the information stored with the get method.
 * @param PDO $db The database connection object.
 * @return void
 */
function addEntreprise($db)
{
    $entreprise = strip_tags($_POST['entreprise']);
    $rue = strip_tags($_POST['rue']);
    $code_postal = strip_tags($_POST['code_postal']);
    $ville = strip_tags($_POST['ville']);
    $telephone = strip_tags($_POST['telephone']);
    $mail = strip_tags($_POST['mail']);
    $niveau = strip_tags($_POST['niveau']);
    if (isset($_POST['nom_contact'])) {
        $nom_contact = strip_tags($_POST['nom_contact']);
    } else {
        $nom_contact = null;
    }
    if (isset($_POST['nom_responsable'])) {
        $nom_responsable = strip_tags($_POST['nom_responsable']);
    } else {
        $nom_responsable = null;
    }
    if (isset($_POST['fixe'])) {
        $fixe = strip_tags($_POST['fixe']);
    } else {
        $fixe = null;
    }
    if (isset($_POST['observation'])) {
        $observation = strip_tags($_POST['observation']);
    } else {
        $observation = null;
    }
    if (isset($_POST['site'])) {
        $site = strip_tags($_POST['site']);
    } else {
        $site = null;
    }

    $sql = 'INSERT INTO `entreprise` (raison_sociale, 
                                        nom_contact, 
                                        nom_resp, 
                                        rue_entreprise, 
                                        cp_entreprise, 
                                        ville_entreprise, 
                                        tel_entreprise, 
                                        fax_entreprise, 
                                        email, 
                                        observation, 
                                        site_entreprise, 
                                        niveau) 
            VALUES (:entreprise, 
                    :nom_contact, 
                    :nom_responsable, 
                    :rue, 
                    :code_postal, 
                    :ville, 
                    :telephone, 
                    :fixe, 
                    :mail, 
                    :observation, 
                    :site, 
                    :niveau)';
    $query = $db->prepare($sql);

    $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
    $query->bindValue(':nom_contact', $nom_contact, PDO::PARAM_STR);
    $query->bindValue(':nom_responsable', $nom_responsable, PDO::PARAM_STR);
    $query->bindValue(':rue', $rue, PDO::PARAM_STR);
    $query->bindValue(':code_postal', $code_postal, PDO::PARAM_STR);
    $query->bindValue(':ville', $ville, PDO::PARAM_STR);
    $query->bindValue(':telephone', $telephone, PDO::PARAM_STR);
    $query->bindValue(':fixe', $fixe, PDO::PARAM_STR);
    $query->bindValue(':mail', $mail, PDO::PARAM_STR);
    $query->bindValue(':observation', $observation, PDO::PARAM_STR);
    $query->bindValue(':site', $site, PDO::PARAM_STR);
    $query->bindValue(':niveau', $niveau, PDO::PARAM_STR);
    $query->execute();

    if (isset($_POST['specialite'])) {
        $specialite = strip_tags($_POST['specialite']);
        $sql = 'SELECT num_entreprise FROM `entreprise` where raison_sociale = :entreprise
                ORDER BY num_entreprise DESC LIMIT 1';
        $query = $db->prepare($sql);
        $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
        $query->execute();
        $id = $query->fetch();

        $sql = 'SELECT * from `specialite` where libelle = :spec LIMIT 1';
        $query = $db->prepare($sql);
        $query->bindValue(':spec', $specialite, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch();

        if (!empty($result)) {
            $sql = 'INSERT INTO `spec_entreprise` (num_entreprise, num_spec) 
                                VALUES (:num_entreprise, :num_spec)';
            $query = $db->prepare($sql);
            $query->bindValue(':num_entreprise', $id['num_entreprise'], PDO::PARAM_STR);
            $query->bindValue(':num_spec', $result['num_spec'], PDO::PARAM_STR);
            $query->execute();
        } else {
            $sql = 'INSERT INTO `specialite` (libelle) 
                VALUES (:spec)';
            $query = $db->prepare($sql);
            $query->bindValue(':spec', $specialite, PDO::PARAM_STR);
            $query->execute();

            $sql = 'SELECT * FROM `specialite` where libelle = :spec LIMIT 1';
            $query = $db->prepare($sql);
            $query->bindValue(':spec', $specialite, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch();

            $sql = 'INSERT INTO `spec_entreprise` (num_entreprise, num_spec) 
                VALUES (:num_entreprise, :num_spec)';
            $query = $db->prepare($sql);
            $query->bindValue(':num_entreprise', $id['num_entreprise'], PDO::PARAM_STR);
            $query->bindValue(':num_spec', $result['num_spec'], PDO::PARAM_STR);
            $query->execute();
        }
    }

    $_SESSION['message'] = 'Entreprise ajoutée';
    header('Location: index.php?name=entreprise');
}

/**
 * Test if the login and password stored in $_POST['login'] and $_POST['mdp'] correspond to a student of the database. Updates the session values if th econnexion is successful.
 * @param PDO $db The database connection object.
 * @return bool True if the login and password are correct, false otherwise.
 */
function connexionEtudiant($db)
{
    $login = strip_tags($_POST['login']);
    $mdp = strip_tags($_POST['mdp']);
    $sql = 'SELECT * FROM `etudiant` where login = :login and mdp = :mdp';
    $query = $db->prepare($sql);
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    if (!empty($result)) {
        $_SESSION['connected'] = true;
        $_SESSION['id'] = $result['num_etudiant'];
        $_SESSION['nom'] = $result['nom_etudiant'];
        $_SESSION['prenom'] = $result['prenom_etudiant'];
        $_SESSION['role'] = 'etudiant';
        header('Location: index.php');
        return true;
    } else {
        header('Location: index.php');
        return false;
    }
}

/**
 * Test if the login and password stored in $_POST['login'] and $_POST['mdp'] correspond to a teacher of the database. Updates the session values if the connexion is successful.
 * @param PDO $db The database connection object.
 * @return bool True if the login and password are correct, false otherwise.
 */
function connexionProfesseur($db)
{
    $login = strip_tags($_POST['login']);
    $mdp = strip_tags($_POST['mdp']);
    $sql = 'SELECT * FROM `professeur` where login = :login and mdp = :mdp';
    $query = $db->prepare($sql);
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    if (!empty($result)) {
        $_SESSION['connected'] = true;
        $_SESSION['id'] = $result['num_prof'];
        $_SESSION['nom'] = $result['nom_prof'];
        $_SESSION['prenom'] = $result['prenom_prof'];
        $_SESSION['role'] = 'professeur';
        header('Location: index.php');
        return true;
    } else {
        header('Location: index.php');
        return false;
    }
}

/**
 * Retrieves the information of the students whose names, companies, and teachers correspond to the information stored using the post method.
 * @param PDO $db The database connection object.
 * @return array An array of the students' information.
 */
function get_etudiants_recherche($db)
{
    $nom = strip_tags($_POST['nom']);
    $prenom = strip_tags($_POST['prenom']);
    $entreprise = strip_tags($_POST['entreprise']);
    $professeur = strip_tags($_POST['professeur']);
    $sql = 'SELECT DISTINCT
                etudiant.nom_etudiant, 
                etudiant.prenom_etudiant, 
                GROUP_CONCAT(DISTINCT entreprise.raison_sociale SEPARATOR \', \') AS raison_sociale,
                GROUP_CONCAT(DISTINCT CONCAT(professeur.nom_prof, \' \', professeur.prenom_prof) SEPARATOR \', \') AS nom_prof,
                etudiant.num_etudiant
            FROM 
                etudiant 
            LEFT JOIN 
                stage ON etudiant.num_etudiant = stage.num_etudiant
            LEFT JOIN 
                professeur ON stage.num_prof = professeur.num_prof
            LEFT JOIN 
                entreprise ON stage.num_entreprise = entreprise.num_entreprise
            WHERE 
                etudiant.nom_etudiant LIKE :nom
                AND etudiant.prenom_etudiant LIKE :prenom
                AND (entreprise.raison_sociale LIKE :entreprise OR entreprise.raison_sociale IS NULL)
                AND (professeur.nom_prof LIKE :professeur OR professeur.nom_prof IS NULL)
            GROUP BY 
                etudiant.num_etudiant, etudiant.nom_etudiant, etudiant.prenom_etudiant
            ORDER BY 
                etudiant.nom_etudiant;';
    $query = $db->prepare($sql);
    $query->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
    $query->bindValue(':prenom', '%' . $prenom . '%', PDO::PARAM_STR);
    $query->bindValue(':entreprise', '%' . $entreprise . '%', PDO::PARAM_STR);
    $query->bindValue(':professeur', '%' . $professeur . '%', PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
