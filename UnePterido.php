<?
require './scripts/MesFonctions.php';
require_once('./scripts/PF.php');

mysql_select_db($database_PF, $PF);
$query_Trouve = "SELECT * FROM pterido where NumTaxon = '$NumTaxonPterido'";
$Trouve = mysql_query($query_Trouve, $PF) or die(mysql_error());
$row_Trouve = mysql_fetch_assoc($Trouve);
$totalRows_Trouve = mysql_num_rows($Trouve);

mysql_select_db($database_PF, $PF);
$query_RechercherCommune = "SELECT count(distinct code_insee) FROM contributions where NumTaxon = '$NumTaxonPterido'";
$RechercherCommune = mysql_query($query_RechercherCommune, $PF) or die(mysql_error());
$row_RechercherCommune = mysql_fetch_assoc($RechercherCommune);
$totalRows_RechercherCommune = mysql_num_rows($RechercherCommune);

entete();
?>
<style>
A.type1:link {color:#663300; text-decoration:none;}
A.type1:visited {color:#663300; text-decoration:none;}
A.type1:active {color:#663300; text-decoration:none;}
A.type1:hover {color:#663300; text-decoration:underline;}
</style>
<br>
<table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td></td>
					<td align="left">
					<form name="retour" method="post" action="resultat.php">
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
						<INPUT name="retour" type="submit" value="<<  Retour à la liste ">
	  					</form>
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td align="center" height="30"><font color="#185B0D" face="Arial, Helvetica, sans-serif" size="-1">
					<? echo $row_Trouve['NumTaxon']; ?> - <? calccombinaison($row_Trouve['Rang'],$row_Trouve['Genre'],$row_Trouve['Espece'],$row_Trouve['Auteur'],$row_Trouve['TypeSousEspece'],$row_Trouve['SousEspece'],$row_Trouve['AuteurSousEspece'],$row_Trouve['TypeInfra2'],$row_Trouve['Infra2'],$row_Trouve['AuteurInfra2'],$row_Trouve['TypeInfra3'],$row_Trouve['Infra3'],$row_Trouve['AuteurInfra3']);?>
					 <br><?  echo $row_Trouve['FormuleHybridation']; ?>
					</font></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td height="20" align="center"><hr width="620"></td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td align="left"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<br><u>Répartition géographique</u> : </font>
					<font color="#663300" face="Arial, Helvetica, sans-serif" size="-2">Cliquez sur le n° du département pour voir les observations de ce taxon.</font>
					<br><br>
					</td>
					<td></td>
				</tr>
				<tr>
					<td width="50"></td>
					<td align="center">
				<!--
				<iframe vspace="0" hspace="0" marginwidth="0" marginheight="0" name="icarte" height="420" width="410" style="background-color:#E4CA8B" frameborder="0" scrolling="no" src="./carte.php?NumTaxon=???"></iframe>
				-->
					<img src="images/espace.gif" border="0">
					<img src="carte.php?NumTaxon=<? echo $NumTaxonPterido;?>" border="0" usemap="#Map">
					<map name="Map">
						<!-- 01 --><area shape="circle" coords="307,223,6" href="resultat.php?dep=1&NumTaxon=<? echo $NumTaxonPterido;?>" title="Ain">
						<!-- 02 --><area shape="circle" coords="251,63,6" href="resultat.php?dep=2&NumTaxon=<? echo $NumTaxonPterido;?>" title="Aisne">
						<!-- 03 --><area shape="circle" coords="238,209,6" href="resultat.php?dep=3&NumTaxon=<? echo $NumTaxonPterido;?>" title="Allier">
						<!-- 04 --><area shape="circle" coords="337,312,6" href="resultat.php?dep=4&NumTaxon=<? echo $NumTaxonPterido;?>" title="Alpes-de-Haute-Provence">
						<!-- 05 --><area shape="circle" coords="338,285,6" href="resultat.php?dep=5&NumTaxon=<? echo $NumTaxonPterido;?>" title="Hautes-Alpes">
						<!-- 06 --><area shape="circle" coords="370,314,6" href="resultat.php?dep=6&NumTaxon=<? echo $NumTaxonPterido;?>" title="Alpes-Maritimes">
						<!-- 07 --><area shape="circle" coords="279,287,6" href="resultat.php?dep=7&NumTaxon=<? echo $NumTaxonPterido;?>" title="Ardèche">
						<!-- 08 --><area shape="circle" coords="281,67,6" href="resultat.php?dep=8&NumTaxon=<? echo $NumTaxonPterido;?>" title="Ardennes">
						<!-- 09 --><area shape="circle" coords="187,363,6" href="resultat.php?dep=9&NumTaxon=<? echo $NumTaxonPterido;?>" title="Ariège">
						<!-- 10 --><area shape="circle" coords="267,128,6" href="resultat.php?dep=10&NumTaxon=<? echo $NumTaxonPterido;?>" title="Aube">
						<!-- 11 --><area shape="circle" coords="217,355,6" href="resultat.php?dep=11&NumTaxon=<? echo $NumTaxonPterido;?>" title="Aude">
						<!-- 12 --><area shape="circle" coords="224,304,6" href="resultat.php?dep=12&NumTaxon=<? echo $NumTaxonPterido;?>" title="Aveyron">
						<!-- 13 --><area shape="circle" coords="303,336,6" href="resultat.php?dep=13&NumTaxon=<? echo $NumTaxonPterido;?>" title="Bouches-du-Rhône">
						<!-- 14 --><area shape="circle" coords="135,92,6" href="resultat.php?dep=14&NumTaxon=<? echo $NumTaxonPterido;?>" title="Calvados">
						<!-- 15 --><area shape="circle" coords="225,268,6" href="resultat.php?dep=15&NumTaxon=<? echo $NumTaxonPterido;?>" title="Cantal">
						<!-- 16 --><area shape="circle" coords="151,237,6" href="resultat.php?dep=16&NumTaxon=<? echo $NumTaxonPterido;?>" title="Charente">
						<!-- 17 --><area shape="circle" coords="122,235,6" href="resultat.php?dep=17&NumTaxon=<? echo $NumTaxonPterido;?>" title="Charente-Maritime">
						<!-- 18 --><area shape="circle" coords="221,181,6" href="resultat.php?dep=18&NumTaxon=<? echo $NumTaxonPterido;?>" title="Cher">
						<!-- 19 --><area shape="circle" coords="198,258,6" href="resultat.php?dep=19&NumTaxon=<? echo $NumTaxonPterido;?>" title="Corrèze">
						<!-- 20 --><area shape="circle" coords="386,379,6" href="resultat.php?dep=20&NumTaxon=<? echo $NumTaxonPterido;?>" title="Corse">
						<!-- 21 --><area shape="circle" coords="288,165,6" href="resultat.php?dep=21&NumTaxon=<? echo $NumTaxonPterido;?>" title="Côte-d'Or">
						<!-- 22 --><area shape="circle" coords="57,117,6" href="resultat.php?dep=22&NumTaxon=<? echo $NumTaxonPterido;?>" title="Côtes-d'Armor">
						<!-- 23 --><area shape="circle" coords="204,225,6" href="resultat.php?dep=23&NumTaxon=<? echo $NumTaxonPterido;?>" title="Creuse">
						<!-- 24 --><area shape="circle" coords="167,270,6" href="resultat.php?dep=24&NumTaxon=<? echo $NumTaxonPterido;?>" title="Dordogne">
						<!-- 25 --><area shape="circle" coords="335,176,6" href="resultat.php?dep=25&NumTaxon=<? echo $NumTaxonPterido;?>" title="Doubs">
						<!-- 26 --><area shape="circle" coords="305,287,6" href="resultat.php?dep=26&NumTaxon=<? echo $NumTaxonPterido;?>" title="Drôme">
						<!-- 27 --><area shape="circle" coords="176,94,6" href="resultat.php?dep=27&NumTaxon=<? echo $NumTaxonPterido;?>" title="Eure">
						<!-- 28 --><area shape="circle" coords="187,124,6" href="resultat.php?dep=28&NumTaxon=<? echo $NumTaxonPterido;?>" title="Eure-et-Loir">
						<!-- 29 --><area shape="circle" coords="28,117,6" href="resultat.php?dep=29&NumTaxon=<? echo $NumTaxonPterido;?>" title="Finistère">
						<!-- 30 --><area shape="circle" coords="275,316,6" href="resultat.php?dep=30&NumTaxon=<? echo $NumTaxonPterido;?>" title="Gard">
						<!-- 31 --><area shape="circle" coords="186,339,6" href="resultat.php?dep=31&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haute-Garonne">
						<!-- 32 --><area shape="circle" coords="154,330,6" href="resultat.php?dep=32&NumTaxon=<? echo $NumTaxonPterido;?>" title="Gers">
						<!-- 33 --><area shape="circle" coords="126,280,6" href="resultat.php?dep=33&NumTaxon=<? echo $NumTaxonPterido;?>" title="Gironde">
						<!-- 34 --><area shape="circle" coords="250,335,6" href="resultat.php?dep=34&NumTaxon=<? echo $NumTaxonPterido;?>" title="Hérault">
						<!-- 35 --><area shape="circle" coords="98,128,6" href="resultat.php?dep=35&NumTaxon=<? echo $NumTaxonPterido;?>" title="Ille-et-Vilaine">
						<!-- 36 --><area shape="circle" coords="194,192,6" href="resultat.php?dep=36&NumTaxon=<? echo $NumTaxonPterido;?>" title="Indre">
						<!-- 37 --><area shape="circle" coords="165,171,6" href="resultat.php?dep=37&NumTaxon=<? echo $NumTaxonPterido;?>" title="Indre-et-Loire">
						<!-- 38 --><area shape="circle" coords="315,255,6" href="resultat.php?dep=38&NumTaxon=<? echo $NumTaxonPterido;?>" title="Isère">
						<!-- 39 --><area shape="circle" coords="319,196,6" href="resultat.php?dep=39&NumTaxon=<? echo $NumTaxonPterido;?>" title="Jura">
						<!-- 40 --><area shape="circle" coords="119,317,6" href="resultat.php?dep=40&NumTaxon=<? echo $NumTaxonPterido;?>" title="Landes">
						<!-- 41 --><area shape="circle" coords="189,159,6" href="resultat.php?dep=41&NumTaxon=<? echo $NumTaxonPterido;?>" title="Loir-et-Cher">
						<!-- 42 --><area shape="circle" coords="268,236,6" href="resultat.php?dep=42&NumTaxon=<? echo $NumTaxonPterido;?>" title="Loire">
						<!-- 43 --><area shape="circle" coords="263,267,6" href="resultat.php?dep=43&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haute-Loire">
						<!-- 44 --><area shape="circle" coords="100,163,6" href="resultat.php?dep=44&NumTaxon=<? echo $NumTaxonPterido;?>" title="Loire-Atlantique">
						<!-- 45 --><area shape="circle" coords="217,144,6" href="resultat.php?dep=45&NumTaxon=<? echo $NumTaxonPterido;?>" title="Loiret">
						<!-- 46 --><area shape="circle" coords="192,287,6" href="resultat.php?dep=46&NumTaxon=<? echo $NumTaxonPterido;?>" title="Lot">
						<!-- 47 --><area shape="circle" coords="157,302,6" href="resultat.php?dep=47&NumTaxon=<? echo $NumTaxonPterido;?>" title="Lot-et-Garonne">
						<!-- 48 --><area shape="circle" coords="254,294,6" href="resultat.php?dep=48&NumTaxon=<? echo $NumTaxonPterido;?>" title="Lozère">
						<!-- 49 --><area shape="circle" coords="133,165,6" href="resultat.php?dep=49&NumTaxon=<? echo $NumTaxonPterido;?>" title="Maine-et-Loire">
						<!-- 50 --><area shape="circle" coords="109,88,6" href="resultat.php?dep=50&NumTaxon=<? echo $NumTaxonPterido;?>" title="Manche">
						<!-- 51 --><area shape="circle" coords="271,97,6" href="resultat.php?dep=51&NumTaxon=<? echo $NumTaxonPterido;?>" title="Marne">
						<!-- 52 --><area shape="circle" coords="303,132,6" href="resultat.php?dep=52&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haute-Marne">
						<!-- 53 --><area shape="circle" coords="128,132,6" href="resultat.php?dep=53&NumTaxon=<? echo $NumTaxonPterido;?>" title="Mayenne">
						<!-- 54 --><area shape="circle" coords="330,110,6" href="resultat.php?dep=54&NumTaxon=<? echo $NumTaxonPterido;?>" title="Meurthe-et-Moselle">
						<!-- 55 --><area shape="circle" coords="305,96,6" href="resultat.php?dep=55&NumTaxon=<? echo $NumTaxonPterido;?>" title="Meuse">
						<!-- 56 --><area shape="circle" coords="62,143,6" href="resultat.php?dep=56&NumTaxon=<? echo $NumTaxonPterido;?>" title="Morbihan">
						<!-- 57 --><area shape="circle" coords="344,93,6" href="resultat.php?dep=57&NumTaxon=<? echo $NumTaxonPterido;?>" title="Moselle">
						<!-- 58 --><area shape="circle" coords="250,177,6" href="resultat.php?dep=58&NumTaxon=<? echo $NumTaxonPterido;?>" title="Nièvre">
						<!-- 59 --><area shape="circle" coords="251,41,6" href="resultat.php?dep=59&NumTaxon=<? echo $NumTaxonPterido;?>" title="Nord">
						<!-- 60 --><area shape="circle" coords="218,76,6" href="resultat.php?dep=60&NumTaxon=<? echo $NumTaxonPterido;?>" title="Oise">
						<!-- 61 --><area shape="circle" coords="152,108,6" href="resultat.php?dep=61&NumTaxon=<? echo $NumTaxonPterido;?>" title="Orne">
						<!-- 62 --><area shape="circle" coords="214,32,6" href="resultat.php?dep=62&NumTaxon=<? echo $NumTaxonPterido;?>" title="Pas-de-Calais">
						<!-- 63 --><area shape="circle" coords="240,240,6" href="resultat.php?dep=63&NumTaxon=<? echo $NumTaxonPterido;?>" title="Puy-de-Dôme">
						<!-- 64 --><area shape="circle" coords="115,349,6" href="resultat.php?dep=64&NumTaxon=<? echo $NumTaxonPterido;?>" title="Pyrénées-Atlantiques">
						<!-- 65 --><area shape="circle" coords="142,357,6" href="resultat.php?dep=65&NumTaxon=<? echo $NumTaxonPterido;?>" title="Hautes-Pyrénées">
						<!-- 66 --><area shape="circle" coords="222,378,6" href="resultat.php?dep=66&NumTaxon=<? echo $NumTaxonPterido;?>" title="Pyrénées-Orientales">
						<!-- 67 --><area shape="circle" coords="370,104,6" href="resultat.php?dep=67&NumTaxon=<? echo $NumTaxonPterido;?>" title="Bas-Rhin">
						<!-- 68 --><area shape="circle" coords="362,141,6" href="resultat.php?dep=68&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haut-Rhin">
						<!-- 69 --><area shape="circle" coords="286,236,6" href="resultat.php?dep=69&NumTaxon=<? echo $NumTaxonPterido;?>" title="Rhône">
						<!-- 70 --><area shape="circle" coords="329,153,6" href="resultat.php?dep=70&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haute-Saône">
						<!-- 71 --><area shape="circle" coords="282,197,6" href="resultat.php?dep=71&NumTaxon=<? echo $NumTaxonPterido;?>" title="Saône-et-Loire">
						<!-- 72 --><area shape="circle" coords="154,139,6" href="resultat.php?dep=72&NumTaxon=<? echo $NumTaxonPterido;?>" title="Sarthe">
						<!-- 73 --><area shape="circle" coords="347,250,6" href="resultat.php?dep=73&NumTaxon=<? echo $NumTaxonPterido;?>" title="Savoie">
						<!-- 74 --><area shape="circle" coords="345,222,6" href="resultat.php?dep=74&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haute-Savoie">
						<!-- 75 --><area shape="circle" coords="325,19,6" href="resultat.php?dep=75&NumTaxon=<? echo $NumTaxonPterido;?>" title="Paris">
						<!-- 76 --><area shape="circle" coords="176,66,6" href="resultat.php?dep=76&NumTaxon=<? echo $NumTaxonPterido;?>" title="Seine-Maritime">
						<!-- 77 --><area shape="circle" coords="234,112,6" href="resultat.php?dep=77&NumTaxon=<? echo $NumTaxonPterido;?>" title="Seine-et-Marne">
						<!-- 78 --><area shape="circle" coords="200,103,6" href="resultat.php?dep=78&NumTaxon=<? echo $NumTaxonPterido;?>" title="Yvelines">
						<!-- 79 --><area shape="circle" coords="134,200,6" href="resultat.php?dep=79&NumTaxon=<? echo $NumTaxonPterido;?>" title="Deux-Sèvres">
						<!-- 80 --><area shape="circle" coords="214,56,6" href="resultat.php?dep=80&NumTaxon=<? echo $NumTaxonPterido;?>" title="Somme">
						<!-- 81 --><area shape="circle" coords="207,35,6" href="resultat.php?dep=81&NumTaxon=<? echo $NumTaxonPterido;?>" title="Tarn">
						<!-- 82 --><area shape="circle" coords="178,314,6" href="resultat.php?dep=82&NumTaxon=<? echo $NumTaxonPterido;?>" title="Tarn-et-Garonne">
						<!-- 83 --><area shape="circle" coords="339,338,6" href="resultat.php?dep=83&NumTaxon=<? echo $NumTaxonPterido;?>" title="Var">
						<!-- 84 --><area shape="circle" coords="305,313,6" href="resultat.php?dep=84&NumTaxon=<? echo $NumTaxonPterido;?>" title="Vaucluse">
						<!-- 85 --><area shape="circle" coords="106,197,6" href="resultat.php?dep=85&NumTaxon=<? echo $NumTaxonPterido;?>" title="Vendée">
						<!-- 86 --><area shape="circle" coords="162,203,6" href="resultat.php?dep=86&NumTaxon=<? echo $NumTaxonPterido;?>" title="Vienne">
						<!-- 87 --><area shape="circle" coords="180,237,6" href="resultat.php?dep=87&NumTaxon=<? echo $NumTaxonPterido;?>" title="Haute-Vienne">
						<!-- 88 --><area shape="circle" coords="337,130,6" href="resultat.php?dep=88&NumTaxon=<? echo $NumTaxonPterido;?>" title="Vosges">
						<!-- 89 --><area shape="circle" coords="253,148,6" href="resultat.php?dep=89&NumTaxon=<? echo $NumTaxonPterido;?>" title="Yonne">
						<!-- 90 --><area shape="circle" coords="351,154,6" href="resultat.php?dep=90&NumTaxon=<? echo $NumTaxonPterido;?>" title="Territoire de Belfort">
						<!-- 91 --><area shape="circle" coords="212,120,6" href="resultat.php?dep=91&NumTaxon=<? echo $NumTaxonPterido;?>" title="Essone">
						<!-- 92 --><area shape="circle" coords="310,16,6" href="resultat.php?dep=92&NumTaxon=<? echo $NumTaxonPterido;?>" title="Hauts-de-Seine">
						<!-- 93 --><area shape="circle" coords="341,12,6" href="resultat.php?dep=93&NumTaxon=<? echo $NumTaxonPterido;?>" title="Seine-Saint-Denis">
						<!-- 94 --><area shape="circle" coords="337,29,6" href="resultat.php?dep=94&NumTaxon=<? echo $NumTaxonPterido;?>" title="Val-de-Marne">
						<!-- 95 --><area shape="circle" coords="214,94,6" href="resultat.php?dep=95&NumTaxon=<? echo $NumTaxonPterido;?>" title="Val-d'Oise">
					</map> 
					</td>
					<td width="50"></td>
				</tr>
				<tr>
					<td width="50"></td>
					<td align="center">
												<table border="0" cellpadding="0" cellspacing="0">
												<tr> 
												  <td width="30" height="3"></td>
												  <td width="30" height="3"></td>
												  <td width="30" height="3"></td>
												  <td width="160" rowspan="3" align="center" valign="middle"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">&nbsp;Nombres 
													d'observations </font></td>
												</tr>
												<tr> 
												  <td width="20" height="3" bgcolor="#c9f5b4"></td>
												  <td width="20" height="3" bgcolor="#7bcd5d"></td>
												  <td width="20" height="3" bgcolor="#185B0D"></td>
												</tr>
												<tr> 
												  <td width="20" height="3"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-2">0</font></td>
												  <td width="20" height="3"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-2">5</font></td>
												  <td width="20" height="3"><font color="#663300" face="Arial, Helvetica, sans-serif" size="-2">15</font></td>
												</tr>
											  </table>
					</td>
					<td width="50"></td>
				</tr>
				<? if ($row_Trouve['ProtectionNationale'] != '') {?>
				<tr>
					<td></td>
					<td align="left">
					<font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<br>Protégé en : <? echo $row_Trouve['ProtectionNationale']; ?></font><br><br>
					</td>
					<td></td>
				</tr>
				<? }?>
				
				<tr>
					<td></td>
					<td align="left" height="20">
					<font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">
					<br>Mentionné dans <? echo $row_RechercherCommune['count(distinct code_insee)']; ?> <? if ( $row_RechercherCommune['count(distinct code_insee)'] == 1) { echo "commune : "; } else { echo "communes : "; } ?></font>
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td align="center">
					<img src="wgs84.php?NumTaxon=<? echo $NumTaxonPterido;?>" border="0">
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td align="center">
											<table border="0" cellpadding="0" cellspacing="0">
												<tr> 
												  <td><img src="images/station.gif" border="0"></td>
												  <td><font color="#663300" face="Arial, Helvetica, sans-serif" size="-1">Commune où le taxon est présent<br></font></td>
												</tr>
											  </table>
					
			
					</td>
					<td></td>
				</tr>
</table>
<br>
<br>

<?
pied();
mysql_free_result($Trouve);
mysql_free_result($RechercherCommune);
//mysql_free_result($Trouve2);
?>