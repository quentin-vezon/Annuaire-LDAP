<?php
require_once 'config.php';

$ldap = new Ldap($serveur);

$filtre = "(gidnumber=".$_REQUEST["gid"].")";
$info=$ldap->recherche($base_groupe, $filtre, $attribut);

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
                if (!found)
                    myAccordion.showThisHideOpen(stretchers[0]);
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
         
        <div class="boxholder">
          <div class="box"><br />
            <table width="80%" border="0" align="center">
            <tr>
                  <td><div align="right"><strong>Identifiant</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <?=$info[0]['cn'][0];?>
                  </label></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>Laboratoire</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <?=$info[0]['description'][0];?>
                  </label></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>Titre (fr)</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <?=$info[0]['igmmnomgroupefr'][0];?>
                  </label></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>Titre (en)</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <?=$info[0]['igmmnomgroupeen'][0];?>
                  </label></td>
                </tr> 
                <tr>
                  <td><div align="right"><strong>Uid du chef d'équipe</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <?=$info[0]['igmmuidmanager'][0];?>
                  </label></td>
                </tr>     
                <tr>
                  <td colspan="3"><label>
                      <div align="center"></div>
                    </label></td>
                </tr>
              </table>
          </div>
          <div class="box">
            <form id="form1" method="post" action="modif_groupe.php">
              <table width="100%" border="0">
                <tr>
                  <td><div align="right"><strong>Identifiant</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <input name="cn" type="text" id="cn" value="<?=$info[0]['cn'][0];?>" readonly/>
                  </label></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>Titre (fr)</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <input name="igmmnomgroupefr" type="text" id="igmmnomgroupefr" value="<?=$info[0]['igmmnomgroupefr'][0];?>" size="50" />
                  </label></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>Titre (en)</strong></div></td>
                  <td>:</td>
                  <td><label>
                    <input name="igmmnomgroupeen" type="text" id="igmmnomgroupeen" value="<?=$info[0]['igmmnomgroupeen'][0];?>" size="50" />
                  </label></td>
                </tr>
                 <tr>
                  <td><div align="right"><strong>Uid du chef d'équipe</strong></div></td>
                  <td>:</td>
                  <td><label> 
                    <input name="igmmuidmanager" type="text" id="igmmuidmanager" value="<?=$info[0]['igmmuidmanager'][0];?>" size="50" />
                  </label><div id="search-wrap" align="left">
                <form action="#" method="post" name="formulaire" id="formulaire">
                  Rechercher un agent :
                    <input name="search-q" id="search-q" type="text" onKeyUp="javascript:autosuggestce()"/> 
                    <br />
                </form>

                <div id="results"></div>
    </div></td>
                </tr>
                <tr>
                  <td align="right"><strong>Laboratoire</strong></td>
                  <td>:</td>
                  <td><select name="description" id="description">
                      <?
          foreach($labo as $nom_labo){?>
                      <option value="<?=$nom_labo?>" <? if($info[0]['description'][0]==$nom_labo)echo "selected";?>>
                      <?=$nom_labo?>
                      </option>
                      <? } ?>
                  </select></td>
                </tr>
                <tr>
                  <td><div align="right"></div></td>
                  <td>&nbsp;</td>
                  <td><input name="cn" type="hidden" id="cn" value="<?=$info[0]['cn'][0];?>" />
                      <input name="gidnumber" type="hidden" id="gidnumber" value="<?=$info[0]['gidnumber'][0];?>" /></td>
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
          </div>
          </div>
      </div>
    </div>
    <script type="text/javascript">
        Element.cleanWhitespace('content');
        init();
    </script>

</body>
</html>
