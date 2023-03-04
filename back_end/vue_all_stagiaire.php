<?php
require "header.php";
$result = get_data_byCurl("api_rest_stagiaire", "api/get_all_stagiaire.php","GET");//fonction get data qui renvoie directement la liste des stagiaires en array php
?>