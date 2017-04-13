<?php
// page de recherche pour la modif

require './scripts/MesFonctions.php';

/**********************************    vérification de la session   ******************************************/
session_start(); // On relaye la session
if (isset($_SESSION["authentification"])){ // vérification sur la session authentification (la session est elle enregistrée ?)

		entete();
		echo "<br><br><p align='center'><b><font color='#663300' face='Arial, Helvetica, sans-serif' size='-1'>";
		if ($_SESSION['privilege'] == 'user') {
		echo "Votre privilège est : &quot;contributeur&quot; <br><br> Vous pouvez modifier uniquement vos propres observations.";
		}
		if ($_SESSION['privilege'] == 'admin') {
		echo "Votre privilège est : &quot;administrateur&quot; <br><br> Vous pouvez modifier toutes les observations.";
		}
		echo "</font></b>"; 
		echo "<div align='center'><br><br>";
		echo "<form name='continuer' method='post' action='rechercher.php'>";
		echo "<input name='w' style='display:none' value='1'>";
		echo "<input type='submit' name='ok' value='  Continuer   '>";
		echo "</form></div>";
		echo "</p><br><br><br><br><br><br><br><br><br><br>";
		pied();
}
else {
header("Location:login.php?action=modifier&erreur=intru"); // redirection en cas d'echec
}
//*************************************************************************************************************


?>

