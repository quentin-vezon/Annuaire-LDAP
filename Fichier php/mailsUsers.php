<?php
###
# Mails aux utilisateurs
# @see new.php
# @version 2.3
###

### Valeurs html des caractères spéciaux :
# é &eacute;
# è &egrave;
# à &agrave;
# ' &#8217;
# ° &#176;
###

//////

	$expediteur   = "XXX@XXX.fr";
	$reponse      = $expediteur;

//////
	$sujet        =  utf8_decode("Loi Informatique et Libertés / IT, data files and civil liberty law");
	$codehtml     =
	"<html><body>" .
	"<b><u>Concernant Informatique et Libert&eacute;s</u></b><br>" .
	"<br>" .
	"Les services administratifs et informatiques disposent de moyens informatiques destin&eacute;s &agrave; g&eacute;rer le personnel.<br>" .
	"<br>" .
	"Les informations enregistr&eacute;es sont r&eacute;serv&eacute;es &agrave; l&#8217;usage des services concern&eacute;s.<br>" . 
	"<br>" .
	"Conform&eacute;ment aux articles 39 et suivants de la loi n&#176;78-17 du 6 janvier 1978 modifi&eacute;e, relative &agrave; l&#8217;informatique,<br> " .
	"aux fichiers et aux libert&eacute;s, toute personne peut obtenir communication et, le cas &eacute;ch&eacute;ant, rectification ou suppression <br>" .
	"des informations la concernant, en s&#8217;adressant au service administratif ou informatique." .
        //"Votre Login pour les photocopieuses canon est : ".$entry['igmmLoginUniFlow']."<br>".
        //"Votre Mot de passe pour toutes les photocopieuses est : <b>".$entry['igmmCodeUniFlow']."</b>".
    "<br><br>--------------------------------------------------------------------------------<br><br>" .
	"<u>About Information Technology, Data Files and Civil Liberty </u></b><br>" .
	"<br>" .
    "Administrative and IT departments have computer facilities dedicated to personnel management.<br>" .
	"<br>" .
    "Recorded data is reserved for the use of appropriate departments. <br> " .
	"<br>" .
	"In accordance with articles 39 et seq of the modificated law n&#176;78-17 of the 6th January 1978 related to information technology,<br> " .
	"data files and civil liberty : any person may ask the administrative or IT department, to get all informations about him or her. And if so, may also ask <br> ".
    "for their rectification or removal. <br> <br>" .

	"</body></html>";

	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

////////

	
	$sujet        =  utf8_decode("Bienvenue sur le Service Informatique IGMM IRIM CRBM CEMIPAI SI²C² / Welcome to the SI²C²"); 
	$codehtml     =
	"<html><body>" .
	"Bonjour.<br><br>" .
	"Vous trouverez des informations sur les services propos&eacute;s par le SI<sup>2</sup>C<sup>2</sup> et de la documentation sur le site :<br>" . 
                                                                                 //TODO "documentation" --> "tutoriels" ?
     "<a href='http://intranet.sic.int'>http://intranet.sic.int<br></a>" . 
                                                                                 //TODO inverser l'ordre des deux infos ?
    "<br> Pour toute demande d'intervention, vous devez faire un ticket sur le site suivant : <br>" .
    #"<br>Pour toute sollicitation, vous devez faire un ticket sur le site suivant : <br>" .
 	"<a href='https://glpi.sic.int'>https://glpi.sic.int</a><br>" .
	"En vous remerciant." .
    "<br><br>--------------------------------------------------------------------------------<br><br>" .
                                                                               //TODO v&eacute;rifier port&eacute;e diplomatique
	"Informations about IT Services provided by SI<sup>2</sup>C<sup>2</sup>, as well as tutorials are available on the following web site:<br>" .
     "<a href='http://intranet.sic.int'>http://intranet.sic.int<br></a>" . 
	"<br>Any request may be reported with a ticket, through our dedicated online platform: <br>" .
	"<a href='https://glpi.sic.int'>https://glpi.sic.int</a><br>" .
	"</body></html>" ;
	

	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");


