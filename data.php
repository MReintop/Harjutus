<?php 
	
	
	require("functions.php");
	
	$taim="";
	$intervall="";
	$plantError="";
	$intervalError="";
	
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
		
	}
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
		
	}
	
	$msg = "";
	if(isset($_SESSION["message"])) {
		
		$msg = $_SESSION["message"];
		
		//kustutan ära, et pärast ei näitaks
		unset($_SESSION["message"]);
	}
	
	if (isset($_POST["taim"]) &&
		(isset($_POST["kastmiskorda"]) &&
		!empty($_POST["taim"]) &&
		!empty($_POST["kastmiskorda"])
		)) {
			
			savePlant(cleanInput($_POST["taim"]), $_POST["kastmiskorda"]);
			
			header("Location: data.php");
		    exit();
		}
		
		$plantData=getAllPlants();
		
		//echo"<pre>";
		//var_dump($plantData);
		//echo"</pre>";
		
	

	if( isset($_POST["taim"] )){

	

		if( empty($_POST["taim"])) {

			$plantError = "sisesta taime nimetus";
			
		}else{
			
			
			$taim=$_POST["taim"];



			}
	}
	
	if( isset($_POST["kastmiskorda"])) {
		
		if( empty($_POST["kastmiskorda"]))
        {
			$intervalError = "Sisesta kastmisintervall";
			
			} else { 
			
			$intervall = $_POST["kastmiskorda"];
		
		}		
	}
	
?>


<html>
<head>
<title>Kalender</title>
</head>
<body background = "http://www.pixeden.com/media/k2/galleries/165/004-subtle-light-pattern-background-texture-vol5.jpg">

<br><br>


<center><h2><font face="verdana" color="#006600"> Toataimede sisestamine</font> </h2></center>


	<center><form method=POST>
   

          
	 <p><font face="verdana" color="#006600">Sisesta taime nimetus</font></p>
		<input name="taim" placeholder="taime nimetus"  type="text" > 

	<br><br>

        <p><font face="verdana"color="#006600">Sisesta taime kastmisintervall</font></p>
		<input name="kastmiskorda" placeholder="mitme päeva tagant"  type ="number"> 

	<br>

		<input type="submit" value="Salvesta">
	<br><br>
	
	</form></center>




	
	
	
	<center><?php
	
	$html = "<table>";
	$html .= "<tr>";
		$html .= "<th>nr</th>";
		$html .= "<th>id</th>";
		$html .= "<th>taim</th>";
		$html .= "<th>intervall</th>";
	$html .= "</tr>";
	
	$i = 1;
	//iga liikme kohta massiivis
	foreach($plantData as $p) {
		//iga taim on $p
		//echo $p->taim."<br>";
	
		
		$html .= "<tr>";
			$html .= "<td>".$i."</td>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->taim."</td>";
			$html .= "<td>".$p->intervall."</td>";
		$html .= "</tr>";
		
		$i += 1;
	}
	
	$html .= "</table>";
	
	echo $html;
	
	$listHtml="<br><br>";
	
	
	
	echo $listHtml;
	?></center>
	
	
	
	
	
	
	
	



</body>
</html>

<html>
<head>
<style>
* {box-sizing:border-box;}
ul {list-style-type: none;}
body {font-family: Verdana,sans-serif;}

.month {
    padding: 70px 25px;
    width: 100%;
    background: #D0FA58;
}

.month ul {
    margin: 0;
    padding: 0;
}

.month ul li {
    color: green;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
}

.month .prev {
    float: left;
    padding-top: 10px;
}

.month .next {
    float: right;
    padding-top: 10px;
}

.weekdays {
    margin: 0;
    padding: 10px 0;
    background-color: #ddd;
}

.weekdays li {
    display: inline-block;
    width: 13.6%;
    color: #666;
    text-align: center;
}

.days {
    padding: 10px 0;
    background: #eee;
    margin: 0;
}

.days li {
    list-style-type: none;
    display: inline-block;
    width: 13.6%;
    text-align: center;
    margin-bottom: 5px;
    font-size:12px;
    color: #777;
}

.days li .active {
    padding: 5px;
    background: #BEF781;
    color: white !important
}

/* Add media queries for smaller screens */
@media screen and (max-width:720px) {
    .weekdays li, .days li {width: 13.1%;}
}

@media screen and (max-width: 420px) {
    .weekdays li, .days li {width: 12.5%;}
    .days li .active {padding: 2px;}
}

@media screen and (max-width: 290px) {
    .weekdays li, .days li {width: 12.2%;}
}
</style>
</head>
<body>

<center><h1><font style="verdana" color="#003300">Kastmiskalender</font></h1></center>

<div class="month">
  <ul>
    <li class="prev">❮</li>
    <li class="next">❯</li>
    <li style="text-align:center">
      Oktoober<br>
      <span style="font-size:18px">2016</span>
    </li>
  </ul>
</div>

<ul class="weekdays">
  <li>Mo</li>
  <li>Tu</li>
  <li>We</li>
  <li>Th</li>
  <li>Fr</li>
  <li>Sa</li>
  <li>Su</li>
</ul>

<ul class="days">
  <li>1</li>
  <li>2</li>
  <li>3</li>
  <li>4</li>
  <li>5</li>
  <li>6</li>
  <li>7</li>
  <li>8</li>
  <li>9</li>
  <li><span class="active">15</span></li>
  <li>11</li>
  <li>12</li>
  <li>13</li>
  <li>14</li>
  <li>15</li>
  <li>16</li>
  <li>17</li>
  <li>18</li>
  <li>19</li>
  <li>20</li>
  <li>21</li>
  <li>22</li>
  <li>23</li>
  <li>24</li>
  <li>25</li>
  <li>26</li>
  <li>27</li>
  <li>28</li>
  <li>29</li>
  <li>30</li>
  <li>31</li>
</ul>


<br><br>
<center><p><font face="verdana" color="green">
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
	</font>
</p></center> 
</body>
</html>

