<?php
session_cache_limiter('private');
session_start();

require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

$date_saisie = isset($_REQUEST['date_saisie']) ? $_REQUEST['date_saisie'] : null;
$jour = isset($_REQUEST['jour']) ? $_REQUEST['jour'] : null;

if ($Genre=="-- Indifférent --") {$Genre="%";} 
if ($Espece=="-- Indifférent --") {$Espece="%";}
if ($Genre=="") {$Genre="%";} 
if ($Espece=="") {$Espece="%";}

if (($Genre != "%") && (isset($similitude)))
{ 
$Genre = trim($Genre);
				$findme   = '?';
				$pos = strpos($Genre, $findme);
				
				// utilisation de ===
				// car la lettre 'a' est à la position 0 
				if ($pos === false) 
				{
					$Genre = "%".$Genre."%";
				} 
				else 
				{
					$Genre = substr($Genre, 0, $pos);
					$Genre = $Genre."%";
				}

}

if (($Espece != "%") && (isset($similitude)))
{
$Espece = trim($Espece);
				$findme2   = '?';
				$pos2 = strpos($Espece, $findme2);
				
				// utilisation de ===
				// car la lettre 'a' est à la position 0 
				if ($pos2 === false) 
				{
					$Espece = ereg_replace(" ", "%", $Espece);
					$Espece = ereg_replace("-", "%", $Espece);
					$Espece = "%".$Espece."%";
				} 
				else 
				{
					$Espece = substr($Espece, 0, $pos2);
					$Espece = $Espece."%";
				}
}

if ($Famille=="") {$Famille="%";}
if ($Rang=="") {$Rang=1112;}
if ($LivreRouge=="") {$LivreRouge="%";}
if (!isset($Hybride)) {$Hybride="%";}
if ($Contributeur=="") {$Contributeur="%";}
if ($Commune=="") {$Commune="%";}
if ($NumTaxon=="") {$NumTaxon="%";} 

if ( ($jour != "") && ($mois != "") && ($annee != "") ) {
$date_saisie = $annee."-".$mois."-".$jour;
}

if ($date_saisie == "") {$date_saisie="2005-11-01";}

// Paramètres de pagination  
$nb_par_page = 100;   

/* On détermine quelle est la page qui est actuellement affichée */ 
if (isset($page_en_cours)) {}
else {$page_en_cours = 0;}


/****** compte les résultats *****/ 
 
mysql_select_db($database_PF, $PF);
$sql_nb = "SELECT count(*) FROM pterido, contributions, contributeurs, communes, departements 
WHERE communes.num_departements = departements.num_departements and pterido.NumTaxon = contributions.NumTaxon
and communes.code_insee = contributions.code_insee
and contributeurs.id_contributeurs = contributions.id_contributeurs
and pterido.Famille like '$Famille' and pterido.Genre like '$Genre' and pterido.Espece like '$Espece' and pterido.Rang <= '$Rang' and 
pterido.LivreRouge like '$LivreRouge' and pterido.Hybride like '$Hybride' and pterido.NumTaxon like '$NumTaxon' and contributions.date_saisie >= '$date_saisie' and communes.num_departements like '$dep' and communes.code_insee like '$Commune' and contributeurs.id_contributeurs like '$Contributeur'";
$resultat_count = mysql_query($sql_nb, $PF) or die(mysql_error());
$nb_messages = mysql_result($resultat_count, 0);  


/* Calcul du nombre total de pages : on arrondit à l'entier supérieur (ceil() ) */ 
$nb_pages = ceil($nb_messages / $nb_par_page); 

$debut = $page_en_cours * $nb_par_page;


//********************** cherche les résultats  ***********************

mysql_select_db($database_PF, $PF);
$query_Trouve = "SELECT * FROM pterido, contributions, contributeurs, communes, departements 
WHERE communes.num_departements = departements.num_departements and pterido.NumTaxon = contributions.NumTaxon
and communes.code_insee = contributions.code_insee
and contributeurs.id_contributeurs = contributions.id_contributeurs
and pterido.Famille like '$Famille' and pterido.Genre like '$Genre' and pterido.Espece like '$Espece' and pterido.Rang <= '$Rang' and 
pterido.LivreRouge like '$LivreRouge' and pterido.Hybride like '$Hybride' and pterido.NumTaxon like '$NumTaxon' and contributions.date_saisie >= '$date_saisie' and communes.num_departements like '$dep' and communes.code_insee like '$Commune' and contributeurs.id_contributeurs like '$Contributeur'  
ORDER BY pterido.Genre, pterido.Espece, pterido.SousEspece, pterido.Infra2, pterido.Infra3, communes.num_departements, communes.nom_communes
LIMIT ".$debut.", ". $nb_par_page .";"; 
$Trouve = mysql_query($query_Trouve, $PF) or die(mysql_error());
$row_Trouve = mysql_fetch_assoc($Trouve);
$totalRows_Trouve = mysql_num_rows($Trouve);


