<?php
// var_dump($_GET);
// exit();

include('./functions.php');
$pdo=connect_to_db();

$item_id=$_GET["item_id"];


$sql = 'DELETE FROM item WHERE item_id =:item_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
    } else {
    header("Location:item_read.php");
    exit();
}
