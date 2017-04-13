<?php
// ceci est la page d'accueil
require_once('./scripts/PF.php');
require './scripts/MesFonctions.php';

// nbr d'inscrits et nbr d'observations
mysql_select_db($database_PF, $PF);
$query_Inscrits = "SELECT count(*) from contributeurs"; 
$Inscrits = mysql_query($query_Inscrits, $PF) or die(mysql_error());
$row_Inscrits = mysql_fetch_assoc($Inscrits);
$totalRows_Inscrits = mysql_num_rows($Inscrits);

mysql_select_db($database_PF, $PF);
$query_Contribs = "SELECT count(*) from contributions"; 
$Contribs = mysql_query($query_Contribs, $PF) or die(mysql_error());
$row_Contribs = mysql_fetch_assoc($Contribs);
$totalRows_Contribs = mysql_num_rows($Contribs);

entete();
?>

<table width="750" align="center" style='text-align:justify;'>
   <tr>
   <td height="100" colspan="3" align="center"><font color="#663300" face="Arial, Helvetica, sans-serif"><b>Bienvenue sur le site du projet d'actualisation de la cartographie des Ptéridophytes</b></font></td>
   </tr>

	<tr>
		<td width="50"></td>
		<td width="700" align="justify"><p><img src="./images/fleche.jpg">&nbsp; 
        <font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"> <b><u><em>DESCRIPTION</em></u></b><br>
        <br>
        Ce projet a pour but de réactualiser, avec un point de départ au 1er janvier 
        2000, les cartes de répartition présentées dans l'ouvrage de R. Prelli 
        & M. Boudrie " Les fougères et plantes alliées de France et d'Europe occidentale" 
        (éditions Belin, 2001), cartes qui sont actuellement basées sur un état 
        datant du 1er janvier 1980.</font><font color="#663300" size="-1" face="Arial, Helvetica, sans-serif"><br>
        voir r&eacute;sum&eacute; sur <a href="http://www.tela-botanica.org/papyrus.php?site=3&id_projet=12&act=resume" target="_blank"> 
        Tela Botanica</a></font></p>
      <p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Pour 
        voir les observations d&eacute;j&agrave; saisies et les cartes de r&eacute;partition 
        qui en r&eacute;sultent, rendez-vous dans la rubrique &quot;Rechercher&quot;.<br>
        <br>
        De nombreux départements ne sont pas encore couverts et nous recherchons 
        des collaborateurs pour poursuivre ce travail.<br>
        <br>
        <br>
        <img src="./images/fleche.jpg">&nbsp;<b><u><em>COMMENT CONTRIBUER</em></u> ?</b><br>
        <br>
        </font> <font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Après 
        inscription sur ce site, vous pouvez ajouter vos observations, par commune, 
        directement dans la base de données. Pour cela rendez-vous dans la rubrique 
        "Ajouter".</font></p>
      <p><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Pour 
        ceux qui poss&egrave;dent de nombreuses donn&eacute;es, ils peuvent <a href="mailto:pterido@free.fr">envoyer 
        leur tableau</a> (Excel par exemple) avec les 4 rubriques suivantes : 
        n&deg; du taxon / Date / n&deg;INSEE de la commune / <em>Commentaire (facultatif</em>). 
        Pour pr&eacute;parer un tableau compatible, ils peuvent t&eacute;l&eacute;charger 
        les codes (n&deg; taxon et n&deg;INSEE des communes) dont ils ont besoin 
        <a href="http://www.tela-botanica.org/projets-12?act=documents" target="_blank">ici</a><br>
        </font></p>
      <p><font color="#663300" size="-1" face="Arial, Helvetica, sans-serif">
	  Nous comptons sur vous.
	  <br><br>
	  <em><? echo "Actuellement dans la base : ".$row_Inscrits['count(*)']." contributeurs, ".$row_Contribs['count(*)']." observations"?></em>
	  </font></p>
      <p>&nbsp;</p>
      <br>
		
		
		<noscript>
		<p align="center"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Le Javascript est nécessaire pour utiliser ce site web:<br></font>
		<b><font color="#CC0000" face="Arial, Helvetica, sans-serif" size="+1">
		Javascript n'est pas en fonctionnement sur votre logiciel de navigation.<br>Vous devez l'activer pour utiliser ce site web!
		</font></b><br>
		</p>
		</noscript>

		
		</td>
	</tr>
</table>
<br>
<?
mysql_free_result($Inscrits);
mysql_free_result($Contribs);
pied();
?>



