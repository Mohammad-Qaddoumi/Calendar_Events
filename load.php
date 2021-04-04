<?php
require_once "./admin/DataBase.php";
$connetion = new DataBase();
$link = $connetion->PDOConnection();

$data = array();
session_start();
$email = $_SESSION["email"];
// $email = "NewAccount";

$sql = "SELECT * FROM event_collection WHERE email =:email ORDER BY evt_start";

$stamt = $link->prepare($sql);

$stamt->execute(
    array(
        ':email' => $email
    )
);

$result = $stamt->fetchAll();

foreach ($result as $row) 
{
    $data[] = array(
        'id'             => $row['id'],
        'email'          => $row['email'],
        'title'          => $row['evt_collection'],
        'event'          => $row['event'],
        'start'          => $row['evt_start'],
        'end'            => $row['evt_end']
    );
}

echo json_encode($data);

?>
