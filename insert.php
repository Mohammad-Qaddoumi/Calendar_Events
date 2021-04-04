<?php
session_start();
session_regenerate_id(true);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./admin/login.php");
    exit;
}

require_once "./admin/DataBase.php";
$connetion = new DataBase();
$link = $connetion->PDOConnection();



$data = file_get_contents('php://input',true);
$json = json_decode($data,true);
if (count((array)$json) === 0){
    echo "Error";
    die;
}

// if(isset($_POST['title'])){


$sql = "INSERT INTO event_collection
    (email,evt_collection,event, evt_dic,evt_start,evt_end) 
    VALUES (:someone , :title, :event,:description,:start_event, :end_event)";
    
$stamt = $link->prepare($sql);

    // $stamt->execute(
    //     array(
    //         ':someone' => "someonne",
    //         ':title'    => $_POST['title'],
    //         ':start_event' => $_POST['start'],
    //         ':end_event' => $_POST['end'],
    //     )
    // );
 $stamt->execute(
        array(
            ':someone' => $_SESSION["email"],
            ':title'    => $json['title'],
            ':event'    => $json['event'],
            ':description'    => $json['description'],
            ':start_event' => $json['start'],
            ':end_event' => $json['end']
        )
    );
    // }

echo '{"success"}';

?>