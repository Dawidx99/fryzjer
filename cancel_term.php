<?php
session_start();
require_once __DIR__ . '/connect.php';
$db = new Connect;
				$termID = $_GET['termID'];
					$drop = $db->query("DELETE FROM `terms` WHERE id='".$termID."';");
						if($drop){
						header('location: myterm.php');
						}
						else{
							echo "ERROR";
						}
?>