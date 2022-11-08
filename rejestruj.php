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
        $haslo = $_POST['haslo'];
		$haslo1 = $_POST['haslo1'];
        $imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$telefon = $_POST['telefon'];
		$email = $_POST['email'];
		
		//Porównanie haseł i poprawnosc maila
		$emailB=filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email))
		{
			$_SESSION['errormail']=true;
			header("Location: rejestracja.php");
		}
		else{
			$_SESSION['errormail']=false;
		}	
		if($haslo1==$haslo){
        // sprawdzamy czy login/mail nie jest już w bazie
        $query = "SELECT login FROM users WHERE login = '".$login."';";
			$result = $db->query($query);
		$query1 = "SELECT email FROM users WHERE email = '".$email."';";
			$result1 = $db->query($query);
		if ($result->rowCount()==0 and $result1->rowCount()==0) 
        {
                $stmt = $db->query("INSERT INTO `users` (`login`,`haslo`,`imie`,`nazwisko`,`nr_telefonu`,`email`,`status`)
                    VALUES ('".$login."', '".md5($haslo)."','".$imie."','".$nazwisko."','".$telefon."','".$email."', 1);");
                
                echo "Konto zostało utworzone!";
        }
        else if ($result->rowCount()>0){
			echo "Podany login jest już zajęty.";
		}
		else if ($result1->rowCount()>0){
			echo "Podany mail jest już zajęty.";
		}
		$_SESSION['errorhaslo']=false;
	header("Location: index.php");
		}
		else{
			$_SESSION['errorhaslo']=true;
			header("Location: rejestracja.php");
		}	
?>