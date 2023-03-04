<?php
header("Access-Control-Allow-Methods: GET");// header pour la méthode
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {//si c'est bien un get
    $stagiaire = new Stagiaire();
    $stagiaire = $stagiaire->get_all_stagiaire();//appel de la fonction get_all qui renvoie un array avec tous les stagiaires (cf : module/class/stagiaire.class.php)
    $stagiaireArray = [];
    if (!empty($stagiaire)) {//si il y a des valeurs dans le tableau = si la table n'est pas vide
        $statut = http_response_code(200);
        $tempArray = [];
        foreach ($stagiaire as $row) {//boucle qui rentre tout les stagiaires dans un array associatif
            $row = [
                "id_membre" => $row["id_membre"],
                "nom_membre" => $row["nom_membre"],
                "login_membre" => $row["login_membre"]
            ];
            $tempArray[] = $row;
        }
        return get_json($stagiaireArray,true, "Il y a ". count($stagiaire)." stagiaire(s)", $tempArray);//construction du tableau json(cf: api/header.php)
    } else {//si la connextion a bien été effectuée mais que la table est vide
        $statut =http_response_code(200);
        return get_json($stagiaireArray, false, "La liste est vide");
    }
} else {//si ce n'est pas la bonne méthode
    $statut =http_response_code(405);
    return get_json($stagiaireArray, false, "La méthode n'est pas autorisée");
}
?>