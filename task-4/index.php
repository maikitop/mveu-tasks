<?php
class Product {
    public $name;
    public $price;
    
    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }
    
    public function getDiscountedPrice($percent) {
        $discount = $this->price * ($percent / 100);
        return $this->price - $discount;
    }
}
$discountPercent = 20;

$product1 = new Product("Ноутбук lenovo", 50000);
$product2 = new Product("Смартфон Apple", 25000);
$product3 = new Product("Наушники sony", 8000);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица товаров</title>
</head>
<style>
        th, td {
            border: 1px solid grey;
            padding: 12px;
        }
    </style>
<body>
    <table>
        <thead>
            <tr>
                <th>Название товара</th>
                <th>Цена</th>
                <th>Цена со скидкой</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $product1->name; ?></td>
                <td><?php echo $product1->price; ?></td>
                <td><?php echo $product1->getDiscountedPrice($discountPercent); ?></td>
            </tr>
            <tr>
                <td><?php echo $product2->name; ?></td>
                <td><?php echo $product2->price; ?></td>
                <td><?php echo $product2->getDiscountedPrice($discountPercent); ?></td>
            </tr>
            <tr>
                <td><?php echo $product3->name; ?></td>
                <td><?php echo $product3->price; ?></td>
                <td><?php echo $product3->getDiscountedPrice($discountPercent); ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>