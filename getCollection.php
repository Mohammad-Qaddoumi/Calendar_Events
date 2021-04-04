<?php

session_start();
session_regenerate_id(true);
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./admin/login.php");
    exit;
}

$collection = null;

require_once "./admin/DataBase.php";
$connetion = new DataBase();
$link = $connetion->PDOConnection();


$data = array();
$email = $_SESSION["email"];

$sql = "SELECT DISTINCT evt_collection FROM event_collection WHERE email =:email ORDER BY evt_collection";

$stamt = $link->prepare($sql);

$stamt->execute(
    array(
        ':email' => $email
    )
);

$result = $stamt->fetchAll();

foreach ($result as $row) {
    $data[] =  $row['evt_collection'];
}

echo json_encode($data);
?>