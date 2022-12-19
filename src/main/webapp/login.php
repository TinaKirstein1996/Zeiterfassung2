<?php
session_start();

$dbhost="rdbms.strato.de";
$dbuser="dbu433728";
$dbpass="projektarbeit";
$dbname="dbs9413900";

$pdo = new PDO('mysql:host=rdbms.strato.de;dbname=dbs9413900', 'dbu433728', 'projektarbeit');

if(isset($_GET['login'])) {

    $p_nr = $_POST['p_nr'];
    $password = $_POST['password'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE p_nr = :p_nr");
    $result = $statement->execute(array('p_nr' => $p_nr));
    $user = $statement->fetch();
    
    //Überprüfung des Passworts
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        die(header('Location: http://zeiterfassung-wbh.de/Dashboard.html'));
    } else {
        $errorMessage = 'Personalnummer oder Passwort bitte überprüfen. Weiter zum <a href="Login.html">Login</a><br>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset = "utf-8">
<title>Zeiterfassungs-Anwendung</title>
<link rel="stylesheet" href = "css/loginStyle.css">
<link rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Google font link -->
<link rel = "stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<script src="js/login.js" defer></script>
</head>

<body>
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}

?>


<h2>Arbeitszeiterfassung</h2>

<form class="modal-content animate" action="?login=1" method="post">

<div class="container">
<label for="uname"><b>Personalnummer</b></label>
<input type="text" placeholder="Bitte Personalnummer eingeben" name="p_nr" required>

<br>

<label for="psw"><b>Passwort</b></label>
<input type="password" placeholder="Bitte Passwort eingeben" name="password" required>

<button type="submit">Einloggen</button>

</div>

<div class="container" style="background-color:#f1f1f1">
<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Abbrechen</button>
<span class="psw"><a href="registration.php">Neuer Benutzer?</a></span>
</div>
</form>

</body>
</html>

