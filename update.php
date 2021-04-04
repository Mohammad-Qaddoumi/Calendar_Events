<?php
require_once "./admin/DataBase.php";
$connetion = new DataBase();
$link = $connetion->PDOConnection();

// if(isset($_POST["id"])){
    $sql = "UPDATE event_collection
            SET evt_collection=:title, evt_start=:start, evt_end=:end
            WHERE id=:id
    ";
// }
$json = json_decode(file_get_contents('php://input',true),true);
$stamt = $link->prepare($sql);
// $stamt->execute(
//     array(
//         ':title' => $_POST['title'],
//         ':start' => $_POST['start'],
//         ':end' => $_POST['end'],
//         ':id' => $_POST['id']
//     )
// );
$stamt->execute(
    array(
        ':id' => $json['id'],
        ':title'    => $json['title'],
        ':start' => $json['start'],
        ':end' => $json['end']
    )
);


?>

