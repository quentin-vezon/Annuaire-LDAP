<?php

//$bdd = new PDO('mysql:host=yoshi.sic.int;dbname=SyncAD', 'aduser', 'p34SRu9eUvSZBtUZ');
//$bdd->exec('INSERT INTO user(login,password,tag) VALUES(\'Battlefield 1942\', \'Patrick\', \'0\')');

try
{
	$bdd = new PDO('mysql:host=yoshi.sic.int;dbname=SyncAD', 'aduser', 'p34SRu9eUvSZBtUZ');
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
