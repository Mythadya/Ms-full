<?php

// Classe représentant un employé
class Employe {
    private $nom;
    private $prenom;
    private $dateEmbauche;
    private $fonction;
    private $salaire;
    private $service;
    private $magasin;
    private $enfants;

    // Constructeur pour initialiser un objet Employe
    public function __construct($nom, $prenom, $dateEmbauche, $fonction, $salaire, $service, $magasin, $enfants = []) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateEmbauche = new DateTime($dateEmbauche);
        $this->fonction = $fonction;
        $this->salaire = $salaire;
        $this->service = $service;
        $this->magasin = $magasin;
        $this->enfants = $enfants;
    }

    // Méthode pour calculer l'ancienneté de l'employé en années
    public function getAnciennete() {
        $today = new DateTime();
        $diff = $today->diff($this->dateEmbauche);
        return $diff->y;
    }

    // Méthode pour calculer la prime annuelle de l'employé
    public function calculerPrime() {
        $anciennete = $this->getAnciennete();
        $primeBase = 0.05 * $this->salaire; // 5% du salaire brut annuel
        $primeAnciennete = 0.02 * $this->salaire * $anciennete; // 2% par année d'ancienneté
        return $primeBase + $primeAnciennete;
    }

    // Méthode pour vérifier et verser la prime si la date est le 30 novembre
    public function verserPrime() {
        $today = new DateTime();
        if ($today->format('m-d') == '11-30') {
            $montant = $this->calculerPrime();
            return "Ordre de transfert de {$montant} K euros envoyé à la banque pour {$this->prenom} {$this->nom}.";
        } else {
            return "La prime ne peut être versée qu'à la date du 30/11.";
        }
    }

    // Méthode pour obtenir le mode de restauration du magasin de l'employé
    public function getModeRestauration() {
        return $this->magasin->getModeRestauration();
    }

    // Méthode pour vérifier si l'employé peut avoir des chèques-vacances
    public function peutAvoirChequesVacances() {
        return $this->getAnciennete() >= 1 ? "Oui" : "Non";
    }

    // Méthode pour calculer les chèques Noël en fonction des enfants de l'employé
    public function calculerChequesNoel() {
        $cheques = [
            '20€' => 0,
            '30€' => 0,
            '50€' => 0
        ];
        foreach ($this->enfants as $enfant) {
            $age = $this->getAgeEnfant($enfant['dateNaissance']);
            if ($age >= 0 && $age <= 10) {
                $cheques['20€']++;
            } elseif ($age >= 11 && $age <= 15) {
                $cheques['30€']++;
            } elseif ($age >= 16 && $age <= 18) {
                $cheques['50€']++;
            }
        }
        return $cheques;
    }

    // Méthode pour obtenir l'âge d'un enfant
    public function getAgeEnfant($dateNaissance) {
        $dateNaissance = new DateTime($dateNaissance);
        $today = new DateTime();
        $diff = $today->diff($dateNaissance);
        return $diff->y;
    }

    // Méthode pour afficher les chèques Noël en fonction des enfants
    public function afficherChequesNoel() {
        $cheques = $this->calculerChequesNoel();
        $totalCheques = array_sum($cheques);
        if ($totalCheques > 0) {
            $result = "Oui<br>";
            foreach ($cheques as $montant => $nombre) {
                if ($nombre > 0) {
                    $result .= "- {$nombre} chèque(s) de {$montant}<br>";
                }
            }
            return $result;
        } else {
            return "Non";
        }
    }

    // Méthode pour obtenir le nombre d'enfants de l'employé
    public function getNombreEnfants() {
        return count($this->enfants);
    }

    // Méthode pour obtenir le nom de l'employé
    public function getNom() {
        return $this->nom;
    }

    // Méthode pour obtenir le prénom de l'employé
    public function getPrenom() {
        return $this->prenom;
    }

    // Méthode pour obtenir le nom du magasin où travaille l'employé
    public function getMagasin() {
        return $this->magasin->getNom();
    }
}

// Classe représentant un magasin
class Magasin {
    private $nom;
    private $adresse;
    private $codePostal;
    private $ville;
    private $modeRestauration;

    // Constructeur pour initialiser un objet Magasin
    public function __construct($nom, $adresse, $codePostal, $ville, $modeRestauration) {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
        $this->modeRestauration = $modeRestauration;
    }

    // Méthode pour obtenir le nom du magasin
    public function getNom() {
        return $this->nom;
    }

    // Méthode pour obtenir le mode de restauration du magasin
    public function getModeRestauration() {
        return $this->modeRestauration;
    }
}

// Création des objets Magasin
$magasin1 = new Magasin("Magasin 1", "1 Rue de la Paix", "75001", "Paris", "Restaurant d'entreprise");
$magasin2 = new Magasin("Magasin 2", "2 Avenue de la République", "69001", "Lyon", "Tickets restaurants");

// Création des objets Employe
$employes = [
    new Employe("Dupont", "Jean", "2015-06-15", "Comptable", 45, "Comptabilité", $magasin1),
    new Employe("Durand", "Marie", "2018-03-20", "Commerciale", 50, "Commercial", $magasin2, [['dateNaissance' => '2010-07-12']]),
    new Employe("Martin", "Paul", "2012-11-30", "Manager", 60, "RH", $magasin1, [['dateNaissance' => '2005-05-23'], ['dateNaissance' => '2008-09-14']]),
    new Employe("Bernard", "Lucie", "2019-01-05", "Technicienne", 40, "IT", $magasin2),
    new Employe("Robert", "David", "2017-12-10", "Responsable", 70, "Logistique", $magasin1, [['dateNaissance' => '2002-12-01'], ['dateNaissance' => '2009-03-15']])
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Informations des Employés</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Informations des Employés</h2>

<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Magasin</th>
        <th>Ancienneté</th>
        <th>Prime</th>
        <th>Mode de Restauration</th>
        <th>Chèques Vacances</th>
        <th>Chèques Noël</th>
        <th>Nombre d'enfants</th>
    </tr>
    <?php foreach ($employes as $employe) { ?>
        <tr>
            <td><?php echo $employe->getNom(); ?></td>
            <td><?php echo $employe->getPrenom(); ?></td>
            <td><?php echo $employe->getMagasin(); ?></td>
            <td><?php echo $employe->getAnciennete(); ?> ans</td>
            <td><?php echo $employe->calculerPrime(); ?> K euros</td> 
            <td><?php echo $employe->getModeRestauration(); ?></td>
            <td><?php echo $employe->peutAvoirChequesVacances(); ?></td>
            <td><?php echo $employe->afficherChequesNoel(); ?></td>
            <td><?php echo $employe->getNombreEnfants(); ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
