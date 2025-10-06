<?php
if ($_POST && isset($_POST['id'])) {
    include_once 'database.php';
    include_once 'post.php';

    $database = new Database();
    $db = $database->getConnection();

    $post = new Post($db);
    $post->id = $_POST['id'];

    if ($post->delete()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Ошибка при удалении поста.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>