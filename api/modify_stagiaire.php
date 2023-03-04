<?php
header("Access-Control-Allow-Methods: PUT");// header pour la méthode
require "header.php";

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {//si c'est bien un put
    $data = json_decode(file_get_contents("php://input"),true);//on récupère les données envoyées par le CURL de la vue back_end/vue_modify_insert_stagiaire.php
    $id = $data["id"];
    $nom = $data["nom"];
    $login = $data["login"];
    $stagiaire = new Stagiaire;
    $stagiaire = $stagiaire->modify_stagiaire($id,$nom, $login);//appel de la fonction modify qui renvoie un boleen (cf : module/class/stagiaire.class.php)
    $data = [];
    if ($stagiaire) {//si le stagiaire a bien été modifié
        http_response_code(200);
        return get_json($data, true, "Le contact a bien été modifié");//construction du tableau json(cf: api/header.php)
    } else {//si le stagiaire n'a pas été modifié
        return get_json($data, false, "Le contact n'a pas été modifié");
    }
} else {
    http_response_code(405);//si la méthode n'est pas bonne
    return get_json($data, false, "La méthode n'est pas bonne");
}
?>