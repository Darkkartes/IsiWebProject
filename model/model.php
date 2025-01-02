<?php
function returnTrue()
{
    return true;
}

function returnFalse()
{
    return false;
}

function get_entreprises($db){
    $sql = 'SELECT * FROM `entreprise`'; 
    $query = $db->prepare($sql); 
    $query->execute(); 
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_entreprise_par_id($db, $id){
    $id = strip_tags($id);
    $sql = 'SELECT * FROM `entreprise` where num_entreprise = :id'; 
    $query = $db->prepare($sql); 
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute(); 
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_stagiaires($db){
    $sql = 'SELECT * FROM `etudiant`'; 
    $query = $db->prepare($sql); 
    $query->execute(); 
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    log($result);
    echo '<script>console.log("function get_stagiaires"); </script>'; 
    return $result;
}

function get_stagiaire_par_id($db, $id){
    $id = strip_tags($id);
    $sql = 'SELECT * FROM `etudiant` where num_etudiant = :id'; 
    $query = $db->prepare($sql); 
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute(); 
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_stages($db){
    $sql = 'SELECT * FROM `stage`'; 
    $query = $db->prepare($sql); 
    $query->execute(); 
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_stage_par_id($db, $id){
    $id = strip_tags($id);
    $sql = 'SELECT * FROM `stage` where num_stage = :id'; 
    $query = $db->prepare($sql); 
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute(); 
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}