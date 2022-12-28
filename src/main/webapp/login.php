<?php
session_start();

$dbhost="rdbms.strato.de";
$dbuser="dbu433728";
$dbpass="projektarbeit";
$dbname="dbs9413900";

$pdo = new PDO('mysql:host=rdbms.strato.de;dbname=dbs9413900', 'dbu433728', 'projektarbeit');


$p_nr = $_POST['p_nr'];
$password = $_POST['password'];
    
$statement = $pdo->prepare("SELECT * FROM users WHERE p_nr = :p_nr");
$result = $statement->execute(array('p_nr' => $p_nr));
$user = $statement->fetch();
    
//Überprüfung des Passworts
if ($user !== false && password_verify($password, $user['password'])) {
    $_SESSION['userid'] = $user['id'];
    die(header('Location: http://zeiterfassung-wbh.de/Dashboard.php'));
} else {
    $errorMessage = 'Fehler bei der Anmeldung, Personalnummer oder Passwort waren Falsch bitte <a href="index.html">hier</a> erneut einloggen.<br>';
}

if(isset($errorMessage)) {
    echo $errorMessage;
}

?>


