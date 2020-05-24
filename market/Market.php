<?php

namespace App\Market;

use App\Notification;
use App\Notification\User;

require $_SERVER['DOCUMENT_ROOT'] . '/notification/Notification.php';

class Order
{
    public $basket;

    public function __construct($basket)
    {
        $this->basket = $basket;
    }

    public function getBasket()
    {
        return $this->basket;
    }

    public function getPrice()
    {
        return $this->basket->getPrice();
    }
}

class Basket
{
    public $products;

    public function __construct($products = [])
    {
        if (isset($products[0]) && is_array(
                $products[0]
            ) && isset($products[0]['product']) && isset($products[0]['quantity'])) {
            $this->products = $products;
        } elseif (isset($products['product']) && isset($products['quantity'])) {
            $this->products[] = $products;
        }
    }

    public function addProduct(Product $product, $quantity)
    {
        $this->products[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function getPrice()
    {
        $sum = 0;
        foreach ($this->products as $item) {
            $sum += (int)$item['quantity'] * $item['product']->getPrice($item['product']);
        }
        return $sum;
    }

    public function describe()
    {
        $basket = '';
        if (isset($this->products[0]) && isset($this->products[0]['product'])) {
            foreach ($this->products as $item) {
                $basket .= $item['product']->getName() . " — " .
                    number_format($item['product']->getPrice(), 0, '', ' ') .
                    " руб. — " . $item['quantity'] . "<br/>";
            }
        }
        return $basket;
    }
}

class Product
{
    public $name;
    public $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}

echo '<hr /><a href="/">Вернуться на главную</a><br /><br />';

$product = new Product('TV', 50000);
$product1 = new Product('PC', 90000);
$product2 = new Product('Mac', 150000);
$product3 = new Product('Tesla', 500000);

$basket = new Basket();
$basket->addProduct($product, 5);
$basket->addProduct($product3, 1);
$basket->addProduct($product2, 10);
$basket->addProduct($product1, 1);

$order = new Order($basket);

$user = new User('Николай Николаича', 'nn@gmail.com');

$user->notifyOnEmail(
    "для вас создан заказ, на сумму: " . number_format($order->getPrice(), 0, '', ' ')
    . " руб. Состав:<br/>" . $order->getBasket()->describe()
);
