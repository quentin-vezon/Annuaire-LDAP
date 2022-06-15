<?


/*
GESTION LDAP IGMM / IRIM (ex CPBS / CRBM v2.1 (01/10/2009)
par Yann DUMARTINEIX - contact@gestionsite.com
*/

//PARAMETRAGE
//SERVEUR

$serveur		=	'localhost';
$racine			=	"dc=sic,dc=montp,dc=cnrs,dc=fr";
$base_personne	=	"ou=people,".$racine;
$base_groupe	=	"ou=groupe,".$racine;


//Utilisateur administrateur
$admin_user = 'xxx';
$admin_pass = '!xxxx';


//Liste des laboratoires
$labo=array('CRBM', 'IGMM', 'IRIM', 'CEMIPAI', 'UAR', 'ANISEED', 'MRI', 'SIC');

//Liste des cn adminstrateurs 
$cn_admin=array(
				'xxx'	=>	'admin' ,
				'xxxx'			=>	'CRBM',
				'lseguier'		=>	'CRBM',
				'xxx'		=>		'IRIM',
);


//Date des permanents
$date_titulaire='24472';


//Statuts
$statut=array('fr'=> array(
							1=>'Professeur',
							2=>'Maître de conférences',
							3=>'Chercheur',
							4=>'Chercheur CRHC',
							5=>'Chercheur CRCN',
							6=>'Chercheur DR1',
							7=>'Chercheur DR2',
							8=>'Doctorant',							
							9=>'Post-Doc',
							10=>'Stagiaire',
							11=>'IR-Administratif',
							12=>'IE-Administratif',
							13=>'AI-Administratif',
							14=>'T-Administratif',
							15=>'AJT-Administratif',
							16=>'IR-Recherche',
							17=>'IE-Recherche',
							18=>'AI-Recherche',
							19=>'T-Recherche',
							20=>'AJT-Recherche',
							21=>'Medecin',
							22=>'Charge de Recherche',
							23=>'Directeur de Recherche',
							)
							,
				'en'=> array(
							1=>'Professor',
							2=>'Lecturer',
							3=>'Staff Scientist',
							4=>'Staff Scientist',
							5=>'Staff Scientist',
							6=>'Staff Scientist',
							7=>'Staff Scientist',
							8=>'PhD Student',
							9=>'Post-Doc',
							10=>'Trainee',
							11=>'Administratif Staff',
							12=>'Administratif Staff',
							13=>'Administratif Staff',
							14=>'Administratif Staff',
							15=>'Administratif Staff',
							16=>'Research Assistant',
							17=>'Research Assistant',
							18=>'Research Assistant',
							19=>'Research Assistant',
							20=>'Research Assistant',
							21=>'Doctor',
							22=>'Research Fellow',
							23=>'Research Director',
							)
			);

//Statuts (Titres ?)
$title=array('fr'=> array(
							1=>'Pas de Titre',
							2=>'Administrateur',
							3=>'Chef d\'équipe',
							4=>'Directeur & Chef d\'équipe',
							5=>'Directeur Adjoint & Chef d\'équipe',
							6=>'Responsable de Service - Head Computer Science',
							7=>'Responsable de Service - Head Animal Facility',
							8=>'Responsable de Service - Workshop Head',						
							9=>'Autre'
							)
							,
				'en'=> array(
							1=>'Empty title',
							2=>'Administrative Officer',
							3=>'Group Leader',
							4=>'Director & Group Leader',
							5=>'Deputy director & Group Leader',
							6=>'Head Computer Science',
							7=>'Head Animal Facility',
							8=>'Workshop Head',
							9=>'Other'
							)
			);



//FIN PARAMETRAGE


require_once 'class.php';


session_start();

//Gestion de l'authentification LDAP
    if($_POST['q']=="Authentification"){
        $ldap = new Ldap($serveur);
        $base = 'cn='.$_POST['cn'].','.$base_personne;
        $auth=$ldap->auth($base, $_POST['pass']);
        if($auth!=1){
			header("Location: error_connect.php",TRUE,307);
           //echo"error";
        }
        else {
            $_SESSION['cn']=$_POST['cn'];
        }
}

//Vérifie si l'uilisateur possède les droits d'accès
    $cn=$_SESSION['cn'];
    if(!isset($cn_admin[$cn]))
		header("Location: error_droit.php",TRUE,307);

    if($cn_admin[$cn]=='admin'){
        $filtre_personne='(cn=*)';
    }else{ 
        $filtre_personne='(ou='.$cn_admin[$cn].')';
        $labo=array($cn_admin[$cn]);
    }
    $attribut = array( "*" );

    $filtre_groupe='(objectClass=*)';



function NTLMHash($Input) {
  $Input=iconv('UTF-8','UTF-16LE',$Input);
  $MD4Hash=hash('md4',$Input);
  $NTLMHash=strtoupper($MD4Hash);
  return($NTLMHash);
}

?>
 
