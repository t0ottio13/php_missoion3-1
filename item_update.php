<?php
// var_dump($_FILES);
// exit();

include('functions.php');
$pdo= connect_to_db();

if (
    !isset($_FILES['item_image']['name']) || $_FILES['item_image']['name'] == '' ||
    !isset($_POST['item_name']) || $_POST['item_name'] == '' ||
    !isset($_POST['price']) || $_POST['price'] == '' ||
    !isset($_POST['stock']) || $_POST['stock'] == ''
) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

$item_name = $_POST["item_name"];
$price = $_POST["price"];
$item_id = $_POST["item_id"];
$stock = $_POST["stock"];
$item_image = $_FILES['item_image']['name'];

$sql = "UPDATE item SET item_name=:item_name, price=:price, stock=:stock, item_image=:item_image,
updated_at=sysdate() WHERE item_id=:item_id";

// item_imageがNULLになっていて500エラーが出た
// edit.phpのformタグにenctypeオプションをつけてなかった。
// var_dump($item_image);
// exit();

$upload = "img/";
if (move_uploaded_file($_FILES['item_image']['tmp_name'], $upload . $item_image)) {
} else {
    // echo 'アップロード失敗';
}


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
$stmt->bindValue(':item_image', $item_image, PDO::PARAM_STR);
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
