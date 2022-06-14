<?php
    require_once 'config.php';

    $ldap = new Ldap($serveur);

    if($_GET['q']=='supp'){
        $ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        $ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);
        $entry['jpegphoto'][0]='';
        ldap_modify($ldapconn, "cn=".$_GET['cn'].",".$base_personne, $entry);
        header("Location: ?&uid=".$_GET['uid']);
    }
    
// TODO  .................................................................................. /
// ........................................................................................ /

    if($_FILES['uploadedfile']){
        
        $file = '/var/www/alkaid/upload/'.basename( $_FILES['uploadedfile']['name']); 
        
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $file)) {
            $AttributeValue = fread(fopen($file, "r"), filesize($file));
            fclose($file);
            $ldapconn = ldap_connect($serveur) or die("Impossible de se connecter au serveur LDAP.");
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            $ldapbind = ldap_bind($ldapconn, $admin_user, $admin_pass);
            $entry['jpegphoto'][0]=$AttributeValue;
            ldap_modify($ldapconn, "cn=".$_POST['cn'].",".$base_personne, $entry);
            unlink($file);
            header("Location: ?&uid=".$_POST['uid']);
        }
    }
    

    $filtre = "(uidNumber=".$_REQUEST["uid"].")";
    $info=$ldap->recherche_admin($base_personne, $admin_user, $admin_pass, $filtre, $attribut);
    $attribut=array('cn', 'igmmnomgroupefr', 'gidnumber');
    $filtre_groupe='(&(objectclass=*)(gidnumber='.$info[0]['gidnumber'][0].'))';
    $groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut, $tri);
    $info[0]['nom_groupe'][0]=$groupe[0]['cn'][0];


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
    <script type="text/javascript">
        function init(){
            var stretchers = document.getElementsByClassName('box');
            var toggles = document.getElementsByClassName('tab');
            var myAccordion = new fx.Accordion(
                toggles, stretchers, {opacity: false, height: true, duration: 600}
            );
            //hash functions
            var found = false;
            toggles.each(function(h3, i){
                var div = Element.find(h3, 'nextSibling');
                    if (window.location.href.indexOf(h3.title) > 0) {
                        myAccordion.showThisHideOpen(div);
                        found = true;
                    }
                });
                if (!found) myAccordion.showThisHideOpen(stretchers[0]);
        }

    </script>
</head>

