<?php //fichier header qui comprends les require et header dont on a besoin dans toute l'api et une fonction qu'on utilisera partout qui retourne le JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require '../module/class/database.class.php';//appel des deux classes(on en a besoin partout dans l'api)
require '../module/class/stagiaire.class.php';

function get_json($array,$sucess,$msg,$dataArray=null){//fonction de construction du retour json de l'api(nom du tableau,boleen de success,string de message,tableau de data si besoin)
    $array["success"] = $sucess;
    $array["message"] = $msg;
    if(!empty($dataArray)){//ajout d'un count au besoin
        $array["nb"] = count($dataArray);
    }else{
        $array["nb"] = 0;
    }
    $array["result"] = $dataArray;
    echo json_encode($array);
}
?>