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
            
            if(!empty($eventStart)) {
                $sqlQ = "INSERT INTO tracked_time (title, p_nr, date, start_time, pause_time, end_time, note) VALUES (?,?,?,?,?,?,?)";
                $title="Arbeitszeiterfassung $start";
                
                
                $stmt = $connect->prepare($sqlQ);
                $stmt->bind_param("sisssss", $title, $p_nr, $start, $eventStart, $eventPause, $eventEnd, $eventNote);
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