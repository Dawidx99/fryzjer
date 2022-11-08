<?php
session_start();
require_once __DIR__ . '/connect.php';
class API{
	function Select(){
		$db = new Connect;
		$users = array();
		$data = $db->prepare('SELECT users.imie, users.nazwisko, workers.opis, workers.start_hour, workers.end_hour, workers.czas_wizyty FROM workers INNER JOIN users ON users.id = workers.user_id;');
		$data->execute();
		while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
			$users[$OutputData['imie']] = array(
				'imie' => $OutputData['imie'],
				'nazwisko' => $OutputData['nazwisko'],
				'opis' => $OutputData['opis'],
				'czas rozpoczęcia:' => $OutputData['start_hour'],
				'czas zakończenia:' => $OutputData['end_hour'],
				'czas wizyty:' => $OutputData['czas_wizyty']
			);
		}
		return json_encode($users);
	}
	function PickTerm(){
		if(isset($_POST["pick_term"])){
			$data = array(
				//':userID' => $_SESSION['userID'],
				//':workerID' => $_SESSION['workerID'],
				':date' => $_POST['date'],
				':hour' => $_POST['hour']
			);
			$insert = $this->$db->prepare("INSERT INTO terms (user_id, worker_id, date, hour) VALUES (1, 2, :date, :hour)");
			$insert->execute($data);
			if($insert){
				echo "Udało się";
			}
		}	
	}	
}
?>
<html>
<head>
<title>FryzjerUAni</title>
<link rel="Stylesheet" type="text/css" href="style.css">
</head>
<body background="bg.jpg">
<p>
      <table>
         <tr>
            <td width="460px"><img id="logo" src="logo.png"/></td>
            <td>
				<a href="myterm.php"><strong><u><div id="title2"><u>MOJE TERMINY</u></div></u></strong>
			</td>
			<td>
			<?php
			$db = new Connect;
			if(isset($_SESSION['zalogowany'])){
				$login = $_SESSION['login'];
				$query = "SELECT * FROM users WHERE login = '".$login."' AND status = 3;";
				$result = $db->query($query);
				if ($result->rowCount() > 0)
				{    
				echo "<a href=\"panel.php\"><strong><u><div id=\"title2\"><u>PANEL ADMINISTRATORSKI</u></div></u></strong></td><td>";   
				}
			}
	if(!isset($_SESSION['zalogowany'])){
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
	 echo "Witaj $login";
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
      <br>
<table>
<tr>
<td colspan="2"></td>
</tr>
<tr>
</tr>
<tr>
<td><div id="tekst">
<center>
<?php
				if(isset($_SESSION['workerID'])){
					$id = $_SESSION['workerID'];
				} 
				else {
					$id = $_GET['workerID'];
					$_SESSION['workerID'] = $id;
				}	
				$db = new Connect;
				$data = $db->prepare("SELECT start_hour, end_hour, czas_wizyty FROM workers WHERE user_id='".$id."';");
				$data->execute();
					foreach($data as $row) {
									$start = $row['start_hour'];
									$end = $row['end_hour'];
									$czas = $row['czas_wizyty'];
						}
				if(!isset($_SESSION['zalogowany'])){
					echo "<tr><td><font color=\"red\">MUSISZ BYĆ ZALOGOWANY ABY WYBRAĆ TERMIN!</font></td></tr>";
				}
				else {
echo "
<tr>
<form action=\"addterm.php\" method=\"post\">
<td>
<input type=\"date\" id=\"date\" name=\"date\">
</td></tr>
<tr>
<td>
<select name =\"hour\" id=\"hour\">";
						for($x=$start; $x<$end;) {
							echo "<option value='".$x."'>".$x."</option>";
							$x = strtotime($x) + strtotime($czas) - strtotime('00:00:00');
							$x = date('H:i:s', $x);
						}
						
echo "</select></td></tr>
<td><input type=\"submit\" value=\"WYBIERZ\"></td>
</form>";
if(isset($_SESSION['weekend']) && $_SESSION['weekend']==true){
	echo "<tr><td><font color=\"red\">NIE PRACUJEMY W WEEKENDY</font></td></tr>";
}
else if(isset($_SESSION['sameday']) && $_SESSION['sameday']==true){
	echo "<tr><td><font color=\"red\">JESTEŚ JUŻ ZAPISANY/A NA TEN DZIEŃ!</font></td></tr>";
}
else if(isset($_SESSION['samehour']) && $_SESSION['samehour']==true){
	echo "<tr><td><font color=\"red\">TERMIN JEST ZAJĘTY, WYBIERZ INNY!</font></td></tr>";
}
				}
?>
</center>
</td>
</tr>
<table>
<tr><td></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></td></tr>
</table>
</table>	
</body>
</html>			