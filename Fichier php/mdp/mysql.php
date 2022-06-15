<?php


try
{
	$bdd = new PDO('XXX');
	$a="test123";
	$b="test123";
	$c="test123";
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// On ajoute une entr�e dans la table user
$bdd->exec("INSERT INTO user(login,password,tag) VALUES('$a','$b','$c')");

echo 'Le jeu a bien �t� ajout� !';
?>
