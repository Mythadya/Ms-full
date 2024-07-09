<?php

// Inclusion de la classe Personnage
require_once '../classes/Personnage.class.php';

// Création d'une nouvelle instance de la classe Personnage
$p = new Personnage();

// Définition des propriétés du personnage
$p->setNom("Lebowski");
$p->setPrenom("Jeff");
$p->setAge(40);
$p->setSexe("Masculin");

// Affichage des informations du personnage en utilisant la méthode magique __toString()
echo $p->__toString();

?>