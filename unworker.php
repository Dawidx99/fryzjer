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
		
		$stmt = $db->query("SELECT id FROM users WHERE login = '".$login."';");
		foreach($stmt as $row){
			$id = $row['id'];
		}
		$query = "SELECT * FROM workers WHERE user_id = '".$id."';";
			$result1 = $db->query($query);
		if ($result1->rowCount()>0) 
        {
                $stmt = $db->query("DELETE FROM `workers` WHERE user_id='".$id."';");
                $terms = $db->query("DELETE FROM `terms` WHERE worker_id='".$id."';");
                echo "Usunięto pracownika!";
        }
        else if ($result1->rowCount()==0){
			echo "NIE MA TAKIEGO PRACOWNIKA.";
		}
		echo "<a href=\"panel.php\"><input type=\"button\" value=\"WRÓC DO PANELU\"></a>";
?>