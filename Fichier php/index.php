<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- Page d'authentification -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>aSIC - Gestion annuaire</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/ldap.css" rel="stylesheet" type="text/css" />

    <!-- logo dans l'onglet du navigateur -->
        <link rel="shortcut icon" href="images/icon.ico" />


<body>
    <div id="wrapper">
	    
        <!--.......................... tab ........................................... -->
        <div class="tab">
            <h3 class="tabtxt" title="Identification"><a href="#">Identification</a></h3>
        </div>

        <!--.......................... boxholder ........................................... -->
        <div class="boxholder">

            <div class="box"><br /><br />
                <form id="authentification" method="post" action="admin.php">

                    <div align="center" class="box">
                        <table width="48%" border="0" class="box">
                        
                            <tr><!-- ----------------------------------------------------- -->
                                <td align="right"><strong>Nom d'utilisateur (cn)</strong></td>
                                <td align="center">:</td>
                                <td align="left">
                                    <label>
                                        <input type="text" name="cn" id="cn" />
                                    </label>
                                </td>
                            </tr>

                            <tr><!-- ----------------------------------------------------- -->
                               <td align="right"><strong>Mot de passe</strong></td>
                               <td align="center">:</td>
                               <td align="left"><input type="password" name="pass" id="pass" /></td>
                            </tr>

                            <tr><!-- ----------------------------------------------------- -->
                               <td colspan="3" align="center" valign="middle">
                                   <label>
                                     <input name="q" type="submit" id="q" value="Authentification" />
                                   </label>
                               </td>
                           </tr>

                       </table>
                    </div>

              </form>
              <br /><br />
            </div>

	    </div>
    </div>
</body>
</html>
