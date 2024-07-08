<?php

require_once '../classes/Personnage.class.php';

$p = new Personnage();
$p->setNom("Lebowski");
$p->setPrenom("Jeff");
$p->setAge(40);
$p->setSexe("Masculin");

echo $p->__toString();

?>