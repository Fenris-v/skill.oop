<?php

namespace App\Zoo;

class Cat
{
    public $name;

    public function __construct($name = 'Кот')
    {
        $this->name = $name;
    }
}

class Dog
{
    public $name;

    public function __construct($name = 'Собака')
    {
        $this->name = $name;
    }
}

class Fish
{
    public $name;

    public function __construct($name = 'Рыбка')
    {
        $this->name = $name;
    }
}
echo '<a href="/">Вернуться на главную</a><br /><br />';

$cat = new Cat('Рыжик');
$cat1 = new Cat('Пушыстик');
$cat2 = new Cat('Снежок');
$dog = new Dog('Дружок');
$dog1 = new Dog('Шарик');
$dog2 = new Dog('Барбос');
$dog3 = new Dog('Рекс');
$dog4 = new Dog('Хатико');
$fish = new Fish('Голди');

var_dump($cat);
var_dump($cat1);
var_dump($cat2);
var_dump($dog);
var_dump($dog1);
var_dump($dog2);
var_dump($dog3);
var_dump($dog4);
var_dump($fish);