///////
	$sujet        =  utf8_decode("Liste XXX@XXX.fr");
	$codehtml     =
	"<html><body>" .
	"Bonjour,<br><br>" .
	"La liste <b>XXX@XXX.fr</b> est destin&eacute;e &agrave; rechercher des produits chimiques et biologiques, ou encore &agrave; annoncer la disponibilit&eacute; d'un mat&eacute;riel scientifique (microscope, facs, PCR, etc.) <br> <br>" .
	"Cette liste regroupe les utilisateurs de l'IGMM, IRIM, CRBM et CEMIPAI. <br><br> " .
	"Vous pouvez vous abonner en envoyant un mail &agrave; l'adresse suivante : " .
	"<b>sympa@aurora.sic.montp.cnrs.fr </b><br>" .
    "Avec pour objet : <b> subscribe sic_help</b>.<br>" .
	"<br>" .
    "<br><br>--------------------------------------------------------------------------------<br><br>" .
	"Hello,<br><br>" .
	"The mailing list <b>XXX@XXX.fr</b> is dedicated to scientific exchanges such as chemical or biological reagent requests, or scientific devices availability (microscope, PCR machines, facs, etc.)<br> <br>".
	"If you wish to register to it, just send an e-mail to the following address : " .
	"<b>XXX@XXX.fr</b><br>" .
    "With <b> subscribe sic_help </b> as object.<br><br>" .
	"</body></html>";
 
	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

///////
	
	$sujet        =  utf8_decode("Liste XXX@XXX.fr");
	$codehtml     =
	"<html><body>" .
	"Bonjour.<br><br>" .
	"La liste <b>XXX@XXX.fr</b> est destin&eacute;e &agrave; annoncer tous les &eacute;v&egrave;nements et demandes &agrave; caract&egrave;re scientifique : s&eacute;minaires, animations scientifiques, etc.  <br> <br>" .
	"Cette liste regroupe les utilisateurs de l'IGMM, IRIM, CRBM et CEMIPAI. <br><br>" .
    "Vous pouvez vous abonner en envoyant un mail &agrave; l'adresse suivante :" .
    "<b>XXX@XXX.fr </b><br>" .
    "Avec pour objet : <b> subscribe sic_annonce</b>.<br>" .
    "<br><br>--------------------------------------------------------------------------------<br><br>" .
	"Hello.<br><br>" .
	"The mailing list <b>XXX@XXX.fr</b> is dedicated to scientific meeting announcements and requests: seminars, workshops, etc. <br> <br>".
	"<br>" .
	"If you wish to register to it, just send an e-mail to the following address : " .
	"<b>XXX@XXX.fr</b><br>" .
    "With <b> subscribe sic_annonce</b> as object.<br><br>" .
	"</body></html>";
	
	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");


///////


	$sujet        =  utf8_decode("Liste XXX@XXX.fr"); 
	$codehtml     =
	"<html><body>" .
	"Bonjour.<br><br>" .
	"La liste <b>XXX@XXX.fr</b> est destin&eacute;e aux petites annonces, locations, ventes, etc. <br> <br>" .
	"Cette liste regroupe les utilisateurs de l'IGMM, IRIM, CRBM et CEMIPAI." .
	"<br>" .
    "Vous pouvez vous abonner en envoyant un mail &agrave; l'adresse suivante : " .
    "<b>XXX@XXX.fr </b><br>" .
    "Avec pour objet : <b> subscribe sic_leboncoin</b>.<br>" .
    "<br><br>--------------------------------------------------------------------------------<br><br>" .
	"Hello.<br><br>" .
	"<br>" .
	"We have created a mailing list called '<b>XXX@XXX.fr<b>' which you should use to post adds related to house renting, sales, etc... <br> <br>" .
	"If you wish to register to it, just send an e-mail to the following address : " .
	"<b>XXX@XXX.cnrs.fr</b><br>" .
    "With <b> subscribe sic_leboncoin</b> as object.<br><br>" .
	"</body></html>";
 
	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

//////


        $sujet        =  utf8_decode("Liste XXX@XXX.fr");
        $codehtml     =
        "<html><body>" .
        "Bonjour.<br><br>" .
        "La liste <b>XXX@XXX.fr</b> est destin&eacute;e aux levuristes <br> <br>" .
        "Cette liste regroupe les utilisateurs de l'IGMM, IRIM, CRBM et CEMIPAI." .
        "<br>" .
    "Vous pouvez vous abonner en envoyant un mail &agrave; l'adresse suivante : " .
    "<b>XXX@XXX.fr </b><br>" .
    "Avec pour objet : <b> subscribe sic_yeast</b>.<br>" .
    "<br><br>--------------------------------------------------------------------------------<br><br>" .
        "Hello.<br><br>" .
        "<br>" .
        "We have created a mailing list called '<b>XXX@XXX.fr<b>' <br> <br>" .
        "If you wish to register to it, just send an e-mail to the following address : " .
        "<b>XXX@XXX.fr</b><br>" .
    "With <b> subscribe sic_yeast</b> as object.<br><br>" .
        "</body></html>";

        mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

