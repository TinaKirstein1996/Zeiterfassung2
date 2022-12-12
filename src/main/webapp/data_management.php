<?php

$p_nr = $_POST['p_nr'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$pause_time = $_POST['pause_time'];
$end_time = $_POST['end_time'];
$note = $_POST['note'];

if (!empty($p_nr) || !empty($date) || !empty($start_time) || !empty($end_time)) {
    $dbhost="rdbms.strato.de";
    $dbuser="dbu433728";
    $dbpass="projektarbeit";
    $dbname="dbs9413900";
    
    $connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    
    if (mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT note From tracked_time Where note = ? Limit 1";
        $INSERT = "INSERT INTO tracked_time (p_nr, date, start_time, pause_time, end_time, note) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $connect->prepare($SELECT);
        $stmt->bind_param("s", $note);
        $stmt->execute();
        $stmt->bind_result($note);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        
        if ($rnum==0) {
            $stmt->close();
            
            $stmt=$connect->prepare($INSERT);
            $stmt->bind_param("isssss", $p_nr, $date, $start_time, $pause_time, $end_time, $note);
            $stmt->execute();
            echo "Daten erfolgreich eingetragen!";
        } else {
            echo "Diese Notiz wurde bereits verwendet";
        }
        $stmt->close();
        $connect->close();
    }
} else {
    echo "Alle Felder müssen ausgefüllt werden!";
    die;
}

?>