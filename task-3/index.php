<?php
session_start();

if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
} else {
    $_SESSION['visit_count'] ++;
}

if ($_SESSION['visit_count'] == 1) {
    $message = "Добро пожаловать! Это ваш первый визит.";
} else {
    $message = "С возвращением!";
}
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система посещений</title>
</head>
<body>
    <div class="message">
        <h1><?php echo $message; ?></h1>
    </div>
    
    <div class="counter">
        <p>Количество посещений: <?php echo $_SESSION['visit_count']-1; ?></p>
    </div>