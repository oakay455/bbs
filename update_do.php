<?php
require('dbconnect.php');

$stmt = $db->prepare('update bbs set name=?, title=?, body=? where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);
$stmt->bind_param('sssi', $name, $title, $body, $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}

header('Location: index.php');
?>