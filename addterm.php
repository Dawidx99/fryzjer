<?php
session_start();
require_once __DIR__ . '/connect.php';
$db = new Connect;
				echo $_SESSION['userID'];
				$userID = $_SESSION['userID'];
				$workerID = $_SESSION['workerID'];
				$date = $_POST['date'];
				$hour = $_POST['hour'];
					$query1 = "SELECT * FROM terms WHERE date='".$date."' AND worker_id='".$workerID."' AND hour='".$hour."';";
					$result1 = $db->query($query1);
					if ($result1->rowCount() > 0){
							$_SESSION['samehour']=true;
							header('location: choose_term.php?workerID=" . $workerID . "');
						}
						else {
							$_SESSION['samehour']=false;
					$query = "SELECT * FROM terms WHERE date='".$date."' AND user_id='".$userID."';";
					echo $query;
					$result = $db->query($query);
						if ($result->rowCount() > 0){
							$_SESSION['sameday']=true;
							header('location: choose_term.php?workerID=" . $workerID . "');
						}
						else {
							$_SESSION['sameday']=false;
				$unixTimestamp = strtotime($date);
				$dayOfWeek = date("l", $unixTimestamp);
				if($dayOfWeek=="Saturday" || $dayOfWeek=="Sunday"){
					$_SESSION['weekend']=true;
					header('location: choose_term.php?workerID=" . $workerID . "');
				} else {
					$_SESSION['weekend']=false;
					$insert = $db->query("INSERT INTO `terms` (`id`, `user_id`, `worker_id`, `date`, `hour`) VALUES (NULL, '".$userID."', '".$workerID."', '".$date."', '".$hour."')");
						if($insert){
						echo "Zapisałeś się na $dayOfWeek";
						unset($_SESSION['weekend']);
						unset($_SESSION['sameday']);
						unset($_SESSION['workerID']);
						header('location: myterm.php');
						}
				}
						}
						}
?>