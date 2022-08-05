<?php
require('dbconnect.php');

// 入力フォーム
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);

$stmt = $db->prepare('insert into bbs(name, title, body) values(?, ?, ?)');
if (!$stmt):
    die($db->error);
endif;
$stmt->bind_param('sss', $name,  $title, $body);
$ret = $stmt->execute();
if (!$ret) {
    die($db->error);
}
header('Location: index.php');５