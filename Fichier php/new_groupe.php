<?

include 'config.php';
include 'uidnumber.php';


if($_POST) {
    foreach($_POST as $key=>$val) {
        if(!($key=="button")){
            if($val=='')
                $entry[$key][0]='NULL';
            else 
                $entry[$key][0]=$val;
        }
    }

    $entry['objectclass'][0]='posixGroup';
    $entry['objectclass'][1]='igmmGroupe';
    $entry['objectclass'][2]='top';



    $fichier="compteur_groupe_".$entry['description'][0].".txt";

    $ldap = new Ldap($serveur);
    $entry['gidnumber'][0]=$ldap->gen_code_inc5000($base_groupe, 'gidNumber');
      

    //Connexion au serveur LDAP
    $ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    $ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);



    ldap_add ($ldapconn, "cn=".$_POST['cn'].",".$base_groupe, $entry);
    
    sleep(5);

    header("Location: admin.php");
}
?>
