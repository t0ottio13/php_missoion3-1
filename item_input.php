<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品登録画面</title>
</head>

<body>
  <form action="item_create.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>DB連携型todoリスト（入力画面）</legend>
      <a href="item_read.php">一覧画面</a>
      <div>
        商品名: <input type="text" name="item_name">
      </div>
      <div>
        値段: <input type="number" name="price">
      </div>
      <div>
        在庫数: <input type="number" name="stock">
      </div>
      <div>
        画像: <input type="file" name="item_image" accept="image/*">
      </div>
      <div>
        <button>送信</button>
      </div>
    </fieldset>
  </form>

</body>

</html>