<?php


//TODO: 1: faire un search des cn de leur shadowExport
//		2: faire un get_entries des shadowExport
//		(3: faire un sort des shadowExport)
//		4: changer le filtre pour trouver les shadowExport < value
//      5: value = valeur entrer par la barre de recherche


@require_once 'config.php';
$ldap = new Ldap($serveur);

$searchq		=	strip_tags($_GET['q']); //récupère l'information
echo '<ul>';
	if(strlen($searchq)>=1){ //si plus de 0 caractère: lance la recherche
//TODO Créer les plusieurs filtres de recherche 	
//création du filtre de recherche
	
	//$filtre_personne='(&'.$filtre_personne.'(!(shadowexpire=1)=*'.$searchq.'*))'; //filtre bureau

	//Affecte la valeur du search au shadowexpire: donc recherche forcément égale (besoin de = pour affecte)
 
	$filtre_personne= "(shadowexpire=1)"; // =1 compte expiré, = 24472 titu
	
	
$tri='sn'; //variable de trie: par nom de famille
$attribut=array('uidnumber','cn', 'sn', 'givenname', 'telephonenumber', 'mail', 'ou','igmmstatutfr', 'shadowexpire'); 

$info=$ldap->recherche($base_personne, $filtre_personne, $attribut, $tri); //faire la recherche selon le filtre et par ordre de trie
		
	
	
	//TODO enlever le row après la recherche

	//Affichage par colone  
	foreach ($info as $row) {
	if($row['uidnumber'][0]!=""){ //Affichage par user id -> nom, prenom + les autres attributs en dessous en minuscule
	?>
		<li><a href="detail.php?uid=<?=$row['uidnumber'][0]?>"><?php echo $row['sn'][0].' '.$row['givenname'][0]; ?> <small><?php echo $row['ou'][0].' - '.$row['mail'][0]; ?></small></a></li>  
	<? } }
	
	
	} echo '</ul>';
	
?>