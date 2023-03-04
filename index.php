<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss\style.css">
    <title>les Stagiaires</title>
</head>

<body>

    <div id="blocPage">
        <h1>Les Stagiaires (API REST)</h1>
        <div id="stagiaireArray">
            <?php
            require "./back_end/vue_all_stagiaire.php";//on apelle la vue get_all stagiaire
            stagiaire_array_toHTML($result);//fonction qui retourne principalement une table html de tous les stagiaires et des messages d'erreur (cf: back_end/header.php)
            ?>
        </div>
        <?php
        if (isset($_GET["method"]) && $_GET["method"] == "update") {//si on revient sur l'index depuis un update
            stagiaire_form_toHTML("updateForm", "Modifier un stagiaire", $_GET["id_m"], "update", $_GET["nom"], $_GET["login"]);//fonction qui construit  le form selon la méthode +renvoi des valeurs si besoin
        } else {//si on ne revient pas d'un update
            if (isset($_GET["method"])) {//si on revient depuis une erreur de l'insert
                stagiaire_form_toHTML("insertForm", "Ajouter un stagiaire", "", "insert", $_GET["nom"], $_GET["login"]);
            } else {//si on est sur la page index de base et qu'on revient de rien
                stagiaire_form_toHTML("insertForm", "Ajouter un stagiaire", "", "insert", "", "");
            }
        }
        ?>
    </div>
</body>

</html>