<?php

/*** 
* Creating a new user
* @see config.php
* @see mailsUsers.php
***/
include 'config.php';


if(isset($_POST['button'])){
    foreach($_POST as $key=>$val) {
    	if(!($key=="button" or $key=="datefin" or $key=="datedebut" )){
    		if($val=='')
                $entry[$key][0]='NULL';
		    else 
                $entry[$key][0]=$val;
		}
    }



if($entry['shadowexpire'][0]=='00000'){
    $datefin=explode("/",$_POST['datefin']);
    $entry['shadowexpire'][0]=mktime(0, 0, 0, $datefin[1], $datefin[0]+1, $datefin[2]);
    $entry['shadowexpire'][0]=intval($entry['shadowexpire'][0]/86400);
}


$datedebut = explode("/",$_POST['datedebut']);
$entry['igmmDateArrivee'][0] = mktime(0, 0, 0, $datedebut[1], $datedebut[0]+1, $datedebut[2]);
$entry['igmmDateArrivee'][0]=intval($entry['igmmDateArrivee'][0]/86400);


$entry['homedirectory'][0]='/home'.'/'.strtolower($entry['ou'][0]).'/'.$entry['cn'][0];
$entry['igmmmailboxpath'][0]='maildir:/var/mail/'.$entry['cn'][0];
$entry['igmmmailprotocol'][0]='pop3';

// Rajout MR 20131017 pour prise en compte zone SIC
switch(strtolower($entry['ou'][0])) {
    case 'sic':
        $entry['igmmvirtualdomain'][0]=strtolower($entry['ou'][0]).'.montp.cnrs.fr';
        break;
    case 'cemipai':
        $entry['igmmvirtualdomain'][0]=strtolower($entry['ou'][0]).'.cnrs.fr';
        break;
    default:
        $entry['igmmvirtualdomain'][0]=strtolower($entry['ou'][0]).'.cnrs.fr';
        break;
}


$entry['igmmIsAccountActive'][0]='TRUE';
#rajouter par pl 15/02/10
#$entry['sambaPwdLastSet'][0]='-1';
#$entry['sambaPwdMustChange'][0]='-1';

$entry['igmmstatutfr']=$statut['fr'][$_POST['igmmstatutfr']];
$entry['igmmstatuten']=$statut['en'][$_POST['igmmstatutfr']];

$entry['igmmtitlefr']=$title['fr'][$_POST['igmmtitlefr']];
$entry['igmmtitleen']=$title['en'][$_POST['igmmtitlefr']];

$entry['objectclass'][0]='inetOrgPerson';
$entry['objectclass'][1]='top';
$entry['objectclass'][2]='igmmPerson';
$entry['objectclass'][3]='sambaSamAccount';
$entry['objectclass'][4]='posixAccount';
$entry['objectclass'][5]='shadowAccount';

$entry['uid'][0]=$entry['cn'][0];
//$uid=$entry['cn'][0];
$fichier="compteur_".$entry['ou'][0].".txt";

$ldap = new Ldap($serveur);
$entry['uidnumber'][0]=$ldap->gen_code($base_personne, 'uidNumber');


$entry['sambasid'][0]='S-1-5-21-1796178477-275616020-3354355055-'.$entry['uidnumber'][0];


$entry['igmmIsAccountActive']='TRUE';

//Gestion du groupe 
$attribut=array('cn', 'igmmnomgroupefr', 'gidnumber');
$filtre_groupe='(&(objectclass=*)(gidnumber='.$entry['gidnumber'][0].'))';
$groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut, $tri);
$entry['departmentnumber'][0]=$groupe[0]['cn'][0];

// Rajout MR 20131017 pour prise en compte zone SIC
$ou = strtolower($entry['ou'][0]);
switch($ou) {
    case 'sic':
        $entry['igmmmailalias'][0]=$entry['cn'][0].'@'.$ou.'.montp.cnrs.fr';
        $destinataire = $entry['cn'][0].'@'.$ou.'.montp.cnrs.fr';
        break;
    case 'cemipai':
        $entry['igmmmailalias'][0]=$entry['cn'][0].'@'.$ou.'.cnrs.fr';
        $destinataire = $entry['cn'][0].'@'.$ou.'.fr';
        break;
    default:
        $entry['igmmmailalias'][0]=$entry['cn'][0].'@'.$ou.'.cnrs.fr';
        $destinataire = $entry['cn'][0].'@'.$ou.'.cnrs.fr';
        break;
}

$entry['userpassword'][0]='{crypt}plIfkjqv4pISA';
$entry['sambalmpassword'][0]=NTLMHash("12345678");
$entry['sambantpassword'][0]=NTLMHash("12345678");
 
$entry['displayname'][0]=$entry['givenname'][0].' '.$entry['sn'][0];

  
//############################################################### MAILS #########################################################
//ici au paravant : mail Loi Informatiques et Libertés


$ldaprdn  = $admin_user;    
$ldappass = $admin_pass;           

//Connexion au serveur LDAP
$ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);




ldap_add ($ldapconn, "cn=".$_POST['cn'].",".$base_personne, $entry);

unlink($file);

sleep(5);

include("mailsUsers.php");

//array_map('unlink', glob("upload/*.jpg"));

header("Location: detail.php?uid=".$entry['uidnumber'][0]."");

}


?>
