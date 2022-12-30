<?php
session_start();

$userid = $_SESSION['userid'];

$dbhost="rdbms.strato.de";
$dbuser="dbu433728";
$dbpass="projektarbeit";
$dbname="dbs9413900";

$connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if (mysqli_connect_error()){
    die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
} else {
    
    $SELECTp_nr = "SELECT p_nr From users Where id = ? Limit 1";
    $stmt = $connect->prepare($SELECTp_nr);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->bind_result($p_nr);
    $stmt->fetch();
    
    if ($p_nr!==0) {
        $stmt->close();
        
        $INSERT = "INSERT INTO tracked_time (title, p_nr, date, start_time, pause_time, end_time, note, working_hours) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        date_default_timezone_set('Europe/Berlin');
        $current_date = date('Y-m-d');
        
        $start_time = "SELECT start_time From users Where p_nr = ? Limit 1";
        $pause_time = "SELECT pause_time From users Where p_nr = ? Limit 1";
        $end_time = "SELECT end_time From users Where p_nr = ? Limit 1";
        $note = "Schnellerfassung";
        
        $stmt = $connect->prepare($start_time);
        $stmt->bind_param("i", $p_nr);
        $stmt->execute();
        $stmt->bind_result($start_time);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $connect->prepare($pause_time);
        $stmt->bind_param("i", $p_nr);
        $stmt->execute();
        $stmt->bind_result($pause_time);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $connect->prepare($end_time);
        $stmt->bind_param("i", $p_nr);
        $stmt->execute();
        $stmt->bind_result($end_time);
        $stmt->fetch();
        $stmt->close();
        
        
        $worked_start = $current_date." ".$start_time;
        $worked_pause = $current_date." ".$pause_time;
        $worked_end = $current_date." ".$end_time;
        $starttimestamp = strtotime($worked_start);
        $endtimestamp = strtotime($worked_end);
        
        function differenceInHours($worked_start,$worked_end,$worked_pause, $date){
            $starttimestamp = strtotime($worked_start);
            $endtimestamp = strtotime($worked_end);
            $pausetimestamp = strtotime($worked_pause);
            $differenceHours = abs(($endtimestamp - $starttimestamp)/3600);
            $differenceMinutes = abs(($endtimestamp - $starttimestamp)/60);
            if ($differenceMinutes % 60 != 0){
                $differenceHours = floor($differenceHours);
                if ($differenceMinutes % 60 <= 9) {
                    $differenceMinutes = "0".($differenceMinutes % 60);
                } else {
                    $differenceMinutes = ($differenceMinutes % 60);
                }
            } else {
                $differenceMinutes = "00";
            }
            
            if ($pausetimestamp != 0){
                $differenceTime = $date." ".$differenceHours.":".$differenceMinutes.":00";
                $differencetimestemp = strtotime($differenceTime);
                $differenceHours = abs(($differencetimestemp - $pausetimestamp)/3600);
                $differenceMinutes = abs(($differencetimestemp - $pausetimestamp)/60);
                if ($differenceMinutes % 60 != 0){
                    $differenceHours = floor($differenceHours);
                    if ($differenceMinutes % 60 <= 9) {
                        $differenceMinutes = "0".($differenceMinutes % 60);
                    } else {
                        $differenceMinutes = ($differenceMinutes % 60);
                    }
                } else {
                    $differenceMinutes = "00";
                }
            }
            $difference = $differenceHours.":".$differenceMinutes.":00";
            return $difference;
        }
        
        $working_hours = differenceInHours($worked_start,$worked_end, $worked_pause, $current_date);
        $title="Zeit: ".$working_hours." h ";
        
        $stmt=$connect->prepare($INSERT);
        $stmt->bind_param("sissssss",$title, $p_nr, $current_date, $start_time, $pause_time, $end_time, $note, $working_hours);
        $stmt->execute();
        header('Location: http://zeiterfassung-wbh.de/Dashboard.php');
        exit;
    } else {
        header('Location: http://zeiterfassung-wbh.de/Dashboard.php');
        exit;
    }
    $stmt->close();
    $connect->close();
}
?>