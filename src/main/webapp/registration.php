<?php
session_start();

$dbhost="rdbms.strato.de";
$dbuser="dbu433728";
$dbpass="projektarbeit";
$dbname="dbs9413900";

$pdo = new PDO('mysql:host=rdbms.strato.de;dbname=dbs9413900', 'dbu433728', 'projektarbeit');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8">
<title>Zeiterfassungs-Anwendung</title>
<link rel="stylesheet" href = "css/registrationStyle.css">
<link rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel = "stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>

<body>

<?php
$showFormular = true;

if(isset($_GET['register'])) {
    
    $error = false;
    $p_nr = $_POST['p_nr'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $weekly_workinghours = $_POST['weekly_workinghours'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $pause_time = $_POST['pause_time'];
        
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($password) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($password != $password2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
        
    if(!$error) {
        
        $SELECT = "SELECT * From users Where email = :email";
        $INSERT = "INSERT INTO users (p_nr, email, password, weekly_workinghours, start_time, end_time, pause_time) VALUES (:p_nr, :email, :password, :weekly_workinghours, :start_time, :end_time, :pause_time)";
        
        $stmt = $pdo->prepare($SELECT);
        $result = $stmt->execute(array('email' => $email));
        $user = $stmt->fetch();
        
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        } 
    }
    
    if(!$error) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt=$pdo->prepare($INSERT);
        $result = $stmt->execute(array('p_nr' => $p_nr, 'email' => $email, 'password' => $password_hash, 'weekly_workinghours' => $weekly_workinghours, 'start_time' => $start_time, 'end_time' => $end_time, 'pause_time' => $pause_time));
        
        if($result) {
            echo 'Registrierung erfolgreich abgeschlossen! <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
?>
<form action="?register=1" method="post">
		<h1>Registrierung</h1>
    	<p>Bitte füllen Sie die folgenden Daten aus, um einen Account anzulegen.</p>
    	<hr>
    	
    	<div class = container>
	    	Personalnummer:<br>
			<input type=number size="40" maxlength="250" name="p_nr" placeholder="Bitte Personalnummer eingeben" required><br><br>
	    		
			E-Mail:<br>
			<input type="email" size="40" maxlength="250" name="email" placeholder="Bitte E-Mail Adresse eingeben" required><br><br>
		 
			Passwort:<br>
			<input type="password" size="40"  maxlength="250" name="password" placeholder="Bitte Passwort eingeben" required><br>
		 
			Passwort wiederholen:<br>
			<input type="password" size="40" maxlength="250" name="password2" placeholder="Passwort wiederholen" required><br><br>
			<hr>
			
			Vertraglich vereinbarte wöchentliche Arbeitszeit:<br>
			<input type="number" size="40" maxlength="250" name="weekly_workinghours" placeholder="Wöchentliche Arbeitszeit eingeben" required><br><br>
			<hr>
			
			Sie können auch Starndard-Arbeitszeiten hinterlegen, welche später dafür verwendet werden mit einem Klick die angegebene Arbeitszeit aufzuzeichnen.<br><br>
			
			Beginn der Arbeitszeit:<br>
			<input type="time" size="40" maxlength="250" name="start_time" placeholder="Beginn der Arbeitszeit eingeben"><br><br>
			
			Ende der Arbeitszeit:<br>
			<input type="time" size="40" maxlength="250" name="end_time" placeholder="Ende der Arbeitszeit eingeben"><br><br>
			
			
			Pausenzeit:<br>
			<input type="time" size="40" maxlength="250" name="pause_time" placeholder="Pausenzeit eingeben"><br><br>
			
			
			<p> Bei der Registrierung Ihres Accounts stimmen Sie unseren <a href="#"> Datenschutz-Regelungen </a> zu.</p>
		 
			<input type="submit" value="Abschicken" class="registerbtn">
			
		</div>

    	<p>Sie haben bereits einen Account? <a href="login.php">Einloggen</a>.</p>
	</form>
<?php
} //Ende von if($showFormular)
?>
</body>
</html>
