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
			<?php
			if(isset($_SESSION['zalogowany'])){
				$login = $_SESSION['login'];
				$query = "SELECT * FROM users WHERE login = '".$login."' AND status = 3;";
				$result = $pdo->query($query);
				if ($result->rowCount() > 0)
				{    
				echo "<td><a href=\"Admin/panel.php\"><strong><u><div id=\"title2\"><u>PANEL ADMINISTRATORSKI</u></div></u></strong></td>";   
				}
			}
	if(!isset($_SESSION['zalogowany'])){
	 if(isset($_SESSION['error'])){
		if($_SESSION['error'] == true){
			echo "<p color=\"red\">WPISANO ZLE DANE</p>";
		}
	 }
	 echo "
	 <div id=\"logowanie\">
	 <form action=\"logowanie.php\" method=\"post\">
		login:<input type=\"text\" name=\"login\"></br>
		haslo:<input type=\"password\" name=\"haslo\"></br>
		<input type=\"submit\" value=\"Zaloguj\"><br>
     </form>";
	 }
	else{
	 $login = $_SESSION['login'];
	 echo "Witaj $login";
	 echo "<a href=\"wyloguj.php\">
			<input type=\"button\" value=\"WYLOGUJ\"><br>";
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
	  Zarejestruj się:
	  <form action="rejestruj.php" method="post">
	  Imie:<input type="text" name="imie"></br>
	  Nazwisko:<input type="text" name="nazwisko"></br>
	  Login:<input type="text" name="login"></br>
	  Nr.Telefonu:<input type="text" name="telefon"></br>
	  Hasło:<input type="password" name="haslo"></br>
	  Potwierdź hasło:<input type="password" name="haslo1"></br>
	  <?php
		if(isset($_SESSION['errorhaslo'])){
			if($_SESSION['errorhaslo']==true){
				echo "</div><font color=\"red\">PODANE HASŁA SĄ RÓŻNE</font><div id=\"title3\"></br>";
			}
		}
	  ?>
	  Email:<input type="text" name="email"></div>
	  <?php
		if(isset($_SESSION['errormail'])){
			if($_SESSION['errormail']==true){
				echo "</div><font color=\"red\">PODAJ POPRAWNY EMAIL</font><div id=\"title3\"></br>";
			}
		}
	  ?>
	  <input type="checkbox" name="regulamin">
	  Oświadczam, że zapoznałem się z <a href="regulamin.html"> Regulaminem  </a>strony </br>
		 </br>
	  <input type="submit" value="ZAREJESTRUJ"></br>
	  </form>
	  </div></center></td>
	  </tr></table>
</body>
</html>