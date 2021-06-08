<?php

include('./functions.php');
$pdo = connect_to_db();
// $dbn = 'mysql:dbname=YOUR_DB_NAME;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }



$sql = 'SELECT * FROM item';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
  $output = "";
  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["item_name"]}</td>";
    $output .= "<td>{$record["price"]}円</td>";
    $output .= "<td>{$record["stock"]}</td>";
    $output .= "<td><img src=img/{$record["item_image"]}></td>";
    // edit deleteリンクを追
    $output .= "<td>
                  <a href='./item_edit.php?item_id={$record["item_id"]}'>edit</a>
                </td>";
    $output .= "<td>
                  <a href='./item_delete.php?item_id={$record["item_id"]}'>delete</a>
                </td>";
    $output .= "</tr>";
  }
  // $recordの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($record);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品表示</title>
</head>

<body>
  <fieldset>
    <legend>商品一覧</legend>
    <a href="item_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>商品名</th>
          <th>値段</th>
          <th>在庫数</th>
          <th>画像</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>