entete();?>

<script language="JavaScript">
function supp() 
{
	if (confirm('Voulez-vous vraiment supprimer cette contribution ?'))
	{ return true; }
	else
	{ return false; }
} 
</script> 

<? if ($nb_messages=="0") 
{ ?>
			<p align="center"><br><br><br></p>
			<p align="center"><font color="#663300" face="Arial, Helvetica, sans-serif"><b>Aucune observation ne r&eacute;pond 
			  &agrave; votre recherche</b></font></p>
			<font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
			<p align="center">Vous pouvez entrer qu'une partie du nom de Genre et d'Espece.<br>
  Vous pouvez également entrer le début d'un nom et le faire suivre du signe ? pour remplacer sa fin.</p>
			</font>
<? }
else 
{
?>
				<table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
				<? if ($page_en_cours == 0) {?>
				<tr> 
					<td width="50"></td>
					<td width="600" align="center">
					<? if (isset($_SESSION["authentification"])) {}
								else { echo "<br>"; } ?>
					<font color="#663300" face="Arial, Helvetica, sans-serif" size="-1"><?php if ($nb_messages=="1") {echo ("Seule observation r&eacute;pondant &agrave; votre recherche : ");} else {echo "Les ".$nb_messages." observations suivantes r&eacute;pondent &agrave; votre recherche : ";}?></font><br><br></td>
					<td width="50"></td>
					<td width="30"></td>
				</tr>
				<? } else { 
							if (isset($_SESSION["authentification"])) {}
								else { echo "<br><br>"; }
				          }?>
				</table>
				
				<? //affichage des boutons de navigation ?>
				<table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
				  <tr> 
					<td width="43%" align="right"> 
					  <?php if ($page_en_cours > 0) { ?>
						<form name="back" method="post" action="resultat.php" style="display:inline">
							<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
							<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
							<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
							<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
							<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
							<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
							<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
							<input name="dep" style="display:none" value="<? echo $dep; ?>">
							<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
							<input name="nb_messages" style="display:none" value="<? echo $nb_messages; ?>">
							<input name="page_en_cours" style="display:none" value="<? printf (max(0, $page_en_cours - 1)); ?>">
							<input name="w" style="display:none" value="<? echo $w; ?>">
							<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
							<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
							<input type="image" name="back" src="./images/Previous.gif" alt="Précédents">
						</form>
					  <?php } ?>
					</td>
					<td width="14%" align="center" valign="top"> 
					  <p><font face="Arial, Helvetica, sans-serif" size="-1" color="#185B0D">
						<?php if ($nb_messages>$nb_par_page) 
								{ 
													$first =($debut + 1);
													if($debut + $nb_par_page - 1 < $nb_messages) {
																					$fin = ($debut + $nb_par_page);
																					}
													 else {$fin = $nb_messages;};
								 echo $first." - ".$fin;
								 
							   } 
							   else {echo "";}
					  
					  ?>
					  </font></p>
					  </td>
					<td width="43%" align="left"> 
					  <?php if ($page_en_cours < $nb_pages - 1) {  ?> 
						<form name="next" method="post" action="resultat.php" style="display:inline">
							<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
							<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
							<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
							<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
							<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
							<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
							<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
							<input name="dep" style="display:none" value="<? echo $dep; ?>">
							<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
							<input name="nb_messages" style="display:none" value="<? echo $nb_pages; ?>">
							 <input name="page_en_cours" style="display:none" value="<? printf (min($nb_pages, $page_en_cours + 1)); ?>">
							 <input name="w" style="display:none" value="<? echo $w; ?>">
							 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
							<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
							 <input type="image" name="next" src="./images/Next.gif" alt="Suivants">
						</form>     
					  <?php }  ?>
					</td>
				  </tr>
				</table>
				
				
				<table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
<? //****************************************************** affichage des résultats ******************************************				
				
				//**************** recherche par pterido ***************************
				if ((($Famille != '%') || ($Genre != '') || (Espece != '') || ($Rang != '%') || ($LivreRouge != '%') || ($Hybride != '%')) && (($Contributeur == '%') && ($dep == '%') && ($Commune == '%')))
				{

				$i = 1;
				$tab[1]=$row_Trouve['NumTaxon'];
				
				do {  
					$tab[$i]=$row_Trouve['NumTaxon'];
					if ($i-1 == 0 || $tab[$i-1] != $row_Trouve['NumTaxon']) { // ******* début ?>
				<tr>
					<td ></td>
					<td height="30" align="center" colspan="2"><hr width="650"></td>
					<td></td>
				</tr>
				<tr>
					<td width="50"></td>
					<td width="600" align="left"><font color="#185B0D" face="Arial, Helvetica, sans-serif" size="-1">
					<? calccombinaison($row_Trouve['Rang'],$row_Trouve['Genre'],$row_Trouve['Espece'],$row_Trouve['Auteur'],$row_Trouve['TypeSousEspece'],$row_Trouve['SousEspece'],$row_Trouve['AuteurSousEspece'],$row_Trouve['TypeInfra2'],$row_Trouve['Infra2'],$row_Trouve['AuteurInfra2'],$row_Trouve['TypeInfra3'],$row_Trouve['Infra3'],$row_Trouve['AuteurInfra3']);?>
					 <br><?  echo $row_Trouve['FormuleHybridation']; ?>
					</font></td>
					<td width="50" align="right" valign="middle">
					<? 
					   if ($w != 1) 
						{
						?>
						<form name="carte" method="post" action="UnePterido.php" style="display:inline">
						<INPUT name="carte" type="image" value="carte" src="images/icone_carte.gif" title="voir les cartes">
						<a href="http://photoflora.free.fr/FiTax.php?NumTaxon=<? echo $row_Trouve['NumTaxon'];?>" target="_blank" title="voir les photos du taxon"><img src="images/icone_photos.gif" border="0"></a>
						<input name="NumTaxonPterido" style="display:none" value="<? echo $row_Trouve['NumTaxon']; ?>">
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
	  					</form>
						<? }
					 } $i = $i + 1 ; // ******** fin ?></td>
					<td width="30"></td>
				</tr>	
				<tr>
					<td></td>
					<td width="600" align="left"><br><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<b><? if (strlen($row_Trouve['num_departements']) == 1) { $row_Trouve['num_departements'] = '0'.$row_Trouve['num_departements'];}?><? echo $row_Trouve['num_departements'];?></b>
					 - <b><? echo $row_Trouve['nom_communes'];?></b>
					<? $date = $row_Trouve['date']; 
						echo " le ".substr($date,8)."-".substr($date,5,2)."-".substr($date,0,4); ?>
					<br><? echo " par "; ?><a class="type1" href="mail.php?destinataire=<? echo $row_Trouve['id_contributeurs'];?>" title="envoyer un message à <? echo $row_Trouve['prenom_contributeurs']." ".$row_Trouve['nom_contributeurs'];?>"><? echo $row_Trouve['prenom_contributeurs']." ".$row_Trouve['nom_contributeurs'];?></a>
					<? if ($row_Trouve['commentaire'] != '') {?><br><? echo $row_Trouve['commentaire']; }
					if ($row_Trouve['herbier'] == 1) { echo " - Herbier"; }
					if ($row_Trouve['photo'] == 1) { echo " - Photo"; }
					?>
					</font></td>
					<td width="50" valign="middle" align="right">
					<? if (((isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin') && ($w == 1)) || ((isset($_SESSION['id_contributeurs']) && $_SESSION['id_contributeurs'] == $row_Trouve['id_contributeurs']) && ($w == 1))) 
						{
						?>
						<!-- *************************   modification  ****************************-->
						<form name="form_resultat_modif" method="post" action="UneContrib.php" style="display:inline">
						<input name="id_contributions" style="display:none" value="<? echo $row_Trouve['id_contributions']; ?>">
						<input name="date" style="display:none" value="<? echo $row_Trouve['date']; ?>">
						<input name="depContrib" style="display:none" value="<? echo $row_Trouve['num_departements']; ?>">
						<input name="nom_dep" style="display:none" value="<? echo $row_Trouve['nom_departements']; ?>">
						<input name="CommuneContrib" style="display:none" value="<? echo $row_Trouve['code_insee']; ?>">
						<input name="nom_communes" style="display:none" value="<? echo $row_Trouve['nom_communes']; ?>">
						<input name="n_contributeurs" style="display:none" value="<? echo $row_Trouve['id_contributeurs']; ?>">
						<input name="prenom_contributeurs" style="display:none" value="<? echo $row_Trouve['prenom_contributeurs']; ?>">
						<input name="nom_contributeurs" style="display:none" value="<? echo $row_Trouve['nom_contributeurs']; ?>">
						<input name="NumTaxonContrib" style="display:none" value="<? echo $row_Trouve['NumTaxon']; ?>">
						<input name="commentaires" style="display:none" value="<? echo $row_Trouve['commentaire']; ?>">
	  					
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						 <INPUT name="crayon" type="image" value="crayon" src="images/modifier.gif" alt="modifier">
						</form>
						
						<!-- *************************   suppression  ****************************-->
						<form name="form_resultat_supp" method="post" action="UneContrib.php" onSubmit="return supp()" style="display:inline">
						<INPUT name="croix" type="image" value="croix" src="images/supprimer.gif" alt="supprimer">
						<input name="id_contributions" style="display:none" value="<? echo $row_Trouve['id_contributions']; ?>">
						<input name="d" style="display:none" value="1">
						
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						</form>
						
						<? } ?>
					</td>
					<td></td>
				</tr>
		
				<? } while ($row_Trouve = mysql_fetch_assoc($Trouve)); 
				} // fin du if
				
				
				//**************** recherche par geographie ***************************
				if ((($dep != '%') || ($Commune != '%')) || (($dep != '%') || ($Commune != '%') && ($Contributeur != '%'))) 
				{ ?>
				
				<tr>
					<td width="50"></td>
					<td width="600" align="left"><b><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<? if ($Commune != '%') { echo $row_Trouve['nom_communes']." - ";}?>
					<? echo $row_Trouve['nom_departements']; ?> (<? if (strlen($row_Trouve['num_departements']) == 1) { $row_Trouve['num_departements'] = '0'.$row_Trouve['num_departements'];}?><? echo $row_Trouve['num_departements']; ?>)
					
					</font></b></td>
					<td width="50"></td>
					<td width="30"></td>
				</tr>
				<? 
				$i = 1;
				$tab[1]=$row_Trouve['NumTaxon'];
				
				do {  
					$tab[$i]=$row_Trouve['NumTaxon'];
					if ($tab[$i-1] != $row_Trouve['NumTaxon']) { // ******* début ?>
				<tr>	
					<td></td>
					<td height="30" align="center" colspan="2"><hr width="650"></td>
				
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td align="left"><font color="#185B0D" face="Arial, Helvetica, sans-serif" size="-1">
					<? calccombinaison($row_Trouve['Rang'],$row_Trouve['Genre'],$row_Trouve['Espece'],$row_Trouve['Auteur'],$row_Trouve['TypeSousEspece'],$row_Trouve['SousEspece'],$row_Trouve['AuteurSousEspece'],$row_Trouve['TypeInfra2'],$row_Trouve['Infra2'],$row_Trouve['AuteurInfra2'],$row_Trouve['TypeInfra3'],$row_Trouve['Infra3'],$row_Trouve['AuteurInfra3']);?>
					<br><?  echo $row_Trouve['FormuleHybridation']; ?></font></td>
					<td align="right">
					<?
					if ($w != 1) 
						{
						?>
						<form name="carte" method="post" action="UnePterido.php" style="display:inline">
						<INPUT name="carte" type="image" value="carte" src="images/icone_carte.gif" title="voir les cartes">
						<a href="http://photoflora.free.fr/FiTax.php?NumTaxon=<? echo $row_Trouve['NumTaxon'];?>" target="_blank" title="voir les photos du taxon"><img src="images/icone_photos.gif" border="0"></a>
						<input name="NumTaxonPterido" style="display:none" value="<? echo $row_Trouve['NumTaxon']; ?>">
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
	  					</form>
						<? } 
						
						} $i = $i + 1 ; // ******** fin ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td width="600" align="left"><br><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<? if ($Commune == '%') { ?><b><? echo $row_Trouve['nom_communes']; }?></b>
					<? $date = $row_Trouve['date']; 
						echo "le ".substr($date,8)."-".substr($date,5,2)."-".substr($date,0,4); ?>
					<br><? echo "par "?><a class="type1" href="mail.php?destinataire=<? echo $row_Trouve['id_contributeurs'];?>" title="envoyer un message à <? echo $row_Trouve['prenom_contributeurs']." ".$row_Trouve['nom_contributeurs'];?>"><? echo $row_Trouve['prenom_contributeurs']." ".$row_Trouve['nom_contributeurs'];?></a>
					<? if ($row_Trouve['commentaire'] != '') {?><br><? echo $row_Trouve['commentaire']; }
					   if ($row_Trouve['herbier'] == 1) { echo " - Herbier"; }
					   if ($row_Trouve['photo'] == 1) { echo " - Photo"; }
					?>
					</font></td>
					<td width="50" valign="middle" align="right">
					<? if ((($_SESSION['privilege'] == 'admin') && ($w == 1)) || (($_SESSION['id_contributeurs'] == $row_Trouve['id_contributeurs']) && ($w == 1))) 
						{
						?>
						<!-- *************************   modification  ****************************-->
						<form name="form_resultat_modif" method="post" action="UneContrib.php" style="display:inline">
						<input name="id_contributions" style="display:none" value="<? echo $row_Trouve['id_contributions']; ?>">
						<input name="date" style="display:none" value="<? echo $row_Trouve['date']; ?>">
						<input name="depContrib" style="display:none" value="<? echo $row_Trouve['num_departements']; ?>">
						<input name="nom_dep" style="display:none" value="<? echo $row_Trouve['nom_departements']; ?>">
						<input name="CommuneContrib" style="display:none" value="<? echo $row_Trouve['code_insee']; ?>">
						<input name="nom_communes" style="display:none" value="<? echo $row_Trouve['nom_communes']; ?>">
						<input name="n_contributeurs" style="display:none" value="<? echo $row_Trouve['id_contributeurs']; ?>">
						<input name="prenom_contributeurs" style="display:none" value="<? echo $row_Trouve['prenom_contributeurs']; ?>">
						<input name="nom_contributeurs" style="display:none" value="<? echo $row_Trouve['nom_contributeurs']; ?>">
						<input name="NumTaxonContrib" style="display:none" value="<? echo $row_Trouve['NumTaxon']; ?>">
						<input name="commentaires" style="display:none" value="<? echo $row_Trouve['commentaire']; ?>">
	  					
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						 <INPUT name="crayon" type="image" value="crayon" src="images/modifier.gif" alt="modifier">
						</form>
						
						<!-- *************************   suppression  ****************************-->
						<form name="form_resultat_supp" method="post" action="UneContrib.php" onSubmit="return supp()" style="display:inline">
						<INPUT name="croix" type="image" value="croix" src="images/supprimer.gif" alt="supprimer">
						<input name="id_contributions" style="display:none" value="<? echo $row_Trouve['id_contributions']; ?>">
						<input name="d" style="display:none" value="1">
						
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						</form>
						<? } ?>
					</td>
					<td></td>
				</tr>
				
				<? } while ($row_Trouve = mysql_fetch_assoc($Trouve)); 
				} // fin du if
				
				//**************** recherche par contributeur ***************************
				if (($Contributeur != '%') && ($dep == '%') && ($Commune == '%'))
				{ ?>
				
				<tr>
					<td width="50"></td>
					<td width="600" align="left"><b><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<a class="type1" href="mail.php?destinataire=<? echo $row_Trouve['id_contributeurs'];?>" title="envoyer un message à <? echo $row_Trouve['prenom_contributeurs']." ".$row_Trouve['nom_contributeurs'];?>"><? echo $row_Trouve['prenom_contributeurs']." ".$row_Trouve['nom_contributeurs']; ?></a>
					
					</font></b></td>
					<td width="50"></td>
					<td width="30"></td>
				</tr>
				<? 
				$i = 1;
				$tab[1]=$row_Trouve['NumTaxon'];
				
				do {  
					$tab[$i]=$row_Trouve['NumTaxon'];
					if ($tab[$i-1] != $row_Trouve['NumTaxon']) { // ******* début ?>
				<tr>
					<td></td>
					<td height="30" align="center" colspan="2"><hr width="650"></td>
				
					<td></td>
				</tr>
					
				<tr>
					<td></td>
					<td align="left"><font color="#185B0D" face="Arial, Helvetica, sans-serif" size="-1">
					<? calccombinaison($row_Trouve['Rang'],$row_Trouve['Genre'],$row_Trouve['Espece'],$row_Trouve['Auteur'],$row_Trouve['TypeSousEspece'],$row_Trouve['SousEspece'],$row_Trouve['AuteurSousEspece'],$row_Trouve['TypeInfra2'],$row_Trouve['Infra2'],$row_Trouve['AuteurInfra2'],$row_Trouve['TypeInfra3'],$row_Trouve['Infra3'],$row_Trouve['AuteurInfra3']);?>
					<br><?  echo $row_Trouve['FormuleHybridation']; ?></font></td>
					<td align="right">
					<? if ($w != 1) 
						{
						?>
						<form name="carte" method="post" action="UnePterido.php" style="display:inline">
						<INPUT name="carte" type="image" value="carte" src="images/icone_carte.gif" title="voir les cartes">
						<a href="http://photoflora.free.fr/FiTax.php?NumTaxon=<? echo $row_Trouve['NumTaxon'];?>" target="_blank" title="voir les photos du taxon"><img src="images/icone_photos.gif" border="0"></a>
						<input name="NumTaxonPterido" style="display:none" value="<? echo $row_Trouve['NumTaxon']; ?>">
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
	  					</form>
						<? } 
					
						} $i = $i + 1 ; // ******** fin ?>
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td width="600" align="left"><br><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<b><? if (strlen($row_Trouve['num_departements']) == 1) { $row_Trouve['num_departements'] = '0'.$row_Trouve['num_departements'];}?><? echo $row_Trouve['num_departements'];?></b>
					 - <b><? echo $row_Trouve['nom_communes'];?></b>
					<? $date = $row_Trouve['date']; 
						echo " le ".substr($date,8)."-".substr($date,5,2)."-".substr($date,0,4); ?>
					<? if ($row_Trouve['commentaire'] != '') {?><br><? echo $row_Trouve['commentaire']; }
					   if ($row_Trouve['herbier'] == 1) { echo " - Herbier"; }
					   if ($row_Trouve['photo'] == 1) { echo " - Photo"; }
					?>
					</font></td>
					<td width="50" valign="middle" align="right">
					<? if ((($_SESSION['privilege'] == 'admin') && ($w == 1)) || (($_SESSION['id_contributeurs'] == $row_Trouve['id_contributeurs']) && ($w == 1)))  
						{
						?>
						<!-- *************************   modification  ****************************-->
						<form name="form_resultat_modif" method="post" action="UneContrib.php" style="display:inline">
						<input name="id_contributions" style="display:none" value="<? echo $row_Trouve['id_contributions']; ?>">
						<input name="date" style="display:none" value="<? echo $row_Trouve['date']; ?>">
						<input name="depContrib" style="display:none" value="<? echo $row_Trouve['num_departements']; ?>">
						<input name="nom_dep" style="display:none" value="<? echo $row_Trouve['nom_departements']; ?>">
						<input name="CommuneContrib" style="display:none" value="<? echo $row_Trouve['code_insee']; ?>">
						<input name="nom_communes" style="display:none" value="<? echo $row_Trouve['nom_communes']; ?>">
						<input name="n_contributeurs" style="display:none" value="<? echo $row_Trouve['id_contributeurs']; ?>">
						<input name="prenom_contributeurs" style="display:none" value="<? echo $row_Trouve['prenom_contributeurs']; ?>">
						<input name="nom_contributeurs" style="display:none" value="<? echo $row_Trouve['nom_contributeurs']; ?>">
						<input name="NumTaxonContrib" style="display:none" value="<? echo $row_Trouve['NumTaxon']; ?>">
						<input name="commentaires" style="display:none" value="<? echo $row_Trouve['commentaire']; ?>">
	  					
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						 <INPUT name="crayon" type="image" value="crayon" src="images/modifier.gif" alt="modifier">
						</form>
						
						<!-- *************************   suppression  ****************************-->
						<form name="form_resultat_supp" method="post" action="UneContrib.php" onSubmit="return supp()" style="display:inline">
						<INPUT name="croix" type="image" value="croix" src="images/supprimer.gif" alt="supprimer">
						<input name="id_contributions" style="display:none" value="<? echo $row_Trouve['id_contributions']; ?>">
						<input name="d" style="display:none" value="1">
						
						<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
						<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
						<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
						<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
						<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
						<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
						<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
						<input name="dep" style="display:none" value="<? echo $dep; ?>">
						<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
						 <input name="page_en_cours" style="display:none" value="<? echo $page_en_cours; ?>">
						 <input name="w" style="display:none" value="<? echo $w; ?>">
						 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
						<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
						</form>
						<? }
						?>
					</td>
					<td></td>
				</tr>
				
				<? } while ($row_Trouve = mysql_fetch_assoc($Trouve)); 
				} // fin du if
//**************************************************************************************************************************?>				
				</table>
<? } ?>
<br>
<br>

<table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> 
    <td width="43%" align="right"> 
      <?php if ($page_en_cours > 0) { ?>
		<form name="back" method="post" action="resultat.php">
			<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
			<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
			<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
			<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
			<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
			<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
			<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
			<input name="dep" style="display:none" value="<? echo $dep; ?>">
			<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
			<input name="nb_messages" style="display:none" value="<? echo $nb_messages; ?>">
			<input name="page_en_cours" style="display:none" value="<? printf (max(0, $page_en_cours - 1)); ?>">
			<input name="w" style="display:none" value="<? echo $w; ?>">
			<input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
			<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
			<input type="image" name="back" src="./images/Previous.gif" alt="Précédents">
		</form>
      <?php } ?>
    </td>
    <td width="14%" align="center" valign="top"> 
      <p><font face="Arial, Helvetica, sans-serif" size="-1" color="#185B0D">
        <?php if ($nb_messages>$nb_par_page) 
				{ 
									$first =($debut + 1);
	  								if($debut + $nb_par_page - 1 < $nb_messages) {
	  																$fin = ($debut + $nb_par_page);
	  																}
								     else {$fin = $nb_messages;};
      		  	 echo $first." - ".$fin;
				 
               } 
	           else {echo "";}
	  
	  ?>
      </font></p>
      </td>
	<td width="43%" align="left"> 
      <?php if ($page_en_cours < $nb_pages - 1) {  ?> 
		<form name="next" method="post" action="resultat.php">
			<input name="Famille" style="display:none" value="<? echo $Famille; ?>">
			<input name="Genre" style="display:none" value="<? echo $Genre; ?>">
			<input name="Espece" style="display:none" value="<? echo $Espece; ?>">
			<input name="Rang" style="display:none" value="<? echo $Rang; ?>">
			<input name="LivreRouge" style="display:none" value="<? echo $LivreRouge; ?>">
			<input name="Hybride" style="display:none" value="<? echo $Hybride; ?>">
			<input name="Contributeur" style="display:none" value="<? echo $Contributeur; ?>">
			<input name="dep" style="display:none" value="<? echo $dep; ?>">
			<input name="Commune" style="display:none" value="<? echo $Commune; ?>">
			<input name="nb_messages" style="display:none" value="<? echo $nb_pages; ?>">
			 <input name="page_en_cours" style="display:none" value="<? printf (min($nb_pages, $page_en_cours + 1)); ?>">
			 <input name="w" style="display:none" value="<? echo $w; ?>">
			 <input name="NumTaxon" style="display:none" value="<? echo $NumTaxon; ?>">
			<input name="date_saisie" style="display:none" value="<? echo $date_saisie; ?>">
			 <input type="image" name="next" src="./images/Next.gif" alt="Suivants">
		</form>     
      <?php } 
mysql_free_result($Trouve);
mysql_free_result($resultat_count);
	  ?>
    </td>
  </tr>
</table>

<table width="680" border="0" align="center" cellpadding="10">
  <tr> 
	<td width="580" align="left">
      <form>
  		<INPUT TYPE="button" NAME="Rechercher" value="<? if ($w == 1) { echo " <<  Autre modification " ;} else { echo " <<  Autre recherche "; } ?>" <? if ($w == 1) { ?>onClick="document.location.href='./rechercher.php?w=<? echo $w; ?>'"><? } else { ?>onClick="document.location.href='./rechercher.php'"><? }?>
	  </form>
	  </td>
  </tr>
</table>
<br>
<? pied();?>


