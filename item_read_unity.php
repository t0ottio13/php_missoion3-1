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
// echo("接続成功!! <br><br>");


$sql = 'SELECT * FROM item';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = array();
    // var_dump($output);
    // exit;
    foreach ($result as $record) {
        // echo($record["item_name"] .$record["price"] .$record["price"]+"円" .$record["stock"]+"個") ;
        // echo($record['item_name']);
        // exit;
        $data = array($record['item_name'],$record["price"],$record["stock"]);
        $output[]=$data;
        // var_dump($data);
        // exit;
        // echo($data);
        // $output.= "[{$record["item_name"]},{$record["price"]},{$record["stock"]}]";
        // $output .= "<tr>";
        // $output .= "<td>{$record["item_name"]}</td>";
        // $output .= "<td>{$record["price"]}円</td>";
        // $output .= "<td>{$record["stock"]}個</td>";
        // $output .= "<td><img src=img/{$record["item_image"]}></td>";
        // edit deleteリンクを追
        // $output .= "<td>
        //             <a href='./item_edit.php?item_id={$record["item_id"]}'>edit</a>
        //             </td>";
        // $output .= "<td>
        //             <a href='./item_delete.php?item_id={$record["item_id"]}'>delete</a>
        //             </td>";
        // $output .= "</tr>";
        // $output .= "</br>";
    }
    echo(json_encode($output));
    // echo($output);
    // $recordの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}
?>