<?php
session_start();

include("connect.php");

$userid = $_SESSION['userid'];

$selectQuery = "SELECT * FROM users WHERE id = ".$userid." ";
$result = mysqli_query($connect,$selectQuery);
if(mysqli_num_rows($result) > 0){
    
}else{
        $msg = "No Record found";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset = "utf-8">
    <title>Zeiterfassungs-Anwendung</title>
    <link rel="stylesheet" href = "css/dashboardaufbau.css">   
    <link rel="stylesheet" href = "css/style.css">
    <link rel="stylesheet" href = "css/calendar.css">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google font link -->
    <link rel = "stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    
</head>
<body>
    <h1>Stammdaten</h1>
    <?=$msg;?>
    <table style="width:100%; line-height:40px;">
        <thead>
            <tr>
            </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_assoc($result)){?>
                <tr>
                	<td> Personalnummer: </td>
                    <td> <?php echo $row['p_nr']; ?></td>
                </tr>
                <tr>  
                	<td> E-Mail: </td> 
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <tr>
                	<td> Passwort: </td>
                    <td><?php echo $row['password']; ?></td>
                </tr>
                <tr>
                	<td> Wöchentliche Arbeitszeit: </td>
                    <td><?php echo $row['weekly_workinghours']; ?></td>
                </tr>
                <tr>
                	<td> Beginn der Arbeitszeit: </td>
                    <td><?php echo $row['start_time']; ?></td>
                </tr>
                <tr>
                	<td> Ende der Arbeitszeit: </td>
                    <td><?php echo $row['end_time']; ?></td>
                </tr>
                <tr>
                	<td> Pausenzeit: </td>
                    <td><?php echo $row['pause_time']; ?></td>
                </tr>
            <?}?>
        </tbody>
    </table>
    <br>
    <button  id="changeUserDate" style="border-radius: 8px; width:20%;" >Stammdaten anpassen</button>
    <br>
    <br>
    <div style="text-align: left;"id="DashboardLink">
		<a target="_blank" href="http://zeiterfassung-wbh.de/Dashboard.html" style="border-radius: 8px; width:20%;">Zurück zum Dashboard</a>
	</div>
</body>
</html>