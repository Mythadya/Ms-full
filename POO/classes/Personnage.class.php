<?php

class Personnage {
    private $nom;
    private $prenom;
    private $age;
    private $sexe;

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }

    public function setSexe($sexe) {
        $this->sexe = $sexe;
    }

    public function getSexe() {
        return $this->sexe;
    }

    public function __toString() {
        return "Nom : ". $this->nom. ", Prénom : ". $this->prenom. ", Âge : ". $this->age. ", Sexe : ". $this->sexe;
    }
}

?>


$employes = array(

new Employe('DUPONT', 'Pierre', '2010-01-01', 'Commercial', 40000, 'Commercial'),

new Employe('DURAND', 'Marie', '2015-06-01', 'Comptabilité', 35000, 'Comptabilité'),

new Employe('LEFEBVRE', 'Jean', '2012-03-01', 'Direction', 60000, 'Direction'),

new Employe('MARTIN', 'Sophie', '2018-09-01', 'Ressources Humaines', 45000, 'Ressources Humaines'),

new Employe('PETIT', 'François', '2016-02-01', 'Informatique', 50000, 'Informatique')

);


foreach ($employes as $employe) {

echo "Prime de $employe->nom $employe->prenom : " . $employe->getPrime() . " €<br>";

$employe->envoyerOrdreDeTransfert();

}