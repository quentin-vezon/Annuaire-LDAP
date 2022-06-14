<?php

$Server="alkaid-clone.sic.montp.cnrs.fr";
//$Server="10.4.2.139";
$lang='fr';
$DateSeconde=strtotime ("now");
$DateUnix=$DateSeconde/86400;
$Connexion=ldap_connect($Server);
ldap_set_option($Connexion, LDAP_OPT_PROTOCOL_VERSION, 3);
$uidnumber= $_REQUEST['uidnumber'];
if ($Connexion)
 {
	$Identification=ldap_bind($Connexion);	
	
	if ($Identification)
	 {
		$Filtre="uidnumber=$uidnumber";
		//$ldapSortAttributes = array('sn', 'givenname');
		$justthese = array( "jpegphoto" );
		$Search=ldap_search($Connexion,"ou=people,dc=sic,dc=montp,dc=cnrs,dc=fr",$Filtre,$justthese);
		$filtre_groupe='(&(objectclass=*)(description=IGMM))';
$l_groupe=ldap_search($Connexion, "ou=groupe,dc=sic,dc=montp,dc=cnrs,dc=fr", $filtre_groupe,array("*"));
$groupe=ldap_get_entries($Connexion, $l_groupe);
foreach($groupe as $key=>$personne){

   $nom_groupe[$personne['cn'][0]]=$personne['igmmnomgroupe'.$lang][0];
   $nom_resp_groupe[$personne['cn'][0]]=$personne['igmmuidmanager'.$lang][0];
}
		
		if ($Search) {
		

		$Info= ldap_get_entries($Connexion, $Search);
		array_multisort($Connexion,$Search,"sn");
//			$jpeg_data = ldap_get_values_len( $Connexion, $Search, "jpegphoto");
		$jpeg_data = $Info[0]['jpegphoto'][0];
			   }//fin de if($Search)
	 }//fin if ($identification)
	else
	 {
		$affichage_php = "<h4>Impossible de se connecter au serveur ldap en anonyme</h4>";
	 }
 }
else
 {
	$affichage_php = "<h4>Impossible de se connecter au serveur ldap</h4>";
 }//fin if connexion

header("Content-type: image/jpeg");
echo $jpeg_data;

?>