<?php
require_once "header.php";
if ($_POST["method"] == "update") {//si c'est un update(récupération de la méthode dans un input hidden)
    if (!empty($_POST["nom"]) && !empty($_POST["login"]) && !empty($_POST["id"])) {//si les inputs sont pas vide
        if (validate_form()) {//si les inputs passent le regex
            $data = [//construction du tableau qu'on va envoyer à l'api en curl
                "id"=>$_POST["id"],
                "nom" => mb_strtoupper($_POST["nom"], 'UTF-8'),
                "login" => mb_convert_case($_POST["login"], MB_CASE_TITLE, 'UTF-8')
            ];
            $data = json_encode($data, true);//encodage du tableau
            $result = get_data_byCurl("api_rest_stagiaire", "api/modify_stagiaire.php", "PUT", $data);//envoi et récupération du résultat de l'api
            header("location:../index.php?msg=" . $result['message'] . "&success=" . $result["success"]);//retour à l'index avec le résultat
        } else {//si les inputs sont pas valides
            header("location:../index.php?msgform=Certains champs ne sont pas conforme!&id_m=$_POST[id]&method=update&nom=$_POST[nom]&login=$_POST[login]");//retour à l'index erreur+ ancienne valeurs des inputs
        }
    } else {//si les inputs sont vide
        header("location:../index.php?msgform=Certains champs sont vides!&id_m=$_POST[id]&method=update&nom=$_POST[nom]&login=$_POST[login]");//retour à l'index erreur+ ancienne valeurs des inputs
    }




} else {//si c'est un INSERT
    if (!empty($_POST["nom"]) && !empty($_POST["login"])) {//si inputs pas vide
        if (validate_form()) { //si ils passent le regex
            $data = [//construction du tableau
                "nom" => mb_strtoupper($_POST["nom"], 'UTF-8'),
                "login" => mb_convert_case($_POST["login"], MB_CASE_TITLE, 'UTF-8')
            ];
            $data = json_encode($data, true);//encodage
            $result = get_data_byCurl("api_rest_stagiaire", "api/insert_stagiaire.php", "POST", $data);//envoi et récupération du résultat de l'api

            header("location:../index.php?msg=" . $result['message'] . "&success=" . $result["success"]);//retour à l'index avec le résultat
        } else {//si ils passent pas le regex
            header("location:../index.php?msgform=Certains champs ne sont pas conforme!&method=insert&nom=$_POST[nom]&login=$_POST[login]");//retour à l'index erreur+ ancienne valeurs des inputs
        }

    } else {//si inputs vides
        header("location:../index.php?msgform=Certains champs sont vides!&method=insert&nom=$_POST[nom]&login=$_POST[login]");//retour à l'index erreur+ ancienne valeurs des inputs
    }
}

?>