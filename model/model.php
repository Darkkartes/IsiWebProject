<?php
function returnTrue()
{
    return true;
}

function returnFalse()
{
    return false;
}

function get_entreprises($db)
{
    $sql = 'SELECT 
    entreprise.num_entreprise,
    entreprise.raison_sociale,
    entreprise.rue_entreprise,
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
function get_entreprise_par_id($db, $id)
{
    $id = strip_tags($id);
    $sql = 'SELECT * FROM `entreprise` where num_entreprise = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_specialites_par_entreprise($db, $id)
{
    $id = strip_tags($id);
    $sql = 'SELECT * FROM `spec_entreprise`
            join `specialite` using (num_spec);
            where num_entreprise = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_etudiants($db)
{
    $sql = 'SELECT * FROM `etudiant` order by nom_etudiant';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

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

function get_stagiaires($db)
{
    $sql = 'SELECT nom_etudiant, prenom_etudiant, raison_sociale, nom_prof, prenom_prof, num_etudiant
            FROM `stage` 
            join `etudiant` using (num_etudiant) 
            join `professeur` using (num_prof) 
            join `entreprise` using (num_entreprise);';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_stages($db)
{
    $sql = 'SELECT * FROM `stage`';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

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

function get_professeurs($db)
{
    $sql = 'SELECT * FROM `professeur` order by nom_prof';
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
