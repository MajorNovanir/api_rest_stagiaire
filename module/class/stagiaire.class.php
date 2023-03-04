<?php
class Stagiaire// class stagiaire qui regroupe toute les requêtes qui seront appelées uniquement dans l'api(on va pas trop commenter c'est de la requête de base)
{
    private $id_membre;//contruction des variables de classe
    private $nom_membre;
    private $login_membre;

    public function get_all_stagiaire()//un get all qui retourne un tableau comprenant tous les stagiaires
    {
        $pdo = Database::connect();
        $sql = "SELECT * FROM `membres`";
        $response = $pdo->prepare($sql);
        $response->execute();
        $data = $response->fetchAll();
        Database::disconnect();
        return $data;
    }

    public function insert_stagaire($nom, $login)//insert de stagiaire qui retourne un boleen si réussi ou pas
    {
        $this->nom_membre = htmlspecialchars(strip_tags($nom));
        $this->login_membre = htmlspecialchars(strip_tags($login));
        $pdo = Database::connect();
        $sql = "INSERT INTO membres(nom_membre, login_membre) VALUES (:nom_membre, :login_membre)";
        $response = $pdo->prepare($sql);
        $response->bindParam(':nom_membre', $this->nom_membre);
        $response->bindParam(':login_membre', $this->login_membre);
        if ($response->execute()) {
            return true;
        }
        Database::disconnect();
        return false;
    }
    public function modify_stagiaire($id, $nom, $login)//update de stagiaire qui ressort un boleen si réussi ou pas
    {
        $this->id_membre = htmlspecialchars(strip_tags($id));
        $this->nom_membre = htmlspecialchars(strip_tags($nom));
        $this->login_membre = htmlspecialchars(strip_tags($login));

        $pdo = Database::connect();
        $sql = "UPDATE membres SET nom_membre = :nom_membre , login_membre = :login_membre WHERE id_membre = :id_membre";
        $response = $pdo->prepare($sql);
        $response->bindParam(':nom_membre', $this->nom_membre);
        $response->bindParam(':login_membre', $this->login_membre);
        $response->bindParam(':id_membre', $this->id_membre);
        if ($response->execute()) {
            return true;
        }
        Database::disconnect();
        return false;
    }
    public function delete_stagiaire($id)//delete qui ressort un boleen si reussi ou pas
    {
        $this->id_membre = htmlspecialchars(strip_tags($id));
        $pdo = Database::connect();
        $sql = "DELETE FROM membres WHERE id_membre = :id_membre";
        $response = $pdo->prepare($sql);
        $response->bindParam(':id_membre', $this->id_membre);
        if ($response->execute()) {
            return true;
        }
        Database::disconnect();
        return false;
    }
}
?>