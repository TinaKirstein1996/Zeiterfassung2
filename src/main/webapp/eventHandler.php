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
    
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);
        
        if($jsonObj->request_type == 'addEvent') {
            $start = $jsonObj -> start;
            $end = $jsonObj -> end;
            
            $event_data = $jsonObj->event_data;
            $eventStart = !empty($event_data[0])?$event_data[0]:'';
            $eventEnd = !empty($event_data[1])?$event_data[1]:'';
            $eventPause = !empty($event_data[2])?$event_data[2]:'';
            $eventNote = !empty($event_data[3])?$event_data[3]:'';
            
            $worked_start = $start." ".$eventStart;
            $worked_pause = $start." ".$eventPause;
            $worked_end = $start." ".$eventEnd;
            $starttimestamp = strtotime($worked_start);
            $endtimestamp = strtotime($worked_end);
            
            if(!empty($eventStart)) {
                $sqlQ = "INSERT INTO tracked_time (title, p_nr, date, start_time, pause_time, end_time, note, working_hours) VALUES (?,?,?,?,?,?,?,?)";
                
                
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
                
                $working_hours = differenceInHours($worked_start,$worked_end, $worked_pause, $start);
                $title="Zeit: ".$working_hours." h ";
                
                
                $stmt = $connect->prepare($sqlQ);
                $stmt->bind_param("sissssss", $title, $p_nr, $start, $eventStart, $eventPause, $eventEnd, $eventNote,$working_hours);
                $insert = $stmt->execute();
                
                if($insert){
                    $output = [
                        'status' => 1
                    ];
                    echo json_encode($output);
                } else {
                    echo json_encode(['error' => 'Event Add request failed!']);
                }
            }
        }elseif($jsonObj->request_type == 'deleteEvent'){
            $id = $jsonObj->event_id;
                
            $sql = "DELETE FROM tracked_time WHERE id = $id";
            $delete = $connect->query($sql);
                
            if($delete){
                $output = [
                'status' => 1
                ];
                echo json_encode($output);
            } else {
                echo json_encode(['error' => 'Event Delete request failed!']);
            }   
            
        }
    }
    
}