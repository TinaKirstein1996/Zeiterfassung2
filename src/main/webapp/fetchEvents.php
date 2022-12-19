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

        $where_sql = '';
        if(empty($_GET['start_time']) && empty($_GET['end_time'])){
            $where_sql .= " WHERE date = '".$_GET['date']."' AND  p_nr = $p_nr ";
        }
        
        $sql = "SELECT * FROM tracked_time WHERE p_nr = $p_nr";
        $result = $connect->query($sql);
        
        $eventsArr = array();
        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($eventsArr, $row);
            }
        }
        
        echo json_encode($eventsArr);
    }
}