<!-- Annuaire (page chargée après succès de l'authentification (index.php)) -->

<!-- SOMMAIRE :
 * Barre de recherche
 * Onglets : instituts
 * Liste des équipes et personnels
 *   -  Affichage des équipes
 *   -  Affichage sans équipe
 * Onglet : Ajouter une équipe
 * Onglet : Ajouter un agent
-->

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

    <script type="text/javascript" src="scripts/prototype.lite.js"></script>
    <script type="text/javascript" src="scripts/moo.fx.js"></script>
    <script type="text/javascript" src="scripts/moo.fx.pack.js"></script>
    <script type="text/javascript" src="scripts/search.js"></script>
    <script type="text/javascript" src="scripts/ldap.js"></script>

  
</head>
<body>
    <!-- /////////////////////////////////////////////////////////// Barre de recherche ///////////////////////////////////////////// -->
    <select name="search_type" id="search_type"  >
    <option value="search_nom">Recherche Nom</option>
    <option value="search_bureau">Recherche Bureau</option>
    <option value="search_groupe">Recherche Groupe</option>
    <div id="wrapper"><div id="search-wrap" align="left">

         <form action="#" method="post" name="formulaire" id="formulaire">
            <input name="search-q" id="search-q" type="text" onKeyUp="javascript:autosuggest()"/> 
            <input type="button" onclick="location.href='search.php';" value="Recherche Avancée" /> 
            <br />
        </form> 

        <div id="results"></div>

        </div>
    </div><br />

    <!-- ///////////////////////////////////////////////////////// Onglets : instituts  ////////////////////////////////////////////  -->
    <div id="content">

          <?
            foreach($labo as $nom_labo){
          ?>
              <div class="tab">
                <h3 class="tabtxt" title="<?=$nom_labo;?>">
                    <a href="#"><?=$nom_labo;?></a>
                </h3>
              </div>
          <?
            } 
          ?>
<!-- ///////////////////////////////////////////////////////// Onglets : Création  ////////////////////////////////////////////  -->
          <div class="tab">
              <h3 class="tabtxt" title="Ajouter une &eacute;quipe">
                <a href="creation_groupe.php">Ajouter  &eacute;quipe</a>
              </h3>
          </div>

          <div class="tab">
              <h3 class="tabtxt" title="Ajouter un agent">
                <a href="creation_agent.php">Ajouter agent</a>
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

    <!-- ////////////////////////////////////////////////////////// Liste des équipes et personnels ///////////////////////////////////// -->
          <div class="boxholder"> 
             <?
              //.................................................... Affichage des équipes .........................................................
                foreach($labo as $nom_labo){
                echo '<div class="box"><table width="100%" border="0">';
                $filtre_groupe='(&(objectclass=*)(description='.$nom_labo.'))';
                $attribut=array('cn', 'igmmnomgroupefr', 'gidnumber');
                $groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut);
                echo '<tr>
                      <td colspan="9" align="left" valign="middle">'.$nom_labo.'</td>
                      </tr>';
                foreach($groupe as $key=>$equipe){
                    if($equipe['cn']!=""){
                        $liste_groupe[$nom_labo][]=$equipe['gidnumber'][0];
                        echo '
                              <!-- Affichage d`une équipe -->
                              <tr>
                              <td width="10%">&nbsp;</td>
                              <td width="89%" colspan="8">

                                  <a href="detail_groupe.php?gid='.$equipe['gidnumber'][0].'">
                                      <img src="images/b_props.png" alt="" border="0" title="Modifier le groupe '.$equipe['gidnumber'][0].' '.$nom_labo.'" />
                                  </a>

                                  <strong>
                                    '.$equipe['igmmnomgroupefr'][0].' - '.$equipe['cn'][0].' - '.$equipe['gidnumber'][0].'
                                  </strong>

                                  <a href="?q=suppgroupe&cn='.$equipe['cn'][0].'" onclick="return(confirm(\'Confirmer la suppression du groupe  '.$equipe['cn'][0].' - '.$equipe['igmmnomgroupefr'][0].' de l&acute;annuaire ?\')? true : false)">
                                      <img src="images/b_drop.png" alt=""  title="Supprimer groupe '.$equipe['cn'][0].' - '.$equipe['igmmnomgroupefr'][0].' de l\'annuaire" border="0"/>
                                   </a>

                              </td>
                              </tr>';
                        $filtre_personne='(gidnumber='.$equipe['gidnumber'][0].')';
                        $attribut=array('uidnumber','cn', 'sn', 'givenname', 'telephonenumber', 'roomnumber', 'mail', 'o','igmmstatutfr', 'shadowexpire');
                        $info[$nom_labo][$equipe['cn'][0]]=$ldap->recherche($base_personne, $filtre_personne, $attribut); 
                        foreach($info[$nom_labo][$equipe['cn'][0]] as $key=>$personne){
                            if($personne['sn'][0]!=""){
                                //Begin : line showing one person's data
                                echo '
                                        <!-- Affichage d`un agent -->
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <a href="detail.php?uid='.$personne['uidnumber'][0].'">
                                                <img src="images/b_props.png" alt="" border="0" title="Modifier la fiche de '.$personne['givenname'][0].' '.strtoupper($personne['sn'][0]).'" />
                                            </a>
                                        </td>
                                        <td>    '.strtoupper($personne['sn'][0]).'  </td>
                                        <td>    '.$personne['givenname'][0].'   </td>
                                        <td>    '.$personne['telephonenumber'][0].'</td>
                                        <td>    '.$personne['roomnumber'][0].'</td>
                                        <td>    <a href="mailto:'.$personne['mail'][0].'">'.$personne['mail'][0].'</a>  </td>
                                        <td>    '.$personne['o'][0].'</td>
                                        <td>    '.$personne['igmmstatutfr'][0];
                                                if($personne['shadowexpire'][0]!=$date_titulaire)       
                                                     echo ' <td> '.date("d/m/Y", $personne['shadowexpire'][0]*86400); 
                                                else{
                                                    echo ' <td> '. "PERMANENT";
                                                }
                                                echo '
                                        </td>
                                        </td>
                                        <td>
                                                <a href="?q=supp&cn='.$personne['cn'][0].'" onclick="return(confirm(\'Confirmer la suppression de '.$personne['givenname'][0].' '.strtoupper($personne['sn'][0]).' de l&acute;annuaire ?\')? true : false)"><img src="images/b_drop.png" alt=""  title="Supprimer '.$personne['givenname'][0].' '.strtoupper($personne['sn'][0]).' de l\'annuaire" border="0"/></a>
                                        </td>
                                      </tr>';
                              //end : line showing one person's data

                            } //end if
                        } //end foreach

                        echo '<tr>
                                  <td colspan="8" align="left" valign="middle">&nbsp;</td>
                              </tr>';

                     } // end if
                 } // end foreach

              //.................................................... Affichage sans équipe .........................................................

                $filtre_sans_equipe[$nom_labo]='(&';
                foreach($liste_groupe['IGMM'] as $groupe){
                    $filtre_sans_equipe[$nom_labo].='(!(gidnumber='.$groupe.'))';
                }
                $filtre_sans_equipe[$nom_labo].='(ou='.$nom_labo.'))';
                if(count($liste_groupe['IGMM'])){
                    echo '<tr>
                              <td width="10%">&nbsp;</td>
                              <td width="89%" colspan="8"><strong>SANS ÉQUIPE</strong></td>
                          </tr>';
                    $filtre_personne='(gidnumber='.$equipe['gidnumber'][0].')';
                    $attribut=array('uidnumber','cn', 'sn', 'givenname', 'telephonenumber', 'roomnumber', 'mail', 'o','igmmstatutfr');
                    $info[$nom_labo]['sans_equipe']=$ldap->recherche($base_personne, $filtre_sans_equipe[$nom_labo], $attribut); 
                    foreach($info[$nom_labo]['sans_equipe'] as $key=>$personne){
                        if($personne['sn'][0]!="")
                            //Begin : Affichage d'un agent
                            echo '
                                    <!-- Affichage d`un agent (sans équipe) -->
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td><a href="detail.php?uid='.$personne['uidnumber'][0].'"><img src="images/b_props.png" alt="" border="0" title="Modifier la fiche de '.$personne['givenname'][0].' '.strtoupper($personne['sn'][0]).'" /></a></td>
                                      <td>'.strtoupper($personne['sn'][0]).'</td>
                                      <td>'.$personne['givenname'][0].'</td>
                                      <td>'.$personne['telephonenumber'][0].'</td>
                                      <td> '.$personne['roomnumber'][0].'</td>
                                      <td><a href="mailto:'.$personne['mail'][0].'">'.$personne['mail'][0].'</a></td>
                                      <td>'.$personne['o'][0].'</td>
                                      <td>'.$personne['igmmstatutfr'][0].'</td>
                                      <td><a href="?q=supp&cn='.$personne['cn'][0].'" onclick="return(confirm(\'Confirmer la suppression de '.$personne['givenname'][0].' '.strtoupper($personne['sn'][0]).' de l&acute;annuaire ?\')? true : false)"><img src="images/b_drop.png" alt=""  title="Supprimer '.$personne['givenname'][0].' '.strtoupper($personne['sn'][0]).' de l\'annuaire" border="0"/></a></td>
                                  </tr>';
                        //end if

                    } //end foreach

                    echo '<tr>
                            <td colspan="8" align="left" valign="middle">&nbsp;</td>
                          </tr>';
                   }//end if
            
               echo '</table></div>';

               }//end for each

           //.............................................................. Fin affichage sans equipe ....................................................
               ?>
             </div>
        </div>
    </div>
    <script type="text/javascript">
        Element.cleanWhitespace('content');
        init();
    </script>
</body>
</html>
