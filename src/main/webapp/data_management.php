<?php
session_start();

$userid = $_SESSION['userid'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$pause_time = $_POST['pause_time'];
$end_time = $_POST['end_time'];
$note = $_POST['note'];

if (!empty($date) || !empty($start_time) || !empty($end_time)) {
    $dbhost="rdbms.strato.de";
    $dbuser="dbu433728";
    $dbpass="projektarbeit";
    $dbname="dbs9413900";
    
    $connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    
    if (mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        
        $SELECT = "SELECT note From tracked_time Where note = ? Limit 1";
        $SELECTp_nr = "SELECT p_nr From users Where id = ? Limit 1";
        $INSERT = "INSERT INTO tracked_time (p_nr, date, start_time, pause_time, end_time, note) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $connect->prepare($SELECTp_nr);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->bind_result($p_nr);
        $stmt->fetch();
        
        if ($p_nr!==0) {
            $stmt->close();
            
            $stmt=$connect->prepare($INSERT);
            $stmt->bind_param("isssss", $p_nr, $date, $start_time, $pause_time, $end_time, $note);
            $stmt->execute();
            header('Location: http://zeiterfassung-wbh.de/Dashboard.html');
            exit;
        } else {
            echo "Diese Personalnummer ist leider nicht verfügbar";
            header('Location: http://zeiterfassung-wbh.de/Dashboard.html');
            exit;
        }
        $stmt->close();
        $connect->close();
    }
} else {
    echo "Alle Felder müssen ausgefüllt werden!";
    die;}


?>