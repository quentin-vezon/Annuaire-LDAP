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
   <!-- <option value="search_date">Recherche Date de Fin</option> -->
    <div id="wrapper"><div id="search-wrap" align="left">

        <form action="admin.php" method="post" name="formulaire" id="formulaire">
            <input name="search-q" id="search-q" type="text" onKeyUp="javascript:autosuggest()"/> 
           
            <br />
        </form>

        <div id="results">
        </div>

    </div><br />

    <!-- ///////////////////////////////////////////////////////// Contenu de la page  ////////////////////////////////////////////  -->
    <div id="content">
    <!-- ///////////////////////////////////////////////////////// Onglets : retour  ////////////////////////////////////////////  -->
    <div class="tab">
              <h3 class="tabtxt" title="Retour">
                <a href="admin.php">Retour</a>
              </h3>
          </div>

<!-- ///////////////////////////////////////////////////////// Onglets : Création  ////////////////////////////////////////////  -->
          <div class="tab">
              <h3 class="tabtxt" title="Ajouter une &eacute;quipe">
                <a href="admin.php">Ajouter  &eacute;quipe</a>
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
          
<div class="boxholder"> 
<!-- ////////////////////////////////////////////////////////////////// Onglet : Ajouter une équipe  ////////////////////////////////////////////////// -->
<div class="box" >
                <strong>Ajouter une &eacute;quipe </strong><br /><br />
                    <form action="new_groupe.php" method="post">
                        <table width="80%" border="0" align="center">
                            <tr>
                                <td align="right"><strong>Laboratoire</strong></td>
                                <td>:</td>
                                <td><select name="description" id="description" onchange="groupe()" required="required" >
                                     <?
                                      foreach($labo as $nom_labo){
                                     ?>
                                      <option value="<?=$nom_labo?>">
                                         <?=$nom_labo?>
                                      </option>
                                     <? } ?>
                                     </select>
                                </td>
                            </tr>
                            <tr>
                                 <td align="right"><strong>Nom du groupe (LABO_eqprof)</strong></td>
                                 <td>:</td>
                                 <td>
                                   <label>
                                        <input name="cn" type="text" id="cn" size="20" required="required" />
                                   </label>
                                 </td>
                           </tr>
                           <tr>
                               <td align="right"><strong>Intitulé (fr)</strong></td>
                               <td>:</td>
                               <td>
                                   <label>
                                        <input name="igmmnomgroupefr" type="text" id="igmmnomgroupefr" size="50" required="required"/>
                                   </label>
                               </td>
                           </tr>
                            <tr>
                               <td align="right"><strong>Intitulé (en)</strong></td>
                               <td>:</td>
                               <td>
                                    <label>
                                         <input name="igmmnomgroupeen" type="text" id="igmmnomgroupeen" size="50" required="required"/>
                                    </label>
                               </td>
                            </tr>
                            <tr>
                                 <td colspan="3"><label>
                                     <div align="center">
                                       <input type="submit" name="button" id="button" value="Enregistrer" />
                                     </div>
                                   </label></td>
                               </tr>
                             </table>
                           </form>
                           <br />
                   <br />
                 </div>
</div>
</div>
</body>
</html>