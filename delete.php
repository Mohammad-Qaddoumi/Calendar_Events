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

if(isset($_POST["id"])){
    $sql = "DELETE FROM event_collection WHERE id=:id";
    $stamt = $link->prepare($sql);
    $stamt->execute(
        array(
            ':id' => $_POST['id']
        )
    );
}

