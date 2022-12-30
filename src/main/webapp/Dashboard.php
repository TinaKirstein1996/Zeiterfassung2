<?php
session_start();

include("connect.php");

$userid = $_SESSION['userid'];

$selectQuery = "SELECT * FROM users WHERE id = ".$userid." ";
$result = mysqli_query($connect,$selectQuery);
if(mysqli_num_rows($result) > 0){
    
}else{
    $msg = "Sie sind leider aktuell nicht nicht eingeloggt.";
}
?>


<!DOCTYPE html>
<!-- Git Test  -->
<html lang="ger" dir="ltr">
<head>
<meta charset = "utf-8">
<title>Zeiterfassungs-Anwendung</title>

<link rel="icon" type="image/png" href="/image/wbh.png">

<link rel="stylesheet" href = "css/dashboardaufbau.css">
<link rel="stylesheet" href = "css/style.css">
<link rel="stylesheet" href = "css/calendar.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Google font link -->
<link rel = "stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<script src="js/calendar.js" defer></script>
<script src="js/menu.js" defer></script>
<!-- für den timer -->
<script src="js/timeselect.js" defer></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body style="background-color: rgb(FFF)">

<div class="header d-flex flex-row justify-content-start">
	 		<h2 class="heading">Arbeitszeiterfassung</h2>
<a  href="logout.php" class="rechts" >Logout</a>
<p>.</p>
</form>
</div>


<div class="row">

<!-- Begibn Linke spalte -->
<div class="col-5 col-s-6 menu" style="width: fit-content;">

<div id="current_date" style="font-weight: 500;font-size: 1.45rem;"></div>
<br>

<!-- Tabelle Zeiteingabe -->
<table>
<form action="data_management.php" method="POST">
<div hidden="hidden">
<output id="current_date2" name="current_date"></output>
</div>

<p class="fallbackLabel">
</p>
<div class="fallbackTimePicker">
<div>
<!-- Start -->
<tr>
<td width="150">
<label for="hour_start">Beginn:</label>
</td>
<td>
<select id="hour_start" name="hour_start" style="width: 40px;"></select>
<label for="minute_start">:</label>
<select id="minute_start" name="minute_start" style="width: 40px;"></select>
</td>
</tr>
<!-- Ende -->
<tr>
<td width="150">
<label for="hour_end">Ende:</label>
</td>
<td>
<select id="hour_end" name="hour_end" style="width: 40px;"></select>
<label for="minute_end">:</label>
<select id="minute_end" name="minute_end" style="width: 40px;"></select>
</td>
</tr>
<!-- Pause -->
<tr>
<td width="150">
<label for="hour_pause">Pause:</label>
</td>
<td>
<select id="hour_pause" name="hour_pause" style="width: 40px;"></select>
<label for="minute_pause">:</label>
<select id="minute_pause" name="max_pause" style="width: 40px;"></select>
</td>
</tr>
<!-- Notizen -->
<tr>
<td width="150">Notizen: </td>
<td>
<textarea type="text" size="14" name="note"> </textarea>
</td>
</tr>
<!-- Senden -->
<tr>
<td colspan="2" style="padding-top: 15px;">
<button  id="submitButtonTest" style="width:auto;" >Zeiten eintragen</button>
</td>
</tr>
</div>
</div>
</form>
</table>

<div>
<form action="quicktracking.php" method="POST">
<button class=quicktrackingbtn style="width:auto;">Schnellerfassung</button>

</form>
</div>


</div>
<!-- Ende Linke spalte -->

<!-- Begibn Mittlere spalte -->
<div class="col-4 col-s-6">
<!-- Calender for time tracking -->
<!-- ohne funktion wegen ppp-->
<div class="calendar_wrappper">
<!-- ende ohne funktion-->
<p class="current-date"></p>
<div class="icons">
<span id = "prev" class="material-symbols-rounded">chevron_left</span>
<span id= "next" class="material-symbols-rounded">chevron_right</span>
</div>

<div class="calendar">
<ul class="weeks">
<li>Mo</li>
<li>Di</li>
<li>Mi</li>
<li>Do</li>
<li>Fr</li>
<li>Sa</li>
<li>So</li>
</ul>
<ul class="days"></ul>
</div>
</div>
<form action="/calendar.html" >
<button type="submit">Historie anzeigen</button>
</form>
</div>

<div id="main"> </div>
<!-- Ende Mittlere spalte -->

<!-- Begibn Rechte spalte -->
<div class="col-3 col-s-12">
<div style="font-weight: 500;font-size: 1.45rem;">Hinweise</div>
<div class="aside" style="text-align: left;">
<p><u>Ruhepausen:</u></p>
<ul>
<li>ab 6Stunden Arbeitszeit mindestens 30 Minuten Pause</li>
<li>ab 9Stunden Arbeitszeit mindestens 45 Minuten Pause</li>
</ul>
<br>
<p><u>Arbeitszeit</u></p>
<ul>
<li>max 8 Stunden pro Tag, in Ausnahmen 10 Stunden </li>
<li>max 48 Stunden pro Woche, in Ausnahmen 60Stunden</li>
<li>max 19 Tage in Folge Arbeiten</li>
</ul>
</div>
<p><a href="https://www.gesetze-im-internet.de/arbzg/BJNR117100994.html" target="_blank">mehr zum Arbeitszeitgesetz</a></p>
<br>
<form action="/user_data.php">
<button type="submit">Stammdaten</button>
</form>
</div>
</div>
<!-- Ende Rechte spalte -->
<!-- Begibn Fuß spalte -->
<div class="footer">
	<p><a  href="/Impressum.html" class="rechts" target="_blank">Impressum</a></p>
    <p><a href="/Datenschutzerklärung.html" class="rechts" target="_blank">Datenschutzerklärung</a></p>		
<p>.</p>
<!-- Ende Fuß spalte -->
</body>
</html>