<body>
<div id="wrapper">
  <div id="content">
	<div class="tab1">
      <h3 class="tabtxt" title="Retour"><a href="admin.php">Retour</a></h3>
    </div>
    <div class="tab">
      <h3 class="tabtxt" title="Informations"><a href="#">Informations</a></h3>
    </div>
    <div class="tab">
      <h3 class="tabtxt" title="Modifier"><a href="#">Modifier</a></h3>
    </div>
     <div class="tab">
      <h3 class="tabtxt" title="Mot de passe"><a href="mdp/indexmdp.php">Mot de passe</a></h3>
    </div>
    <div class="boxholder">
      <div class="box"><strong>Récapitulatif de l'agent</strong><br />
        <table width="80%" border="0" align="center">
        <tr> <!-- AAA -->
            <td align="center" rowspan="25" width="150"> <!-- BBB -->

            <!-- ----- Gestion photo de l'utilisateur ----- -->
                <?php 
                    if(!$info[0]["jpegphoto"][0])
                        echo "<img  src='images/nophoto.jpg' width='100'>";
                    else 
                        echo "<a href='?q=supp&cn=".$info[0]["cn"][0]."&uid=".$_REQUEST["uid"]."'>Supprimer la photo</a><br><img  src='photo.php?uidnumber=".$info[0]["uidnumber"][0]."' width='100' >";

                ?>

                <form enctype="multipart/form-data" action="" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000" /> <!--  (1 = 1octet)  -->
                    <input type="hidden" name="uid" value="<?php echo $_REQUEST["uid"]?>" />
                    <input type="hidden" name="cn" value="<?php echo $info[0]["cn"][0]?>" />
                    <input type="file"   name="uploadedfile" />
                    <input type="submit" value="Télécharger" />
                </form>
             <!-- ----- Fin gestion photo de l'utilisteur ----- -->
            
            <tr> <!-- TODO check -->
              <td><div align="right"><strong>Nom de l'utilisateur (Dupont)</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['sn'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Prénom de l'utilisateur (Jean)</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['givenname'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Identifiant (jdupont)</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['cn'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Mail</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['mail'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Organisme</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['o'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>&Eacute;quipe</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['nom_groupe'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Statut</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['igmmstatutfr'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Titre (fr)</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['igmmtitlefr'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Titre (en)</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['igmmtitleen'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Bureau</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['roomnumber'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Téléphone</strong>&nbsp;&#9990;</div></td>
              <td>:</td>
              <td><label>
                <? if($info[0]['telephonenumber'][0]!='NULL')echo $info[0]['telephonenumber'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Afficher le nom dans l'annuaire</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['igmmaffichageannuaire'][0]?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Shell</strong></div></td>
              <td>:</td>
              <td><label>
                <?=$info[0]['loginshell'][0];?>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Notes</strong></div></td>
              <td>:</td>
              <td><label>
                <? if($info[0]['description'][0]!='NULL')echo $info[0]['description'][0];?>
              </label></td>
            </tr>
            <tr>
              <td align="right"><strong>Date de début de contrat</strong></td>
              <td>:</td>
              <td>
                  <?=date("d/m/Y", $info[0]['igmmdatearrivee'][0]*86400);?>                
              </td>
            </tr>
      
          <? if($info[0]['shadowexpire'][0]!=$date_titulaire){?>
            <tr>

              <td align="right"><strong>Date de fin de validité</strong></td>
              <td>:</td>
              <td>
                  <?=date("d/m/Y", $info[0]['shadowexpire'][0]*86400);?>                </td>
            </tr>
          <? } ?>
            <tr>
              <td colspan="3"><label>
                  <div align="center"></div>
                </label></td>
            </tr>

            </td> <!-- Fin AAA -->
           </tr> <!-- Fin BBB -->

          </table>

      </div><!-- fin <div class="box"> --> 

      <div class="box">
        <form id="form1" method="post" action="modif.php">
          <table width="100%" border="0">
            <tr>
              <td><div align="right"><strong>Nom de l'utilisateur (Dupont)</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="sn" type="text" id="sn" value="<?=$info[0]['sn'][0];?>" />
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Prénom de l'utilisateur (Jean)</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="givenname" type="text" id="givenname" value="<?=$info[0]['givenname'][0];?>" />
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Identifiant (jdupont)</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="cn" type="text" id="cn" value="<?=$info[0]['cn'][0];?>"  />
              </label></td>
            </tr>
           <tr>
              <td><div align="right"><strong>Mail</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="mail" type="text" id="mail" value="<?=$info[0]['mail'][0];?>" />
              </label></td>
            </tr>

            <tr>
              <td><div align="right"><strong>Organisme</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <select name="o" id="o">
                  <option value="CNRS" <? if($info[0]['o'][0]=="CNRS")echo "selected";?>>CNRS</option>
                  <option value="INSERM" <? if($info[0]['o'][0]=="INSERM")echo "selected";?>>INSERM</option>
                  <option value="UM" <? if($info[0]['o'][0]=="UM")echo "selected";?>>UM</option>
                  <option value="IFREMER" <? if($info[0]['o'][0]=="IFREMER")echo "selected";?>>IFREMER</option>
                  <option value="INFECTIOPOLE-SUD" <? if($info[0]['o'][0]=="INFECTIOPOLE-SUD")echo "selected";?>>INFECTIOPOLE-SUD</option>
                  <option value="IRD" <? if($info[0]['o'][0]=="IRD")echo "selected";?>>IRD</option>
                  <option value="CIRAD" <? if($info[0]['o'][0]=="CIRAD")echo "selected";?>>CIRAD</option>
                  <option value="ARC" <? if($info[0]['o'][0]=="ARC")echo "selected";?>>ARC</option>
                  <option value="Autre" <? if($info[0]['o'][0]=="Autre")echo "selected";?>>Autre</option>
                
                </select>
              </label></td>
            </tr>
            <tr>
              <td align="right"><strong>Laboratoire</strong></td>
              <td>:</td>
              <td colspan="2">
                <select name="ou" id="ou">
                      <?
                      foreach($labo as $nom_labo){?>
                      <option value="<?=$nom_labo?>" <? if($info[0]['ou'][0]==$nom_labo)echo "selected";?>>
                      <?=$nom_labo?>
                      </option>
                      <? } ?>
                  </select>
                </td>
            </tr>
            <tr>
              <td><div align="right"><strong>Equipe</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
              <select name="gidnumber" id="gidnumber">
                  <?
				   foreach($labo as $nom_labo){
				   ?>
                  <option>-----
                    <?=$nom_labo;?>
                    -----</option>
                  <?
                    $attribut=array('cn', 'igmmnomgroupefr', 'gidnumber');
                    $filtre_groupe='(&(objectclass=*)(description='.$nom_labo.'))';
                    $tri='igmmnomgroupefr';
                    $groupe=$ldap->recherche($base_groupe, $filtre_groupe, $attribut, $tri);

                      foreach($groupe as $kay=>$equipe){
                         if($equipe['gidnumber'][0]!=""){ ?>
                              <option value="<?=$equipe['gidnumber'][0]?>" <? if($info[0]['gidnumber'][0]==$equipe['gidnumber'][0])echo "selected";?>>
                                <?=$equipe['cn'][0].' - '.$equipe['igmmnomgroupefr'][0]?>
                              </option>
                              <? }}} ?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Statut</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <select name="igmmstatutfr" id="igmmstatutfr">
                <option value="">Sélectionner un statut</option>
                <? foreach($statut['fr'] as $key => $val){
                 echo '<option value="'.$key.'"'; if($info[0]['igmmstatutfr'][0]==$val)echo "selected"; echo '>'.$val.'</option>';
                } ?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Titre</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <select name="igmmtitlefr" id="igmmtitlefr">
                <option value="">Sélectionner un titre</option>
                <? foreach($title['fr'] as $key => $val){
                 echo '<option value="'.$key.'"'; if($info[0]['igmmtitlefr'][0]==$val)echo "selected"; echo '>'.$val.'</option>';
                } ?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Bureau</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="roomnumber" type="text" id="roomnumber" value="<?=$info[0]['roomnumber'][0];?>" />
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Téléphone</strong>&nbsp;&#9990;</div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="telephonenumber" type="text" id="telephonenumber" value="<? if($info[0]['telephonenumber'][0]!='NULL')echo $info[0]['telephonenumber'][0];?>" />
              </label></td>
            </tr>
              <td><div align="right"><strong>Afficher le nom dans l'annuaire</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="igmmaffichageannuaire" type="checkbox" id="igmmaffichageannuaire" value="TRUE" <? if($info[0]['igmmaffichageannuaire'][0]=='TRUE')echo 'checked="checked"';?> />
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Shell</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <input name="loginshell" type="text" id="loginshell" value="<?=$info[0]['loginshell'][0];?>" />
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Notes</strong></div></td>
              <td>:</td>
              <td colspan="2"><label>
                <textarea name="description" id="description" cols="45" rows="5"><? if($info[0]['description'][0]!="NULL")echo $info[0]['description'][0];?>
                </textarea>
              </label></td>
            </tr>
            <tr>
              <td><div align="right"><strong>Date de début de contrat</strong></div></td>
              <td>:</td>
              <td colspan="2">
                <label>
                <input name="datedebut" type="text" id="datedebut" value="<?=date("d/m/Y", $info[0]['igmmdatearrivee'][0]*86400);?>" />
                </label>
                </td>
            </tr>
            <tr>
              <td><div align="right"><strong>Durée de validé du shell</strong></div></td>
              <td>:</td>
              <td colspan="2"><label> <br />
                <input name="shadowexpire" type="radio" id="radio" value="<?=$date_titulaire?>" <? if($info[0]['shadowexpire'][0]==$date_titulaire)echo 'checked="checked"';?> />
                Permanent </label>
                  <label></label></td>
            </tr>
            <tr>
              <td><div align="right"></div></td>
              <td>&nbsp;</td>
              <td>
                  <input type="radio" name="shadowexpire" id="radio2" value="00000" <? if($info[0]['shadowexpire'][0]!=$date_titulaire)echo 'checked="checked"';?>/>
                Non permanent
                <label> </label>              </td>
              <td>Date de fin de validité :
                <label>
                <input name="datefin" type="text" id="datefin" value="<?=date("d/m/Y", $info[0]['shadowexpire'][0]*86400);?>" />(jj/mm/aaaa)                </label></td>
            </tr>
            <tr>
              <td><div align="right"></div></td>
              <td>&nbsp;</td>
              <td colspan="2"><input name="cn" type="hidden" id="cn" value="<?=$info[0]['cn'][0];?>" />
                  <input name="uidnumber" type="hidden" id="uidnumber" value="<?=$info[0]['uidnumber'][0];?>" /></td>
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
      </div> <!-- fin <div class="box"> -->


    </div> <!-- fin <div ...="boxholder"> -->
  </div><!-- fin <div ...="conter"> -->
</div> <!-- fin <div ...="wrapper"> -->

<script type="text/javascript">
	Element.cleanWhitespace('content');
	init();
</script>

</body>
</html>
