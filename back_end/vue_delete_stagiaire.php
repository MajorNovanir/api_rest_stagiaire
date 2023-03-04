<?php
require "header.php";
$id = $_GET["id_m"];//récupération de l'id en get
$result = get_data_byCurl("api_rest_stagiaire", "api/delete_stagiaire.php","DELETE",$id);//fonction Curl + envoi de l'id pour gérer le delete
header("location:../index.php?msg=".$result['message']."&success=".$result["success"])//retour à l'index avec le retour du traitement en get
?>