<?php
    require_once 'config.php';

    $ldap = new Ldap($serveur); 

    if($_GET['q']=='supp') {
             $ldap->efface($admin_user,$admin_pass,'cn='.$_GET['cn'].','.$base_personne);
        
             header("Location: ?");
    }

    if($_GET['q']=='suppgroupe') {
             $ldap->efface($admin_user,$admin_pass,'cn='.$_GET['cn'].','.$base_groupe);
             header("Location: ?");
    }


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>aSIC - Gestion annuaire</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/ldap.css" rel="stylesheet" type="text/css" />
    <!-- logo dans l'onglet du navigateur -->
    <link rel="shortcut icon" href="images/icon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    
    <script type="text/javascript" src="scripts/prototype.lite.js"></script>
    <script type="text/javascript" src="scripts/moo.fx.js"></script>
    <script type="text/javascript" src="scripts/moo.fx.pack.js"></script>
    <script type="text/javascript" src="scripts/search.js" defer></script>
    <script type="text/javascript" src="scripts/ldap.js" defer></script>
    <script type="text/javascript" src="scripts/download.js" defer></script>
    <script type="text/javascript" src="scripts/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    



</head>
<body>

    <div id="content">
    
    <!-- ///////////////////////////////////////////////////////// Onglets : retour  ////////////////////////////////////////////  -->
          <div class="tab">
              <h3 class="tabtxt" title="Retour">
                <a href="admin.php">Retour</a>
              </h3>
          </div>

          <!-- ///////////////////////////////////////////////////////// Déconnexion  ////////////////////////////////////////////  -->      
          <div class="tab">
              <h3 class="tabtxt" title="Déconnexion">
                <?php
                echo " <a onclick=\"if (!confirm('Vous souhaitez quitter votre session ? ')){ event.preventDefault(); }\" href='logout.php'> Déconnexion</a>";
                ?>
              </h3>
          </div>
            
          <div class="site-content main">

  
<article id="article" class="pageContent ">



  <?php
    $searchName = ( $_GET[ 'searchname' ] ) ? $_GET[ 'searchname' ] : '';
    $searchFirstName = ( $_GET[ 'searchfirstname' ] ) ? $_GET[ 'searchfirstname' ] : '';
    $searchDate = ( $_GET[ 'searchdate' ] ) ? $_GET[ 'searchdate' ] : '';
    $searchBureau = ( $_GET[ 'searchbureau' ] ) ? $_GET[ 'searchbureau' ] : '';

    $searchName = trim($searchName);
    $searchFirstName = trim($searchFirstName);
    
   
    ?>


<div class="block blockForm directoryBlock">
         
</br></br></br>
        <div id="m-4">
            <ul class="nav nav-pills" id="myTab">
                <li class="nav-item"><a href="#searchByName"  class="nav-link active" data-bs-toggle="tab"><span>Nom</span></a></li>
                <li class="nav-item"><a href="#searchByFirstName" class="nav-link" data-bs-toggle="tab"><span>Prenom</span></a></li>
                <li class="nav-item"><a href="#searchByBureau"  class="nav-link" data-bs-toggle="tab"><span>Bureau</span></a></li>
                <li class="nav-item"><a href="#searchByDate"  class="nav-link" data-bs-toggle="tab"><span>Date Fin de contrat</span></a></li>
            </ul>

        <div class="tab-content">   
            <div id="searchByName" class="tab-pane fade show active">
                <form action="#" method="get" name="directoryNameForm">
                        <input type="text" value="<?php echo $searchName ?>" placeholder="Recherche par nom" name="searchname" class="nameSearchInput" />
                    <input type="submit" value="Rechercher" class="btn" />
                </form>
            </div>

            <div id="searchByFirstName" class="tab-pane fade">
                <form action="#" method="get" name="directoryFirstNameForm">
                        <input type="text" value="<?php echo $searchFirstName ?>" name="searchfirstname" placeholder="Recherche par prénom" class="nameSearchInput" />
                    <input type="submit" value="Rechercher" class="btn" />
                </form>
                
            </div>

            <div id="searchByBureau" class="tab-pane fade">
                <form action="#" method="get" name="directoryFirstNameForm">
                        <input type="text" value="<?php echo $searchBureau ?>" name="searchbureau" placeholder="Recherche de bureau" class="nameSearchInput" />
                    <input type="submit" value="Rechercher" class="btn" />
                </form>
                
            </div>

            <div id="searchByDate" class="tab-pane fade">
                <form action="#" method="get" name="directoryFirstNameForm">
                        Avant le : <input type="text" value="<?php echo $searchDate ?>" name="searchdate" placeholder="dd/mm/yyyy" class="nameSearchInput" />
                    <input type="submit" value="Rechercher" class="btn" />
                </form>
                
            </div>
                <div class="spacer"></div>
            </div>
        
        </div><!-- #tabs -->
</div>
   


    <div class="directoryResults " id="directoryResults">
<?php  if(!empty($searchName) OR !empty($searchFirstName) OR !empty($searchBureau) OR !empty($searchDate)): ?>

<h4 class="title4">Résultat</h4>

<?php endif; ?>    

<?php
//$lang='#LANG';
$lang='fr';
if($lang=='')$lang='fr';
//$Nom= $_GET['annuaire'];
//A changer pour le vrai serveur alkaid 
$Server="XXX";
$DateSeconde=strtotime ("now");
$DateUnix=$DateSeconde/86400;

$ldaprdn  = $admin_user;    
$ldappass = $admin_pass;    

$Connexion=ldap_connect($Server);

if( empty($_GET['labo']) ){ $labo = "*"; }
else { $labo=$_GET['labo']; }

