<?php
require_once 'config.php';


$ldap = new Ldap($serveur);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Document sans titre</title>
<link href="ldap.css" rel="stylesheet" type="text/css" />
</head>

<body>

  
  <?
foreach($labo as $nom_labo){
$filtre_groupe='(&(objectclass=*)(description='.$nom_labo.'))';
$tri='gidnumber';
$groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut, $tri);

//echo $nom_labo.'<br />';

foreach($groupe as $key=>$person){
    //echo $person['gidnumber'][0].'-'.$person['cn'][0].'<br />';
	$nom_equipe[$person['gidnumber'][0]]=$person['cn'][0];
$filtre_personne='(gidnumber='.$person['gidnumber'][0].')';
$tri='sn';
$attribut=array('uidnumber','cn', 'sn', 'givenname', 'telephonenumber', 'mail', 'o','igmmstatutfr', 'gidnumber', 'departmentnumber','shadowexpire');

$info=$ldap->recherche($base_personne, $filtre_personne, $attribut, $tri);

foreach($info as $key=>$personne){
echo $personne['cn'][0].'-'.$personne['gidnumber'][0].'-'.$personne['departmentnumber'][0].'->'.$person['gidnumber'][0].'-'.$person['cn'][0].'<br>';
/*
$ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
$ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);
$entry['departmentnumber']=$person['cn'][0];

ldap_modify ($ldapconn, "cn=".$personne['cn'][0].",".$base_personne, $entry);
*/
}	
}
}

/*
//Connexion au serveur LDAP
$ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
$ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);


ldap_modify ($ldapconn, "cn=".$_POST['cn'].",".$base_personne, $entry);
*/
  ?>
</body>
</html>
