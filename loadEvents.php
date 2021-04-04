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
$email = $_SESSION["email"];
// $email = "newAccount";
if(isset($_POST['collection']))
{   
    $collection = $_POST['collection'];
    $sql = "SELECT evt_collection,event, evt_dic,evt_start,evt_end FROM event_collection WHERE email=:email AND evt_collection=:collec";
    $stamt = $link->prepare($sql);
    $stamt->execute(
        array(
            ':email' => $email,
            ':collec' => $collection
        )
    );
    
    $result = $stamt->fetchAll();
    $data = array();
    foreach ($result as $row) {
        $data[] = array(
             $row['evt_collection'],
             $row['event'],
             $row['evt_dic'],
             $row['evt_start'],
             $row['evt_end']
        );
    }
    // echo "done";
    echo json_encode($data);
}
// echo "working";





?>