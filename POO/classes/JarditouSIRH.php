<?php

class Employe {
    private $nom;
    private $prenom;
    private $dateEmbauche;
    private $fonction;
    private $salaire;
    private $service;
    private $magasin;
    private $enfants;

    public function __construct($nom, $prenom, $dateEmbauche, $fonction, $salaire, $service, $magasin, $enfants) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateEmbauche = $dateEmbauche;
        $this->fonction = $fonction;
        $this->salaire = $salaire;
        $this->service = $service;
        $this->magasin = $magasin;
        $this->enfants = $enfants;
    }

    public function getAnciennete() {
        $dateEmbauche = strtotime($this->dateEmbauche);
        $today = strtotime(date('Y-m-d'));
        $diff = $today - $dateEmbauche;
        $years = floor($diff / (60 * 60 * 24 * 365));
        return $years;
    }

    public function getPrime() {
        $anciennete = $this->getAnciennete();
        $prime = ($this->salaire * 0.05) + ($this->salaire * 0.02 * $anciennete);
        return $prime;
    }

    public function transfertPrime() {
        $today = date('Y-m-d');
        if ($today == '2023-11-30') {
            $prime = $this->getPrime();
            echo "Ordre de transfert à la banque : " . $prime . " €<br>";
        }
    }

    public function getMagasin() {
        return $this->magasin;
    }

    public function peutDisposerChequesVacances() {
        $anciennete = $this->getAnciennete();
        if ($anciennete >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getChequesNoel() {
        $chequesNoel = array();
        foreach ($this->enfants as $enfant) {
            $age = $enfant['age'];
            switch (true) {
                case ($age >= 0 && $age <= 10):
                    $montant = 20;
                    break;
                case ($age >= 11 && $age <= 15):
                    $montant = 30;
                    break;
                case ($age >= 16 && $age <= 18):
                    $montant = 50;
                    break;
                default:
                    $montant = 0;
            }
            if ($montant > 0) {
                $chequesNoel[] = array('age' => $age, 'montant' => $montant);
            }
        }
        return $chequesNoel;
    }
}

class Magasin {
    private $nom;
    private $adresse;
    private $codePostal;
    private $ville;
    private $modeRestauration;

    public function __construct($nom, $adresse, $codePostal, $ville, $modeRestauration) {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
        $this->modeRestauration = $modeRestauration;
    }

    public function getModeRestauration() {
        return $this->modeRestauration;
    }
}

$magasin1 = new Magasin('Magasin 1', 'Adresse 1', '12345', 'Ville 1', 'Restaurant d\'entreprise');
$magasin2 = new Magasin('Magasin 2', 'Adresse 2', '67890', 'Ville 2', 'Tickets restaurants');

$employe1 = new Employe('Dupont', 'Jean', '2021-01-01', 'Vendeur', 30, 'Commercial', $magasin1, array(array('nom' => 'Enfant 1', 'age' => 8)));
$employe2 = new Employe('Durand', 'Marie', '2019-06-15', 'Caissière', 25, 'Commercial', $magasin2, array(array('nom' => 'Enfant 2', 'age' => 12), array('nom' => 'Enfant 3', 'age' => 17)));

// Afficher le montant des primes dechaque employé
echo $employe1->getPrime() . " €<br>";
echo $employe2->getPrime() . " €<br>";

// Afficher chaque mode de restauration de chaque employé selon le magasin dans lequel il est affecté
echo $employe1->getMagasin()->getModeRestauration() . "<br>";
echo $employe2->getMagasin()->getModeRestauration() . "<br>";

// Afficher si l'employé a le droit d'avoir des chèques Noël (Oui/Non)
if ($employe1->peutDisposerChequesVacances()) {
    echo "Oui<br>";
} else {
    echo "Non<br>";
}

// Afficher combien de chèques de chaque montant sera distribué à l'employé
$chequesNoel = $employe2->getChequesNoel();
foreach ($chequesNoel as $chequeNoel) {
    echo $chequeNoel['age'] . " ans : " . $chequeNoel['montant'] . " €<br>";
}

// Effectuer le transfert de prime pour chaque employé
$employe1->transfertPrime();
$employe2->transfertPrime();

?>