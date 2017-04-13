<?php
//***********************************************************************************************
//       fonction afficherdate() permet d'afficher la date en franÁais
//***********************************************************************************************
function afficherdate()
{
$jouranglais=date("D");

switch ($jouranglais)
{case "Sat":
$jour = "Samedi";
break;
case "Sun":
$jour = "Dimanche";
break;
case "Mon":
$jour = "Lundi";
break;
case "Tue":
$jour = "Mardi";
break;
case "Wed":
$jour = "Mercredi";
break;
case "Thu":
$jour = "Jeudi";
break;
case "Fri":
$jour = "Vendredi";
break;}
$moisenchiffre=date("m");
switch ($moisenchiffre)
{case "01":
$mois = "Janvier";
break;
case "02":
$mois = "F&eacute;vrier";
break;
case "03":
$mois = "Mars";
break;
case "04":
$mois = "Avril";
break;
case "05":
$mois = "Mai";
break;
case "06":
$mois = "Juin";
break;
case "07":
$mois = "Juillet";
break;
case "08":
$mois = "Ao&ucirc;t";
break;
case "09":
$mois = "Septembre";
break;
case "10":
$mois = "Octobre";
break;
case "11":
$mois = "Novembre";
break;
case "12":
$mois = "D&eacute;cembre";
break;
}
$n = date("j");
if (strlen($n) == 1) { $n = '0'.$n;}
echo "$jour"." ".$n." "."$mois"." ".date("Y"); // affiche la date en franÁais
}
//***********************************************************************************************
//                            fonction Calccombinaison (permet d'afficher le nom d'un taxon)
//***********************************************************************************************
function calccombinaison($rang,$Genre,$Espece,$Auteur,$TypeSousEspece,$SousEspece,$AuteurSousEspece,$TypeInfra2,$Infra2,$AuteurInfra2,$TypeInfra3,$Infra3,$AuteurInfra3)
{
switch ($rang)
{case "1":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>";
break;
case "10":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>";
break;
case "11":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." ".'<font size="-1">'."$AuteurSousEspece"."</font>";
break;
case "100":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>";
break;
case "101":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra2"."</font>";
break;
case "110":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." ".'<font size="-1">'."$AuteurSousEspece"."</font>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>";
break;
case "111":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra2"."</font>";
break;
case "1000":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>";
break;
case "1001":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra3"."</font>";
break;
case "1010":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra2"."</font>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>";
break;
case "1011":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra3"."</font>";
break;
case "1100":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." ".'<font size="-1">'."$Auteur"."</font>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." ".'<font size="-1">'."$AuteurSousEspece"."</font>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>";
break;
case "1101":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra3"."</font>";
break;
case "1110":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra2"."</font>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>";
break;
case "1111":
echo "<em><strong>"."$Genre"." "."$Espece"."</strong></em>"." "."$TypeSousEspece"." "."<em><strong>"."$SousEspece"."</strong></em>"." "."$TypeInfra2"." "."<em><strong>"."$Infra2"."</strong></em>"." "."$TypeInfra3"." "."<em><strong>"."$Infra3"."</strong></em>"." ".'<font size="-1">'."$AuteurInfra3"."</font>";
break;
}
}
//***********************************************************************************************
//       fonction pied de page 
//***********************************************************************************************
function pied()
{
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table border='0' cellspacing='0' cellpadding='0' width='850' align='center'>";
echo "	<tr>";
echo "      <td align='center' height='3' valign='bottom' bgcolor='#185B0D'><font color='#ffffff' face='Arial, Helvetica, sans-serif' size='-2'></font></td>";
echo "    </tr>";
echo "	<tr>";
echo "		<td align='center' valign='top' width='850' height='20' background='./images/bottom.gif'><font color='#B9E4B8' face='Arial, Helvetica, sans-serif' size='-2'><em><a href='http://www.tela-botanica.org/papyrus.php?site=2&menu=104' style='color:#B9E4B8;text-decoration:none;' target='_blank'>Licence Creative Commons by-sa</a> - 2005 Ptérido - Réalisé par Grégory BOCK </em></font></td>";
echo "	</tr>";
echo "</table>";
echo "</BODY>";
echo "</HTML>";
  }
