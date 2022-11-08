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
		$db = new Connect;
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
      <br>
<table>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td><div id="tekst">
<?php
				$db = new Connect;
				$data = $db->prepare('SELECT users.id, users.imie, users.nazwisko, workers.opis, workers.start_hour, workers.end_hour, workers.czas_wizyty FROM workers INNER JOIN users ON users.id = workers.user_id;');
				$data->execute();
				echo '<table border=\"3\"><tr><td>Imię</td><td>Nazwisko</td><td>Opis</td><td>Godzina rozpoczęcia pracy:</td><td>Godzina zakończenia pracy:</td><td>Czas wizyty:</td><td></td></tr>';
					foreach($data as $row) {
						$myArr = '[{"imie":"'.$row['imie'].'", "nazwisko":"'.$row['nazwisko'].'", "opis":"'.$row['opis'].'", "zaczecie":"'.$row['start_hour'].'", "koniec":"'.$row['end_hour'].'", "wizyta":"'.$row['czas_wizyty'].'"}]';
									$term_JSON = json_decode($myArr);
									foreach($term_JSON as $result){
									echo "<tr><td>".$result->imie."</td><td>".$result->nazwisko."</td>";
									echo "<td>".$result->opis."</td><td>".$result->zaczecie."</td>";
									echo "<td>".$result->koniec."</td><td>".$result->wizyta."</td>";
									echo "<td> <a href=choose_term.php?workerID=" . $row['id'] . "><input type=\"button\" value=\"WYBIERZ\"></a></td></tr>";
						}
					}
					echo "</table>";	
?>
</td>
</tr>
<table>
<tr><td></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></td></tr>
</table>
</table>	
</body>
</html>			