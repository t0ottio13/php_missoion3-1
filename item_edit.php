<?php
  // var_dump($_GET);
  // exit;
  include('./functions.php');
  $item_id = $_GET["item_id"];
  $pdo = connect_to_db();
  $sql = 'SELECT * FROM item WHERE item_id= :item_id';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
  $status = $stmt->execute();

  if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    // 一つのデータをとってくる
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
  }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品登録編集画面</title>
</head>

<body>
  <form action="item_update.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>商品登録（編集画面）</legend>
      <a href="item_read.php">一覧画面</a>
      <div>
        商品名: <input type="text" name="item_name" value="<?=$record['item_name']?>">
      </div>
      <div>
        値段: <input type="number" name="price" value="<?=$record['price']?>">
      </div>
      <div>
        在庫数: <input type="number" name="stock" value="<?=$record['stock']?>">
      </div>
      <div>
        画像: <input type="file" name="item_image" accept="image/*">
      </div>
      <div>
        <input type="hidden" name="item_id" value="<?=$record['item_id']?>" >
      </div>
      <div>
        <button>submit</button>
      </div>

    </fieldset>
  </form>

</body>

</html>