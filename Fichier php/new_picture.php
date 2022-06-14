

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

    <div id="content">
    
    <!-- ///////////////////////////////////////////////////////// Onglets : retour  ////////////////////////////////////////////  -->
    <div class="tab">
              <h3 class="tabtxt" title="Retour">
                <a href="admin.php">Retour</a>
              </h3>
          </div>


    <div class="boxholder">
        <div class="box"><strong>Ajouter une petite photo non?</strong><br />
        <br />
        <br />   
        <table width="80%" border="0" align="center">
        <tr> <!-- AAA -->
            <td align="center" rowspan="25" width="150"> <!-- BBB -->

            <?php

            if(isset($_POST) && !empty($_POST)){

            if($_FILES['uploadedfile']['error'] == 0){   
                
                if($_FILES['uploadedfile']['size'] > 1500000){
                    $error = 'Fichier trop lourd';
                }

                $extension = strrchr($_FILES['uploadedfile']['name'],'.');
                if($extension != '.jpg'){
                    $error = "Besoin de jpeg";
                }

                if(!isset($error)){
                    move_uploaded_file($_FILES['uploadedfile']['tmp_name'], 'upload/'.$_FILES['uploadedfile']['name']);
                    echo "<img src=".'upload/'.$_FILES['uploadedfile']['name']." height=200 width=300 />";
                }

            }else{
                    $error = "problème formulaire";
                }
            }
            ?>

            <div style="color:red;"><p><?php if(isset($error)) echo $error; ?></p></div>

            <form method="post" action="#" enctype="multipart/form-data">
            <input type="file" name="uploadedfile" value="" >
            <input type="submit" name="dowload" value="Télécharger le fichier ">

            </form>
        </table>
        <br />
        <br />
    </div>
    </div>
</div>
</body>
</html>