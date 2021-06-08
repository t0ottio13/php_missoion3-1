<?php

// var_dump($_POST);
// exit();
// var_dump($_FILES);
// exit();

include('./functions.php');
$pdo = connect_to_db();

if (
  !isset($_FILES['item_image']['name']) || $_FILES['item_image']['name'] == '' ||
  !isset($_POST['item_name']) || $_POST['item_name'] == '' ||
  !isset($_POST['price']) || $_POST['price'] == '' ||
  !isset($_POST['stock']) || $_POST['stock'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$name = $_POST['item_name'];
$price= $_POST['price'];
$stock = $_POST['stock'];
$image = $_FILES['item_image']['name'];

$upload = "img/";
if (move_uploaded_file($_FILES['item_image']['tmp_name'], $upload . $image)) {
    echo 'アップロード成功';
} else {
    echo 'アップロード失敗';
}

// $dbn = 'mysql:dbname=gsacf_l05_06;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }


$sql = 'INSERT INTO item(item_id, item_name, price, stock, item_image, non_active, created_at, updated_at)VALUES(NULL,:name,:price,:stock,:item_image,0,sysdate(),sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
$stmt->bindValue(':item_image', $image, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:item_input.php");
  exit();
}
