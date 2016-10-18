<?php

require("../../config.php");

	
	// see fail, peab olema kıigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	session_start();
	
	//***************
	//**** SIGNUP ***
	//***************
	
	function signUp ($email, $password) {
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO MVP (email, password) VALUES (?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			echo "salvestamine ınnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password) {
		
		$error = "";
		echo $email;
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created 
		FROM MVP
		WHERE email = ?");
	
		echo $mysqli->error;
		
		//asendan k¸sim‰rgi
		$stmt->bind_param("s", $email);
		
		//m‰‰ran v‰‰rtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist vıi mitte
		// on tıene kui on v‰hemalt ¸ks vaste
		if($stmt->fetch()){
			
			
			$hash = hash("whirlpool", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//m‰‰ran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				
				header("Location: data.php");
				exit();
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
		
	}


	function cleanInput($input){
		
		$input = trim($input);           
		$input = htmlspecialchars($input);
		$input = stripslashes($input);
		
	    return $input;
	}
	
		
	function savePlant ($taim, $intervall) {
		
		
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare(
		"INSERT INTO lilled (taim, intervall) VALUES (?,?)");
		
		echo $mysqli->error;
		
		
		
		//asendan k¸sim‰rgi
		$stmt->bind_param("ss", $taim,$intervall);
		
		if ( $stmt->execute() )  {
			
			echo "salvestamine ınnestus";
			
		}  else  {
			
			echo "ERROR".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function getAllPlants () {
		
		
	
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		
		$stmt = $mysqli->prepare("
		
		  SELECT id, taim,intervall FROM lilled
		 
		");
		echo $mysqli->error;
		
		
		$stmt -> bind_result ($id, $taim,$intervall) ;
		$stmt ->execute();
		
		//tekitan massiivi
		
		$result=array();
		
		//Tee seda seni, kuni on rida andmeid. ($stmt->fech)
		//Mis vastab select lausele.
		//iga uue rea andme kohta see lause seal sees
		
		while($stmt->fetch()){
			
			//tekitan objekti
			
			$plant = new StdClass();
			
		    $plant->id=$id;
			$plant->taim=$taim;
			$plant->intervall=$intervall;
			
			
			
			array_push($result, $plant);
		}
		$stmt->close();
		$mysqli->close();
		return $result;
		
		
	}
	
	
?>