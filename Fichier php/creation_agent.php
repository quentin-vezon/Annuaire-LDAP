<?php
    require_once 'config.php';

    $ldap = new Ldap($serveur); 

    if($_GET['q']=='supp') {
             $ldap->efface($admin_user,$admin_pass,'cn='.$_GET['cn'].','.$base_personne);
             $entry['jpegphoto'][0]='';
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
           <!-- <input type="button" onclick="location.href='search.php';" value="Recherche Avancé" /> -->
            <br />
        </form> 

        <div id="results">
        </div>

    </div><br />

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
          
<!-- //////////////////////////////////////////////////////////// Onglet : Ajouter un agent  /////////////////////////////////////////////// -->
<div class="boxholder">    
<div class="box"><strong>Ajouter un agent </strong><br />
                   <br />
                   <br />               
                   <form action="new.php" method="post">
                     <table width="80%" border="0" align="center">
                     <td align="center" rowspan="25" width="150"> <!-- BBB -->
                     
                        <tr>
                         <td align="right"><strong>Laboratoire</strong></td>
                         <td>:</td>
                         <td colspan="2"><select name="ou" id="ou" onchange="prenom_nom()" required="required">
                           <?
              foreach($labo as $nom_labo){?>
                           <option value="<?=$nom_labo?>">
                           <?=$nom_labo?>
                           </option>
                           <? } ?>
                         </select></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Nom de l'utilisateur (Dupont)</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input name="sn" type="text" id="sn" size="50" onkeyup="prenom_nom() ; identifiant() " required="required" />
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Pr&eacute;nom de l'utilisateur (Jean)</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input name="givenname" type="text" id="givenname" size="50" onkeyup="prenom_nom() ; identifiant()" required="required" />
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Identifiant (jdupont)</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input type="text" name="cn" id="cn" required="required"/>
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Adresse Mail</strong></td>
                         <td>:</td>

                         <td colspan="2"><input name="mail" type="text" id="mail" size="50" required="required" /></td>
                       </tr>
                       <tr>
                       <td align="right"><strong>@cnrs.fr</strong></td>
                           <td>:</td>
                           <td>
                           <button name="button_email" type="button" id="button_email" onclick="funct_email()">Changer</button>
                          </td> 
                       </tr>   
                       <tr>
                         <td align="right"><strong>Organisme</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <select name="o" id="o" required="required">
                           <option value="">Sélectionner un Organisme</option>
                             <option value="CNRS">CNRS</option>
                             <option value="INSERM">INSERM</option>
                             <option value="UM">UM</option>
                             <option value="IFREMER">IFREMER</option>
                             <option value="INFECTIOPOLE-SUD">INFECTIOPOLE-SUD</option>
                             <option value="IRD">IRD</option>
                             <option value="CIRAD">CIRAD</option>
                             <option value="ARC">ARC</option>
                     <option value="Autre">Autre</option>
                           </select>
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>&Eacute;quipe</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                         <select name="gidnumber" id="gidnumber" required="required">
                         <option value="">Sélectionner une Equipe</option>
                           <?
                           foreach($labo as $nom_labo){
                           ?><option>-----<?=$nom_labo;?>-----</option>
                           <?
        $attribut=array('cn', 'igmmnomgroupefr', 'gidnumber');
        $filtre_groupe='(&(objectclass=*)(description='.$nom_labo.'))';
        $tri='igmmnomgroupefr';
        $groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut, $tri);

              foreach($groupe as $kay=>$equipe){
             if($equipe['gidnumber'][0]!=""){ ?>
                         <option value="<?=$equipe['gidnumber'][0]?>"><?=$equipe['cn'][0].' - '.$equipe['igmmnomgroupefr'][0]?></option>
                           <? }}} ?>
                         </select>
                           
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Statut</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <select name="igmmstatutfr" id="igmmstatutfr" required="required">
                           <option value="">Sélectionner un statut</option>
                         <? foreach($statut['fr'] as $key => $val){
                         echo '<option value="'.$key.'">'.$val.'</option>';
                        } ?>   
                </select>
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Titre</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                         <select name="igmmtitlefr" id="igmmtitlefr" required="required">
                        <option value=" ">Sélectionner un titre</option>
                        <? foreach($title['fr'] as $key => $val){
                         echo '<option value="'.$key.'">'.$val.'</option>';
                        } ?>
                        </select> 
                </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Bureau</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input name="roomnumber" type="text" id="roomnumber" size="50" required="required"/>
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>T&eacute;l&eacute;phone</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input name="telephonenumber" type="text" id="telephonenumber" value="+33 (0)4 34 35 9" required="required"/>
                         </label></td>
                       </tr>
                         <td align="right"><strong>Afficher le nom dans l'annuaire</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input name="igmmaffichageannuaire" type="checkbox" id="igmmaffichageannuaire" value="TRUE" checked="checked" />
                         </label></td>
                       </tr>
                       <tr>
                         <td align="right"><strong>Shell</strong></td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <input name="loginshell" type="text" id="loginshell" value="/bin/bash" required="required"/>
                         </label></td>
                       </tr>
                       <tr>
                        <td align="right"><strong>Inscription sur les listes d'email</strong></td>
                           <td>:</td>
                           <td>
                             <button name="button_nolist" type="button" id="nolist" onclick="yes_list('description')">Oui</button>
                             <button name="button_nolist" type="button" id="nolist" onclick="no_list('description','NOLIST')">Non</button>
                        </td> 
                      </tr>
                       <tr>
                         <td align="right"><strong>Notes</strong><br />
                           (mettre CDD le cas échéant)</td>
                         <td>:</td>
                         <td colspan="2"><label>
                           <textarea name="description" id="description" cols="45" rows="5" ></textarea>
                         </label></td>
                       </tr>
                       <tr><td align="right"><strong>Date de d&eacute;but de contrat</strong></td>
                         <td>:</td>
                          <td>
                           <input type="text" name="datedebut" id="datedebut" placeholder="dd/mm/yyyy" data-slots="dmyh" size=10 required="required"/>
                          </td> 
                       </tr> 
                       <tr>
                         <td align="right"><strong>Dur&eacute;e de valid&eacute; du shell</strong></td>
                         <td>:</td>
                         <td>
                             <input type="radio" name="shadowexpire" id="radio2" value="00000" checked="checked" onclick="required_shadow()" />
                           Non permanent
                           <label> </label>               
                          </td>
                        </tr>
                        <tr>
                         <td align="right"></strong>
                             <td>&emsp;</td>
                             <td>
                                 <label>
                                 &emsp; &emsp; Date de fin de validit&eacute; : 
                                 <input type="text" name="datefin" id="datefin" placeholder="dd/mm/yyyy" data-slots="dmyh" size=10  required="false" />                     
                                 </label>
                             </td>
                         </td>
                       </tr>
                       <tr>
                         <td align="right">&nbsp;</td>
                         <td>&nbsp;</td>
                         <td colspan="2"><br />
                           <input name="shadowexpire" type="radio" id="radio" value="<?=$date_titulaire;?>" onclick="required_shadow()" />
                           Permanent                     
                          </td>
                       </tr>
                       <tr>
                         <td align="right">&nbsp;</td>
                         <td>&nbsp;</td>
                         <td colspan="2">&nbsp;</td>
                       </tr>
                       <tr>
                         <td colspan="4"><label>
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