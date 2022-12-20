<?php
session_start();

$userid = $_SESSION['userid'];
$date = $_POST['date'];
$start_time_hour = $_POST['hour_start'];
$start_time_minute = $_POST['minute_start'];
$pause_time_start = $_POST['hour_pause'];
$pause_time_minute = $_POST['max_pause'];
$end_time_hour = $_POST['hour_end'];
$end_time_hour = $_POST['minute_end'];
$note = $_POST['note'];

if (!empty($date) || !empty($start_time_hour) || !empty($end_time_hour)) {
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
        $INSERT = "INSERT INTO tracked_time (title, p_nr, date, start_time, pause_time, end_time, note, working_hours) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        
        $stmt = $connect->prepare($SELECTp_nr);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $stmt->bind_result($p_nr);
        $stmt->fetch();
        
        if ($p_nr!==0) {
            $stmt->close();
            
            $title="Arbeitszeiterfassung ".$_POST['date']."  ";
            $start_time = $_POST['hour_start'].":".$_POST['minute_start'];
            $pause_time = $_POST['hour_pause'].":".$_POST['max_pause'];
            $end_time = $_POST['hour_end'].":".$_POST['minute_end'];
            
            $worked_start = $_POST['date']." ".$start_time;
            $worked_end = $_POST['date']." ".$end_time;
            $starttimestamp = strtotime($worked_start);
            $endtimestamp = strtotime($worked_end);
            
            function differenceInHours($worked_start,$worked_end){
                $starttimestamp = strtotime($worked_start);
                $endtimestamp = strtotime($worked_end);
                $difference = abs(($endtimestamp - $starttimestamp)/3600);
                return $difference;
            }
            
            $working_hours = differenceInHours($worked_start,$worked_end);
            
            $stmt=$connect->prepare($INSERT);
            $stmt->bind_param("sissssss",$title, $p_nr, $date, $start_time, $pause_time, $end_time, $starttimestamp, $working_hours);
            $stmt->execute();
            header('Location: http://zeiterfassung-wbh.de/Dashboard.html');
            exit;
        } else {
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