if( !empty($_GET['searchname'] ) ){
$Nom=$_GET['searchname'];
$requete = "sn=".$_GET['searchname'];
$Filtre="(&($requete*)(igmmaffichageannuaire=TRUE)(|(ou=$labo)))";
}
elseif ( !empty($searchFirstName)  ){
$Nom = $searchFirstName;
$requete = "givenname=".$searchFirstName;
$Filtre="(&($requete*)(igmmaffichageannuaire=TRUE)(|(ou=$labo)))";
}
elseif( !empty($searchBureau)  ){
$Nom = '*';
$requete = "roomnumber=".$searchBureau;

$Filtre="(&($requete*)(igmmaffichageannuaire=TRUE)(|(ou=$labo)))";

}
elseif( !empty($searchDate)  ){
    $Nom = '*';
    $dateMax = explode("/",$searchDate);
    $convertDate = mktime(0, 0, 0, $dateMax[1], $dateMax[0]+1, $dateMax[2]);
    $convertDate = intval($convertDate/86400);
    
    
    $Filtre= "(shadowexpire<=".$convertDate.")";
    
    }

else {
$Filtre="(&($requete*)(igmmaffichageannuaire=TRUE)(|(ou=$labo)))";
}



ldap_set_option($Connexion, LDAP_OPT_PROTOCOL_VERSION, 3);
if ($Connexion){

$Identification=ldap_bind($Connexion, $ldaprdn, $ldappass);	
if ($Identification) {
    

//$Filtre="(&(sn=$Nom*)(igmmaffichageannuaire=TRUE)(|".$labo."))";
//$ldapSortAttributes = array('sn', 'givenname');
    $justthese = array( "uidnumber", "sn","o", "givenname","displayname", "mail","igmmmailalias","telephonenumber","roomnumber","shadowexpire","departmentnumber","employeetype","igmmStatutFR","igmmtitle".$lang,"igmmstatut".$lang,"igmmaffichageannuaire", "jpegphoto", "ou" );
    $Search=ldap_search($Connexion,"ou=people,dc=sic,dc=montp,dc=cnrs,dc=fr",$Filtre,$justthese);
    $filtre_groupe='(&(objectclass=*))';
    //$filtre_groupe='(& (departmentnumber=*))';
    $l_groupe=ldap_search($Connexion,"ou=groupe,dc=sic,dc=montp,dc=cnrs,dc=fr", $filtre_groupe,array("*"));
    $groupe=ldap_get_entries($Connexion, $l_groupe);
    foreach($groupe as $key=>$personne){

       $nom_groupe[$personne['cn'][0]]=$personne['igmmnomgroupe'.$lang][0];
       $nom_resp_groupe[$personne['cn'][0]]=$personne['igmmuidmanager'.$lang][0];
    }
    
        
    if ($Search) {
       
        
        $Info= ldap_get_entries($Connexion, $Search);
        $Count=ldap_count_entries($Connexion,$Search);
        array_multisort($Connexion,$Search,"sn");
        
        if (!empty($Info) && $Info['count'] != 0){
            //TODO Date Unix > Date inserer
          ?><h5><?php echo $Info['count']." agent(s) trouvé(s)"; ?></h5>
          
          <? for ($i=0;$i<$Info["count"]; $i++) {
                
                $ShadowExpire=$Info[$i]["shadowexpire"][0];
                if (($ShadowExpire > $DateUnix)||($ShadowExpire == "0")): ?>

                <div class="memberItem">


                    <div class="memberInfosWrapper">
                        <p><label>Nom</label> <?php echo stripslashes(strtoupper($Info[$i]["sn"][0])); ?></p>
                        <p><label>Prenom</label> <?php echo stripslashes($Info[$i]["givenname"][0]); ?></p>
                        <p><label>Statut</label> <?php echo stripslashes($Info[$i]["igmmstatut".$lang][0])." ".stripslashes($Info[$i]["o"][0])." ".stripslashes($Info[$i]["igmmtitle".$lang][0]); ?></p>
                        <p><label>Téléphone</label> <?php echo stripslashes($Info[$i]["telephonenumber"][0]); ?></p>
                        <p><label>E-mail</label> <?php echo stripslashes($Info[$i]["mail"][0]); ?></p>
                        <?php if($Info[$i]["roomnumber"][0] != 'NULL'): ?><p><label>Bureau</label> <?php echo stripslashes($Info[$i]["roomnumber"][0]); ?></p><?php endif; ?>
                        <p><label>Labo</label> <?php echo stripslashes($Info[$i]["ou"][0]); ?></p>
                        <p><label>Equipe</label> <?php echo stripslashes($nom_groupe[$Info[$i]["departmentnumber"][0]]); ?></p>
                        

                    </div><!-- .memberInfosWrapper -->
                    
                </div><!-- .memberItem -->
                <?php endif;
                    
    }//fin du for ($i=0;$i<$Attributs.....	
            
        }//fin de if($entry)
        else { ?>
            
                <div class="noResults">
                    <p><?php ('Sorry, no results were found in our database for this request.'); ?></p>
                </div>
            
        <?php }
}//fin de if($Search)
}//fin if ($identification)
else {
    echo $affichage_php = "<h4>Impossible de se connecter au serveur ldap en anonyme</h4>";
}
}
else {
echo $affichage_php = "<h4>Impossible de se connecter au serveur ldap</h4>";
} //fin if connexion

?>



    </div><!-- .directoryResults -->
    <button onclick="printDiv('directoryResults','Title')">Imprimer la recherche</button>
</article><!-- .pageContent -->

</div><!-- .site-content -->		
          
</body>
</html>
