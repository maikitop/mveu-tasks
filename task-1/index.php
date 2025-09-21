<?php
 if (isset($_GET['name']) && isset($_GET['age'])) {
    $name = htmlspecialchars($_GET['name']);
    $age = (int)$_GET['age'];
 }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Демонстрация PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .section { margin-bottom: 20px; padding: 15px; border-left: 4px solid #4CAF50; background: #f9f9f9; }
        h1, h2, h3 { color: #333; }
        form { margin: 10px 0; }
        input[type="text"] { padding: 8px; width: 250px; }
        input[type="submit"] { padding: 8px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Демонстрация работы PHP</h1>
    <div class="section">
        <h2>Пример формы</h2>
        <form method="get">
            <input type="text" name="name" placeholder="Введите имя">
            <input type="number" name="age" placeholder="Ваш возраст">
            <input type="submit" value="Отправить">
        </form>
    </div>
    <div class="section">
        <h2>Основная информация</h2> 
        <p>Здравствуйте <?=$name ?> Вам <?= $age ?> лет.</p>
        <p>Возрастная группа: <?= $age >= 18 ? 'Совершеннолетний(яя)' : 'Несовершеннолетний(яя)' ?></p>
    </div>
</html>