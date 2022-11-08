<!DOCTYPE html>
<head lang="pl">
 <meta charset="utf-8">
</head>
<body>
 <?php
 session_start();
 require_once "connect.php";
 $db = new Connect;
        $login = $_POST['login'];
        $opis = $_POST['opis'];
		$start = $_POST['start'];
        $end = $_POST['end'];
		$time = $_POST['time'];
		
		$stmt = $db->query("SELECT id FROM users WHERE login = '".$login."';");
		foreach($stmt as $row){
			$id = $row['id'];
		}
		$query = "SELECT * FROM workers WHERE id = '".$id."';";
			$result1 = $db->query($query);
		if ($result1->rowCount()==0) 
        {
                $stmt = $db->query("INSERT INTO `workers` (`user_id`,`opis`,`start_hour`,`end_hour`,`czas_wizyty`)
                    VALUES ('".$id."', '".$opis."','".$start."','".$end."','".$time."');");
                $status = $db->query("UPDATE users SET status=2 WHERE id='".$id."';");
                echo "DODANO PRACOWNIKA!";
        }
        else if ($result1->rowCount()>0){
			echo "Użytkownik już jest dodany.";
		}
		echo "<a href=\"panel.php\"><input type=\"button\" value=\"WRÓC DO PANELU\"></a>";
?>