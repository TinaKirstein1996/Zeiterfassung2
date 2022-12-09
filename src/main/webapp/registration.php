<?php
$p_nr = $_POST['p_nr'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$weekly_workinghours = $_POST['weekly_workinghours'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$pause_time = $_POST['pause_time'];

if (!empty($p_nr) || !empty($email) || !empty($password) || !empty($password2)) {
    $dbhost="localhost:3307";
    $dbuser="root";
    $dbpass="";
    $dbname="time_tracking";
    
    $connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    
    if (mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        
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
        
        
        $SELECT = "SELECT email From users Where email = ? Limit 1";
        $INSERT = "INSERT INTO users (p_nr, email, password, weekly_workinghours, start_time, end_time, pause_time) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $connect->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        
        if ($rnum==0) {
            $stmt->close();
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt=$connect->prepare($INSERT);
            $stmt->bind_param("ississs", $p_nr, $email, $password_hash, $weekly_workinghours, $start_time, $end_time, $pause_time);
            $stmt->execute();
            echo 'Registrierung erfolgreich abgeschlossen! <a href="Login.html">Zum Login</a>';
        } else {
            echo 'Diese E-Mail Adresse wurde bereits verwendet. <a href="Login.html">Zum Login</a>';
        }
        $stmt->close();
        $connect->close();
    }
} else {
    echo "Alle Felder müssen ausgefüllt werden!";
    die;
}
        
   

?>