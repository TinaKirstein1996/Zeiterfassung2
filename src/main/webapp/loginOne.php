<?php
session_start();

$dbhost="localhost:3307";
$dbuser="root";
$dbpass="";
$dbname="time_tracking";

$pdo = new PDO('mysql:host=localhost:3307;dbname=time_tracking', 'root', '');

$p_nr = $_POST['p_nr'];
$password = $_POST['password'];
    
$statement = $pdo->prepare("SELECT * FROM users WHERE p_nr = :p_nr");
$result = $statement->execute(array('p_nr' => $p_nr));
$user = $statement->fetch();
    
//Überprüfung des Passworts
if ($user !== false && password_verify($password, $user['password'])) {
    $_SESSION['userid'] = $user['id'];
    die('Login erfolgreich. Weiter zu <a href="Dashboard.html">internen Bereich</a>');
} else {
    $errorMessage = 'Personalnummer oder Passwort bitte überprüfen. Weiter zum <a href="Login.html">Login</a><br>';
}

 
if(isset($errorMessage)) {
    echo $errorMessage;
}

?>