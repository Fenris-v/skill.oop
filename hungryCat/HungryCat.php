<?php

namespace App\HungryCat;

class HungryCat
{
    public $name;
    public $color;
    public $favoriteFood;

    public function __construct($name = 'Василий', $color = 'рыжий', $favoriteFood = 'корм')
    {
        $this->name = $name;
        $this->color = $color;
        $this->favoriteFood = $favoriteFood;
    }

    public function eat($food)
    {
        $catSay = "Голодный кот $this->name, особые приметы: цвет - $this->color, съел $food";
        if ($food === $this->favoriteFood) {
            $catSay .= " и замурчал 'мррррр' от своей любимой еды";
        }
        echo $catSay . '.<br/>';
    }
}

echo '<a href="/">Вернуться на главную</a><br /><br />';

$cat = new HungryCat();
$cat1 = new HungryCat('Пушок', 'белый', 'рыба');

$cat->eat('корм');
$cat->eat('рыба');
$cat->eat('паштет');
$cat->eat('мясо');
$cat->eat('рагу');

$cat1->eat('корм');
$cat1->eat('рыба');
$cat1->eat('паштет');
$cat1->eat('мясо');
$cat1->eat('рагу');
