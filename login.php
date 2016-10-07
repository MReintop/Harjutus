<?php

require("../../config.php");
require("functions.php");

if(isset($_SESSION["userID"])){
	
	header("Location:data.php");
}


	
	//MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$registerEmailError = "";
	$registerPasswordError ="";
	$signupEmail = "";	
	
	


	if( isset($_POST["signupEmail"] )){

	

		if( empty($_POST["signupEmail"])) {

			$signupEmailError = "see väli on kohustuslik";
			
		}else{
			
			//email olemas
			$signupEmail=$_POST["signupEmail"];



			}
	}



	if( isset($_POST["signupPassword"])) {

		if( empty($_POST["signupPassword"])) {

			$signupPasswordError = "see väli on kohustuslik";
		}else{
		//Siia jõuan siis, kui parool oli olemas ja parool ei olnud tühi. !ELSE!
			if(strlen($_POST["signupPassword"])<8) {

				$signupPasswordError = "Parool peab olema vähemalt 8 märki pikk";
			}




	}
	}

	if( isset($_POST["registerEmail"] )){

		

		if( empty($_POST["registerEmail"])) {

			$registerEmailError = "e-mail on kohustuslik";



		}
	}



if( isset($_POST["registerPassword"] )){

		

		if( empty($_POST["registerPassword"])) {

			$registerPasswordError = "parool on kohustuslik";
			
			
		} else {

             if(strlen($_POST["registerPassword"])<8) {

				$registerPasswordError = "Parool peab olema vähemalt 8 märki pikk";
			}

		}
	}



	
	if($registerEmailError == "" && empty ($registerPasswordError) && isset($_POST["registerEmail"])
			&& isset($_POST["registerPassword"]))  {
			
	
		
		//salvestame andmebaasi
		
		echo "Salvestan...";
		echo "email : ".$_POST["registerEmail"]."<br>";
		echo "password: ".$_POST["registerPassword"]."<br>";
		
		$password = hash("whirlpool", $_POST["registerPassword"]);
		
		echo "password hashed: ".$password."<br>";  
		
		signUp($registerEmail,$password);
		
		
		//salvestame andmebaasi
			
			//YHENDUS	
			
			$database = "if16_mreintop";
		$mysqli = new mysqli ($serverHost, $serverUsername, $serverPassword, $database);
		
		
		//MYSQL rida
		
		$stmt = $mysqli->prepare("INSERT INTO MVP(email, password) VALUES (?,?)");
		
		//stringina 1 t2ht iga muutuja kohta , mis tyyp
		// string - s   (date, varchar)
		// integer - i   (t2isarv)
		// float (double) - d  (komakohaga arv)
		//kysim2rgid asendada muutujaga
		
		$stmt->bind_param("ss", $_POST["registerEmail"], $password);
		//t2ida k2sku
		//$stmt->execute();
		
		echo $mysqli->error;

		if($stmt->execute())  {
			
			echo "salvestamine onnestus";
			
		
		} else {
			echo "ERROR".$stmt->error;
			
		}
	
	}
	
var_dump($_POST);
$error="";

if( isset($_POST["signupEmail"]) && isset($_POST["signupPassword"])&&
			!empty($_POST["signupEmail"]) && !empty($_POST["signupPassword"])
			){
				
				$error = login($_POST["signupEmail"], $_POST["signupPassword"]);
			}
	
?>


<!DOCTYPE html>
<html>
<head>
<title>´Logi sisse või loo kasutaja</title>
</head>
<body bgcolor="#99FF33">

<h2><font face="verdana" color="green">Logi sisse</font></h2>



	<form method=POST>



		<input name=signupEmail placeholder="e-mail" type="text" value="<?=$signupEmail;?>"> <?php echo $signupEmailError;  ?>

	<br><br>


		<input name=signupPassword placeholder="parool" type="password"> <?php echo $signupPasswordError; ?>

	<br>

		<input type="submit" value="Logi sisse">
	<br><br>




	</form>

	
	<h1><font face="verdana" color="green">Loo kasutaja</font></h1>
	<h2><font face="verdana" color="green">Sisesta e-mail</font></h2>

	<?php echo $registerEmailError;?>
	<?php echo $registerPasswordError;?>
	

	<form method=post>

	<input type=text  name=registerEmail  placeholder="Sisesta meiliaadress" > <br><br>
	
	

	<input type=password name=registerPassword  placeholder="Vali parool" > <br><br>
	
	<input type="submit" value="Kinnitan">
	
	



	</form>
	

	


	



</body>
</html>
