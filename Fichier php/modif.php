<?php
include 'config.php';
$ldap = new Ldap($serveur);

if(isset($_POST)) {
foreach($_POST as $key=>$val) {
if(!($key=="button" or $key=="datefin" or $key=="datedebut"))
{
if($val=='')$entry[$key][0]='NULL';
else $entry[$key][0]=$val;


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




if($entry['igmmtitlefr']=='')$entry['igmmtitlefr']=8;
$attribut=array('cn', 'igmmnomgroupefr', 'gidnumber');
$filtre_groupe='(&(objectclass=*)(gidnumber='.$entry['gidnumber'][0].'))';
$groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut, $tri);
$entry['departmentnumber']=$groupe[0]['cn'][0];



$entry['igmmstatutfr']=$statut['fr'][$_POST['igmmstatutfr']];
$entry['igmmstatuten']=$statut['en'][$_POST['igmmstatutfr']];


$entry['igmmtitlefr']=$title['fr'][$_POST['igmmtitlefr']];
$entry['igmmtitleen']=$title['en'][$_POST['igmmtitlefr']];



if(!$_POST['igmmaffichageannuaire'])$entry['igmmaffichageannuaire'][0]='FALSE';
if($_POST['telephonenumber']=="")$entry['telephonenumber']="NULL";


//Connexion au serveur LDAP
$ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
$ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);


ldap_modify ($ldapconn, "cn=".$_POST['cn'].",".$base_personne, $entry);
header("Location:detail.php?uid=".$_POST['uidnumber']);
 

}
?>
