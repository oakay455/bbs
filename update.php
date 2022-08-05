<?php
require('dbconnect.php');
$stmt = $db->prepare('select * from bbs where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt->bind_result($id, $name, $title, $body, $created);
$result = $stmt->fetch();
if (!$result) {
  die('投稿の指定が正しくありません');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿内容の編集</title>
</head>
<body>
  <h2>編集画面</h2>
    <form action="update_do.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        投稿者名<br>
        <textarea name="name" cols="20" rows="2" placeholder="名前を入力してください"><?php echo htmlspecialchars($name); ?></textarea><br>
        タイトル<br>
        <textarea name="title" cols="50" rows="2" placeholder="タイトルを入力してください"><?php echo htmlspecialchars($title); ?></textarea><br>
        本文<br>
        <textarea name="body" cols="50" rows="10" placeholder="本文を入力してください"><?php echo htmlspecialchars($body); ?></textarea><br>
        <button type="submit">更新する</button>
    </form>
</body>
</html>