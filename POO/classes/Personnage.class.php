<?php

class Personnage {
    // Propriétés privées de la classe Personnage
    private $nom;
    private $prenom;
    private $age;
    private $sexe;

    // Méthodes pour définir et obtenir le nom
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getNom() {
        return $this->nom;
    }

    // Méthodes pour définir et obtenir le prénom
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    // Méthodes pour définir et obtenir l'âge
    public function setAge($age) {
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }

    // Méthodes pour définir et obtenir le sexe
    public function setSexe($sexe) {
        $this->sexe = $sexe;
    }

    public function getSexe() {
        return $this->sexe;
    }

    // Méthode magique pour convertir l'objet en chaîne de caractères
    public function __toString() {
        return "Nom : " . $this->nom . ", Prénom : " . $this->prenom . ", Âge : " . $this->age . ", Sexe : " . $this->sexe;
    }
}

?>




SELECT c.libelle, COUNT(p.id) AS nb_plats
            FROM categorie c
            JOIN plat p ON c.id = p.id
            WHERE p.actif = 1 -- Seul les plats actifs sont Comptés
            GROUP BY c.id;