//////



        $sujet        =  utf8_decode("Charte de Sécurité des Systèmes d'Information du CNRS / CNRS's Information System Security Charter");
        $codehtml     =
        "<html><body>" .
        "Bonjour,<br><br>" .
        "La charte suivante s&#8217;applique  &agrave; toute personne utilisant le syst&egrave;me d&#8217;information du CNRS :<br><br>" .
        "<a href='http://intranet.sic.int/index.php/le-sic/securite/103-charte-info'>Charte SSI CNRS</a>" .
        "<br><br>--------------------------------------------------------------------------------<br><br>" .
        "Hello,<br><br>" .
        "The following CNRS Information System Security Charter apply to any person using the CNRS's information system:<br><br>" .
        "<a href='http://intranet.sic.int/images/charte-cnrs-en-2014.pdf'>CNRS Information System Security Charter</a>" .
        "</body></html>";

	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

////
        $sujet        =  utf8_decode("Accès aux applications CNRS / CNRS's applications access");
        $codehtml     =
        "<html><body>" .
        "Bonjour,<br><br>" .
        "Afin de vous connecter aux applications nationales du CNRS (telles que Sirhus, Simbas ou Agathe), vous devez d&eacute;finir un mot de passe &agrave; l&#8217;adresse suivante :<br>" .
        "<a href=\"https://sesame.cnrs.fr/humanity/challenge?prevAction=search&prevCtrl=token\">Service Authentification JANUS</a> <br> <br>" .
        "Merci de fournir les informations n&eacute;cessaires &agrave; votre authentification. <br> <br>" .
        "" .
        "Vous devez choisir un mot de passe complexe : caract&egrave;res alphab&eacute;tiques, num&eacute;riques et signes ; au moins huit caract&egrave;res. <br> <br>" .
        "<b>Celui-ci est strictement personnel et confidentiel.</b><br><br>" . 
        "<br><br>--------------------------------------------------------------------------------<br><br>" .
        "Hello,<br>" .
        "To get access to all CNRS's national applications (such as Sirhus, Simbas or Agathe), you need to create a password at the following address : <br>" .
        "<a href=\"https://sesame.cnrs.fr/humanity/challenge?prevAction=search&prevCtrl=token\">JANUS Authentification Service </a> <br> <br>" .
        "Be sure to provide all necessary informations for your authentification.<br>" .
        "" .
        "You have to choose a complex password : alphanumeric characters and symbols ; at least eight characters.<br><br>" .
        "<b>Your password is strictly personal and confidential.</b><br><br>" . 
        "</body></html>";
                                                                        //TODO Il ne vous sera jamais demand&eacute; par le SIC.</b><br>" . 
/*
	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

////
        $sujet        =  utf8_decode("Vos identifiants photocopieurs/ Your credentials for printers");
        $codehtml     =
        "<html><body>" .
        "Bonjour,<br><br>" .
        "En fin de ce mail, vous trouverez vos identifiants Uniflow pour les photocopieurs." .
        "<br><br>--------------------------------------------------------------------------------<br><br>" .
        "Hello,<br><br>" .
        "You will find below your Uniflow crendentials for printers<br>." .
        "<br><br><br>" .
        "<b>Login : </b>" . $entry['igmmLoginUniFlow'] .
        "<br> <b>Password : </b>" . $entry['igmmCodeUniFlow'] .
        "</body></html>";
	mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

?>
*/

//TODO: destinataire tester mon email, sujet NOLIST, FROM moi, etc
//mail($destinataire, $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");
/*
$sujet        =  utf8_decode("Date de Contrat nouveau utilisateur");

$codehtml     =
"<html><body>" .
"Bonjour,<br><br>" .
"L'utilisateur" . $entry['displayname'][0] . "vient de créer son compte utilisateur.<br><br>" .
"La date de son contrat se termine le" . $entry['shadowexpire'][0] .
"</body></html>";
mail('XXX@XXX.com', $sujet, $codehtml, "From: $expediteur\r\n". "Reply-To: $reponse\r\n". "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");
