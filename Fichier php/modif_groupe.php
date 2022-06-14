<?php
require_once 'config.php';


if($_POST) {
$entry['igmmnomgroupefr']= $_POST['igmmnomgroupefr'];
$entry['igmmnomgroupeen']=$_POST['igmmnomgroupeen'];
$entry['description']=$_POST['description'];
$entry['igmmuidmanager']=$_POST['igmmuidmanager'];



//Connexion au serveur LDAP
$ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
$ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);
ldap_modify ($ldapconn, "cn=".$_POST['cn'].",".$base_groupe, $entry);
header("Location:detail_groupe.php?gid=".$_POST['gidnumber']);
 
}
?>
