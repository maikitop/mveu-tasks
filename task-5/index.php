<?php
include_once 'database.php';
include_once 'post.php';

$database = new Database();
$db = $database->getConnection();

$post = new Post($db);
$stmt = $post->read();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой Блог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Мой Блог</h1>
        </div>
    </div>

    <div class="container">
        <a href="create.php" class="btn">Добавить новый пост</a>
        
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="post">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <div class="meta">
                    Опубликовано: <?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?>
                </div>
                <div class="content">
                    <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                </div>
                <div class="actions">
                    <form action="delete.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Вы уверены, что хотите удалить этот пост?')">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if ($stmt->rowCount() == 0): ?>
            <div class="post">
                <p>Пока нет постов. <a href="create.php">Добавьте первый пост!</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>