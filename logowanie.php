<?php
	session_start();
	require_once "connect.php";
	$db = new Connect;
		$login = $_POST['login'];
        $haslo = $_POST['haslo'];
        
        // sprawdzamy czy login i hasło są dobre
		$query = "SELECT id, login, haslo FROM users WHERE login = '".$login."' AND haslo = '".md5($haslo)."';";
			$result = $db->query($query);
		if ($result->rowCount() > 0)
        {    
            foreach($result as $row){
				$_SESSION['userID'] = $row['id'];
			}	
			$_SESSION['zalogowany'] = true;
            $_SESSION['login'] = $login;
			$_SESSION['loginerror'] = false;
			unset($_SESSION['notlogged']);
         echo "Zalogowano"; 
			header("Location: index.php");
            // zalogowany
        }
        else{
			echo "Wpisano złe dane.";
			$_SESSION['loginerror'] = true;
			header("Location: index.php");
		}
?>