<?php
header("Access-Control-Allow-Methods: POST");// header pour la méthode
require "header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {//si c'est bien un post
    $data = json_decode(file_get_contents("php://input"),true);//on récupère les données envoyées par le CURL de la vue back_end/vue_modify_insert_stagiaire.php
    $nom = $data["nom"];
    $login = $data["login"];
    $stagiaire = new Stagiaire;
    $stagiaire = $stagiaire->insert_stagaire($nom, $login);//appel de la fonction insert qui renvoie un boleen (cf : module/class/stagiaire.class.php)
    $data = [];
    if ($stagiaire) {//si le stagiaire a bien été inséré
        http_response_code(200);
        return get_json($data, true, "Le contact a bien été inséré");//construction du tableau json(cf: api/header.php)
    } else {//si le stagiaire n'as pas été inséré
        return get_json($data, false, "Le contact n'a pas été inséré");
    }
} else {//si la méthode n'est pas bonne
    http_response_code(405);
    return get_json($data, false, "La méthode n'est pas bonne");
}
?>