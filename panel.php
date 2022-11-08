<?php
session_start();
require_once "connect.php";
?>
<html>
<head>
<link rel="Shortcut icon" href="ikonka.png">
<title>Fryzjer</title>
<link rel="Stylesheet" type="text/css" href="style.css">
</head>
<body background="BG.jpg">
<p>
      <table>
         <tr>
            <td width="460px"><img id="logo" src="logo.png"/></td>
            <td>
				<a href="index.php"><strong><u><div id="title2"><u>STRONA GŁÓWNA</u></div></u></strong>
			</td>
			<td>
				<a href="myterm.php"><strong><u><div id="title2"><u>MOJE TERMINY</u></div></u></strong>
			</td>
			<td>
			<?php
			$db = new Connect;

	if(!isset($_SESSION['zalogowany'])){
		header('location: index.php');
	 if(isset($_SESSION['loginerror'])){
		if($_SESSION['loginerror'] == true){
			echo "<font color=\"red\">WPISANO ZLE DANE</font>";
		}
	 }
	 echo "
	 <div id=\"logowanie\">
	 <form action=\"logowanie.php\" method=\"post\">
		login:<input type=\"text\" name=\"login\"></br>
		haslo:<input type=\"password\" name=\"haslo\"></br>
		<input type=\"submit\" value=\"Zaloguj\"><br>
     </form>
	 <a href=\"rejestracja.php\">Nie masz konta? Zarejestruj się!</a>";
	}
	else{
	 $login = $_SESSION['login'];
	 $myJSON = json_encode($login);
	 //echo "Witaj $login";
	 echo "Witaj $myJSON";
	 echo "<a href=\"wyloguj.php\">
			<input type=\"button\" value=\"WYLOGUJ\"><br>
			</a>";
	}
	echo "</div>";
?>
         </td>
		 </tr>
		 </p>
      </table>
	  </br>
	  <table><tr>
      <td><br><center><div id="title3">
	  Dodaj pracownika:
	  <form action="worker.php" method="post">
	  Login:<input type="text" name="login"></br>
	  Opis:<input type="text" name="opis"></br>
	  Godzina rozpoczęcia:<input type="time" name="start"></br>
	  Godzina zakończenia:<input type="time" name="end"></br>
	  Czas wizyty:<input type="time" name="time"></br>
	  <input type="submit" value="DODAJ"></br>
	  </form>
	  Usuń pracownika:
	  <form action="unworker.php" method="post">
	  Login:<input type="text" name="login"></br>
	  <input type="submit" value="USUŃ"></br>
	  </form>
	  </div></center></td>
	  </tr></table>
</body>
</html>