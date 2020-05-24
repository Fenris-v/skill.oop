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
        return  "для вас создан заказ, на сумму: " . number_format($this->getPrice(), 0, '', ' ') . " руб. Состав:<br/>" . $this->basket->describe();
    }

    public function getPrice()
    {
        $basket = $this->basket;
        return $basket->getPrice($basket);
    }
}

class Basket
{
    public $basket;

    public function __construct($products = [])
    {
        if (isset($products[0]) && is_array(
                $products[0]
            ) && isset($products[0]['product']) && isset($products[0]['quantity'])) {
            $this->basket = $products;
        } elseif (isset($products['product']) && isset($products['quantity'])) {
            $this->basket[] = $products;
        }
    }

    public function addProduct(Product $product, $quantity)
    {
        $this->basket[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function getPrice($basket)
    {
        $sum = 0;
        foreach ($this->basket as $item) {
            $sum += (int)$item['quantity'] * $item['product']->getPrice($item['product']);
        }
        return $sum;
    }

    public function describe()
    {
        $basket = '';
        if (isset($this->basket[0]) && isset($this->basket[0]['product'])) {
            foreach ($this->basket as $item) {
                $basket .= $item['product']->getName() . " — " .
                    number_format($item['product']->getPrice(), 0, '', ' ') .
                    " руб. — " . $item['quantity'] . "<br/>";
            }
        } elseif (isset($this->basket['product'])) {
            $basket .= $this->basket['product']->getName() . " — " .
                number_format($this->basket['product']->getPrice(), 0, '', ' ') .
                " руб. — " . $this->basket['quantity'] . "<br/>";
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

echo '<a href="/">Вернуться на главную</a><br /><br />';

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

$user->notifyOnEmail($order->getBasket());
