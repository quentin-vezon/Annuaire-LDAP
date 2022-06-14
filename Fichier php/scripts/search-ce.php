 <?php

@require_once '../config.php';
$ldap = new Ldap($serveur);

$searchq		=	strip_tags($_GET['q']);
echo '<ul>';
	if(strlen($searchq)>=1){
	
	$filtre_personne='(&'.$filtre_personne.'(displayname=*'.$searchq.'*))';
$tri='sn';
$attribut=array('uidnumber','cn', 'sn', 'givenname', 'telephonenumber', 'mail', 'ou','igmmstatutfr');

$info=$ldap->recherche($base_personne, $filtre_personne, $attribut, $tri); 
		
	
	
	
	foreach ($info as $row) {
	if($row['uidnumber'][0]!=""){
	?>
		<li><a href="#" onClick="document.forms['form1'].igmmuidmanager.value=<?php echo $row['uidnumber'][0]; ?>; document.getElementById('results').style.display='none';"><?php echo $row['sn'][0].' '.$row['givenname'][0]; ?> <small><?php echo $row['ou'][0].' - '.$row['mail'][0]; ?></small></a></li>
        
	<? } }
	
	
	} echo '</ul>';
	?>
