<?
/*** Classe Ldap
* SOMMAIRE
	__construct($serveur)
	lect_ldap()
	admin_ldap($user,$pass)
	efface($user,$pass,$dn)
	recherche($base, $filtre, $attribut, $tri='')
	recherche_admin($base, $user, $pass, $filtre, $attribut, $tri='')
	auth($base, $pass)
	liste_recherche($base, $filtre, $attribut, $tri='')
    getLogin($base, $code, $selection)
    getPassword($base, $code, $selection)
***/
class Ldap{

	protected $connexion, $bind, $efface, $erreurs;
	
	function __construct($serveur)
	{
		$this->connexion = ldap_connect($serveur);
		ldap_set_option($this->connexion, LDAP_OPT_PROTOCOL_VERSION, 3);
	}
		
	function connexion()
	{
		return $this->connexion;
	}
	
	protected function lect_ldap()
	{
		$this->bind = ldap_bind($this->connexion) or $this->erreurs .= ldap_error($this->connexion);
		if(!$this->bind)
			return false;
		else
			return true;
	}
	
	protected function admin_ldap($user,$pass)
	{
		$this->bind =ldap_bind($this->connexion,$user,$pass) or $this->erreurs .= ldap_error($this->connexion);
		if(!$this->bind)
   
			return false;
		else
			return true;
	}
 //
	
	function efface($user,$pass,$dn)
	{
		$admin = $this->admin_ldap($user,$pass);
		if ($admin)
		{
			$this->efface = ldap_delete($this->connexion,$dn) or $this->erreurs .= ldap_error($this->connexion);
		if(!$this->efface)
			return false;
		else
			return true;
		}
	}
	
	function recherche($base, $filtre, $attribut) {
		$lect = $this->lect_ldap();
		if ($lect){
			$sr=ldap_search($this->connexion,$base,$filtre,$attribut);
			$this->nombre = ldap_count_entries($this->connexion,$sr);
			$info = ldap_get_entries($this->connexion, $sr);
			array_multisort($info);
			return $info;
		}else
			return false;
	}
	
	function recherche_admin($base, $user, $pass, $filtre, $attribut) {
		$lect = $this->admin_ldap($user,$pass);
		if ($lect){
			$sr=ldap_search($this->connexion,$base,$filtre,$attribut);
			$this->nombre = ldap_count_entries($this->connexion,$sr);
			$info = ldap_get_entries($this->connexion, $sr);
			array_multisort($info);
			return $info;
		}else
			return false;
	}
	
	function auth($base, $pass) {
		$this->bind=@ldap_bind($this->connexion,$base,$pass) or $this->erreurs .= ldap_error($this->connexion);
		if(!$this->bind)
		return false;
		else return true;
		
		}
	
	
	function liste_recherche($base, $filtre, $attribut, $tri=''){
	$info = $this->recherche($base, $filtre, $attribut, $tri);
	$aff = "<resultats>";
	foreach ($info as $key=>$info) {
				
					
					$aff .= "\n<resultat titre=\"" .$info['displayname'][0]."\" url=\"detail.php?uidn=".$info['uidnumber'][0]."\" />";
					 
				
			}
			$aff .= "\n</resultats>";
			echo $aff;
	
	}
	
	function gen_code($base, $code)
	{
		$attribut = array ($code);
		$tri = '';
		$groupe ['count'] = 1;
		while ( $groupe ['count'] > 0 ) {
			$number = rand ( 10000, 99999 );
			$filtre = '(' . $code . '=' . $number . ')';
			$groupe = $this->recherche ( $base, $filtre, $attribut, $tri );
		
		}
		return $number;
	}

	//Function qui génère un id à partir de 5000 + incrémentation si id déjà existant
	function gen_code_inc5000($base, $code)
	{
		$number = 5000;
		$attribut = array ($code);
		$tri = '';
		$groupe ['count'] = 1;
		while ( $groupe ['count'] > 0 ) {
			$number = $number+1;
			$filtre = '(' . $code . '=' . $number . ')';
			$groupe = $this->recherche ( $base, $filtre, $attribut, $tri );
		
		}
		return $number;
	}

	

    //-------------------------------------------------------------
    //Funciton inspired by gen_code()
    function getLogin($base, $code) {
		$attribut = array ($code);
		$tri = '';
		$groupe ['count'] = 1;
		while ( $groupe ['count'] > 0 ) {
            $login = shell_exec("scripts/createLogin.sh");
			$filtre = '(' . $code . '=' . $login . ')';
			$groupe = $this->recherche ( $base, $filtre, $attribut, $tri );
        }
        return $login;
    }

    //-------------------------------------------------------------
    //Function inspired by gen_code()
    function getPassword($base, $code) {
		$attribut = array ($code);
		$tri = '';
		$groupe ['count'] = 1;
		while ( $groupe ['count'] > 0 ) {
            $password = shell_exec("scripts/createPasswd.sh");
			$filtre = '(' . $code . '=' . $password . ')';
			$groupe = $this->recherche ( $base, $filtre, $attribut, $tri );
        }
        return $password;
    }
	
	/*function findLargestUidNumber($base)
		{
		$lect = $this->lect_ldap();
		if ($lect){
		  $s = ldap_search($this->connexion, $base, 'uidnumber=*');
		  if ($s) {
			 // there must be a better way to get the largest uidnumber, but I can't find a way to reverse sort.
			 ldap_sort($this->connexion, $s, "uidnumber");

			 $result = ldap_get_entries($this->connexion, $s);
			 $count = $result['count'];
			 $biguid = $result[$count-1]['uidnumber'][0];
			 return $biguid;
		  }
		  return null;
		}
		return null;
	}
*/

function validateUsingLdapExt($value)
 {
     if (!ldap_explode_dn($value, 0)) {
         return false;
     }
     return true;
 }
}


?>
