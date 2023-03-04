<?php
header("Access-Control-Allow-Methods: DELETE");// header pour la méthode
require "header.php";

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {//si c'est bien un delete
    $id = json_decode(file_get_contents("php://input"));//on récupère les données envoyées par le CURL de la vue back_end/vue_delete.php
    $stagiaire = new Stagiaire;
    $stagiaire = $stagiaire->delete_stagiaire($id);//appel de la fonction delete( cf: module/class/stagiaire.class.php retour boleen)
    $data = [];
    if ($stagiaire) {//si le delete a bien été fait
        $statut = http_response_code(200);
        return get_json($data, true, "Le contact a bien été éffacé");//construction du tableau json(cf: api/header.php)
    } else {//si la connection a eu lieu mais que le delete n'a pas été fait
        $statut = http_response_code(503);
        return get_json($data, false, "Le contact n'a pas été éffacé");
    }
} else {//si la méthode n'est pas bonne
    $statut = http_response_code(405);
    return get_json($data, false,"La méthode n'est pas bonne");
}
?>