//***********************************************************************************************
//       fonction entete de la page
//***********************************************************************************************

  function entete()
  {
echo   "<HTML>\r";

echo "<HEAD><title>Ptérido</title>\r";
echo "<META NAME=\"DESCRIPTION\" CONTENT=\"Actualisation de la cartographie des Ptéridophytes en France\">\r";
echo "<META NAME=\"KEYWORDS\" CONTENT=\"Photoflora, photoflora, pterido, Pterido, ptérido, Ptérido, ptéridophytes, Ptéridophytes, fougères, Fougères, carte, cartographie, actualisation, france\">\r";
echo "<META NAME=\"revisit-after\" CONTENT=\"15 days\">\r";
echo "<link rel=\"SHORTCUT ICON\" href=\"favicon.ico\" type=\"image/x-icon\">\r";

echo "<style TYPE=\"text/css\">\r";
echo "BODY {\r";
echo "scrollbar-face-color: #185B0D; \r";
echo "scrollbar-arrow-color: #FFFFFF; \r";
echo "}";

echo "TABLE.border {\r";
echo "        border:1px #185B0D solid; \r";
echo "}\r";

echo "A.type1:link {color:#663300; text-decoration:none;}\r";
echo "A.type1:visited {color:#663300; text-decoration:none;}\r";
echo "A.type1:active {color:#663300; text-decoration:none;}\r";
echo "A.type1:hover {color:#663300; text-decoration:underline;}\r";

echo ".menua {\r";
echo "	font-family: arial;\r";
echo "	font-size: 12px;\r";
echo "	font-weight: bold;\r";
echo "	color: #FFFFFF;\r";
echo "	text-decoration: none;\r";
echo "	font-style: normal;\r";
echo "	font-variant: normal;\r";
echo "	}\r";
echo ".menua:hover {color:#DF882D;}\r";
echo "</style>\r";

echo "<SCRIPT>";
echo "function MM_preloadImages() { ";
echo "var d=document;";
echo "  if(d.images){";
echo "  if(!d.MM_p) d.MM_p=new Array();";
echo "    var i,j=d.MM_p.length,a=MM_preloadImages.arguments;";
echo "   for(i=0; i<a.length; i++)";
echo "    if (a[i].indexOf(\"#\")!=0){";
echo "   d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}";
echo "}";
echo "</SCRIPT>";

echo "</HEAD>\r";


echo "<BODY onload=\"MM_preloadImages('./images/bandeau.gif', './images/fond.jpg')\" background=\"./images/fond.jpg\" style=\"background-attachment: fixed;\" topmargin='25'>\r"; 

echo "<table width=\"850\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\r";
echo "<tr>\r";
echo "	<td><img src='./images/bandeau.gif'></td>\r";
echo "</tr>\r";
echo "</table>\r";

//menu

echo "<table class='border' cellpadding='0' cellspacing='0' width='850' bgcolor='#185B0D' align='center'>";
echo "<tr>";
echo "	<td width='450' align='left'><font color='#FFFFFF'><a href='index.php' class='menua'>&nbsp;Accueil</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
echo "	<a href='rechercher.php' class='menua'>Rechercher</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
echo "	<a href='login.php?action=ajouter' class='menua'>Ajouter</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
echo "	<a href='login.php?action=modifier' class='menua'>Modifier</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
echo "	<a href='contact.php' class='menua'>Contacts</a></font></td>";
echo "	<td width='400' align='right'><font color='#FFFFFF' face='Arial, Helvetica, sans-serif' size='-1'><em>";  afficherdate(); echo "&nbsp;&nbsp;</em></font></td>";	
echo "</tr>";
echo "	</table>";

echo "<table class='border' width='850' bgcolor='#E4CA8B' cellpadding='0' cellspacing='0' align='center'>";

if (isset($_SESSION["authentification"])) {
echo "	<tr>";
echo "      <td align='right' valign='top' height='10'><a class='type1' href='login.php?erreur=delog'><font face='Arial, Helvetica, sans-serif' size='-2'><b><em>Se déconnecter</em></b></font></a>&nbsp;&nbsp;</td>";
echo "  </tr>";
}

echo "<tr>";
echo "<td>";

  }  
  

?>
