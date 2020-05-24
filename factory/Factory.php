<?php

namespace App\Factory;

class ToyFactory
{
    public function createToy($name)
    {
        return new Toy($name, rand(100, 10000));
    }
}

class Toy
{
    public $name;
    public $price;

    public function __construct($name = 'Безымянная игрушка', $price = 0)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

echo '<a href="/">Вернуться на главную</a><br /><br />';

$countToys = rand(5, 20);
$toys = [];
for ($i = 0; $i < $countToys; $i++) {
    $factory = new ToyFactory();
    $names = ['Солдатик', 'Машинка', 'Кукла', 'Конструктор', 'Пазл'];
    shuffle($names);
    $toys[] = $factory->createToy($names[0]);
}

$sum = 0;
foreach ($toys as $toy) {
    echo $toy->name . ' - ' . number_format($toy->price, 0, '', ' ') . '<br/>';
    $sum += $toy->price;
}

echo '<br/><br/>Итого - ' . number_format($sum, 0, '', ' ');
