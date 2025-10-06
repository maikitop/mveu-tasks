<?php
if ($_POST) {
    include_once 'database.php';
    include_once 'post.php';

    $database = new Database();
    $db = $database->getConnection();

    $post = new Post($db);

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];

    if ($post->create()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Ошибка при создании поста.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить пост - Мой Блог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Добавить новый пост</h1>
        </div>
    </div>

    <div class="container">
        <a href="index.php" class="btn">← Назад к списку постов</a>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" required maxlength="255">
            </div>
            
            <div class="form-group">
                <label for="content">Содержание:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            
            <button type="submit" class="btn">Создать пост</button>
        </form>
    </div>
</body>
</html>