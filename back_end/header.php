<?php
function make_url($dirname, $apifilecible)//fonction qui crée un URL vers l'api avec les variables SERVER
{

    $actual_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $taburl = explode($dirname, $actual_url);
    $url = $taburl[0] . $dirname . "/" . $apifilecible;
    return $url;
}
function get_data_byCurl($dirname, $apifilecible,$method, $data = NULL)//LA FONCTION MAGIQUE CURL généralisée pour toute les méthodes qui ressort un array décodé prêt pour le PHP
{
    $url = make_url($dirname, $apifilecible);//appel de la fonction URL 
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);//param de l'url
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if($method == "POST"){//si la méthode est un POST(param spécial)
        curl_setopt($curl, CURLOPT_POST, 1);
    }else{//pour toute les autres méthodes
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    } 
    if ($data != NULL) {//si il y a des datas à envoyer
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    $result = curl_exec($curl);//envoi des données et récupération de la réponse de l'API
    curl_close($curl);
    $result = json_decode($result, true);//transformation en array PHP
    return $result;
}

function validate_form()//fonction permettant de comparer les valeurs d'inputs à un regex uncicode,retourne un boléen
{
    if (preg_match("/^[\p{L}-]{2,}$/u", $_POST['nom']) !== 1) {
        return false;
    }
    if (preg_match("/^[\p{L}-]{2,}$/u", $_POST['login']) !== 1) {
        return false;
    }
    return true;
}

function stagiaire_array_toHTML($result)//fonction d'intégration HTML du tableau des stagiaire avec des subtilités
{
    if(isset($_GET["msg"]) && isset($_GET["success"])){//si on revient d'un traitement php avec des données
        if($_GET["success"]==true){//si tout c'est bien passé
        echo "<h3 class='green'>" . $_GET["msg"] . "</h3>";//message + couleur verte
        }else{//si fail
        echo "<h3 class='red'>" . $_GET["msg"] . "</h3>";//message + couleur rouge
        }
    }
        echo "<h3>".$result["message"]."</h3>";//resultat du get all(stagiaires OK/table vide/erreur)    
        echo <<<_END
        <div class="stagiaire" id="arrayHeader">
            <p class="nom">
                NOM
            </p>
            <p class="login">
                LOGIN
            </p>
            <p class="id">
                SUPPRIMER
            </p>
        </div>
    _END;
    if(!empty($result["result"])){//si il y a bien des stagiaires dans la BDD
        foreach ($result["result"] as $row) {//boucle qui crée une ligne pour chaque stagiaire /HREF sur le nom qui renvoie dans l'index avec des valeurs en get pour construire le form update /href sur le supprimer qui envoie à la vue_delete avec l'id en get pour traitement
            echo <<<_END
            <div class="stagiaire">
                <p class="nom">
                <a href='index.php?id_m=$row[id_membre]&method=update&nom=$row[nom_membre]&login=$row[login_membre]'>$row[nom_membre]</a>
                </p>
                <p class="login">
                    $row[login_membre]
                </p>
                <p class="id">
                    <a href='back_end/vue_delete_stagiaire.php?id_m=$row[id_membre]'> supprimer </a>
                </p>
            </div>
        _END;
        }}
}
function stagiaire_form_toHTML($formId,$formTitle,$idValue,$methodValue,$nomValue,$loginValue){//fonction d'intégration HTMl pour le form Update/Insert avec les valeurs récupérées en get/ id et méthode insérée dans le form avec deux inputs cachés
    echo <<<_END
            <form class="form" id="$formId" method="POST" action="back_end/vue_modify_insert_stagiaire.php">
                <h2>$formTitle</h2>
            _END;
    if(isset($_GET["msgform"])){// si il y a des messages d'erreur affichage +red
        echo"<h3 class='red'>".$_GET["msgform"]."</h3>";
    }else{
        echo "<h3></h3>";
    }
    echo <<<_END
                <input hidden type="text" id="id" name="id" value="$idValue">
                <input hidden type="text" id="method" name="method" value="$methodValue">
                <label for="nom">
                    <p>Nom </p>
                    <input type="text" id="nom" name="nom" value="$nomValue">
                </label>
                <label for="login">
                    <p>Login </p>
                    <input type="text" id="login" name="login" value ="$loginValue">
                </label>
                <div id="buttons">
                    <button id="submit" type="submit">Envoyer</button>
                    <button id="reset" type="button"><a href='index.php'>Annuler</a></button>
                </div>
            </form>
            _END;
}
?>