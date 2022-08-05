<?php
require('dbconnect.php');

// 投稿一覧・・・1P20件づつ表示
$post = $db->prepare('select * from bbs order by id desc limit ?, 20');
if (!$post){
    die($db->error);
}

// ページング・・・投稿件数から最大ページ数を計算
$counts = $db->query('select count(*) as cnt from bbs');
$count = $counts->fetch_assoc();
$max_page = floor(($count['cnt']+1)/20+1);

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$page = ($page ?: 1);
$start = ($page - 1) * 20;
$post->bind_param('i', $start);
$result = $post->execute();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BBS</title>
</head>
<body>
  <h1>掲示板</h1>
  <hr>
    <h2>投稿フォーム</h2>
      <form action="post.php" method="post">
          <dt>投稿者名</dt>
          <dd>
            <textarea name="name" cols="20" rows="2" placeholder="名前を入力してください"></textarea>
          </dd>
          <dt>タイトル</dt>
          <dd>
            <textarea name="title" cols="50" rows="2" placeholder="タイトルを入力してください"></textarea>
          </dd>
          <dt>本文</dt>
          <dd>
            <textarea name="body" cols="50" rows="5" placeholder="本文を入力してください"></textarea>
          </dd>
          <button type="submit">投稿する</button>
      </form>
  <hr>

  <h2>投稿一覧</h2>
    <?php if(!$result): ?>
      <p>表示する投稿はありません</p>
    <?php endif; ?>
    <?php $post->bind_result($id, $name, $title, $body, $created); ?>
    <?php while ($post->fetch()): ?>
      <div>
          <dl>
            <p>投稿者名:
              <?php echo htmlspecialchars($name); ?>
            </p>
            <dt>タイトル</dt>
              <dd><?php echo htmlspecialchars($title); ?></a></dd>
            <dt>本文</dt>
              <dd><?php echo htmlspecialchars($body); ?></a></dd>
            <time>投稿日時:<?php echo htmlspecialchars($created); ?></time>
            <p><a href="update.php?id=<?php echo $id; ?>">編集</a> |
                <a href="delete.php?id=<?php echo $id; ?> ">削除</a></p>
          </dl>
      </div>
      <hr>
    <?php endwhile; ?>

    <p>
      <?php if ($page>1): ?>
        <a href="?page=<?php echo $page-1; ?>"><?php echo $page-1; ?>ページ目へ</a> |
      <?php endif; ?>
      <?php if ($page<$max_page): ?>
        <a href="?page=<?php echo $page+1; ?>"><?php echo $page+1; ?>ページ目へ</a>
      <?php endif; ?>
    </p>
</body>
</html>