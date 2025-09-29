<?php
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $data = [
            'name' => htmlspecialchars($name),
            'email' => htmlspecialchars($email),
            'password' => htmlspecialchars($password)
        ];
    } else {
        echo 'Некорректный формат email';
    }
}
?>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма регистрации</title>
</head>
<body>
    <h2>Регистрация</h2>

    <form method="post">
        <div>
            <label>Имя: <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"></label>
        </div>
        <div>
            <label>Email: <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label>
        </div>
        <div>
            <label>Пароль: <input type="password" name="password"></label>
        </div>
        <button type="submit">Зарегистрироваться</button>
    </form>

    <?php if (!empty($data)): ?>
        <h3>Данные успешно приняты:</h3>
        <pre><?php print_r($data); ?></pre>
    <?php endif; ?>
</body>
</html>