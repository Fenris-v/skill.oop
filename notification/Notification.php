<?php

namespace App\Notification;

class User
{
    public $name;
    public $mail;
    public $age;
    public $gender;
    public $phone;

    public function __construct($name, $mail, $age = 0, $gender = 'unknown', $phone = '')
    {
        $this->name = $name;
        $this->mail = $mail;
        $this->age = $age;
        $this->gender = $gender;
        $this->phone = $phone;
    }

    public function notifyOnEmail($message)
    {
        $notify = new Notification($this->name, 'mail', $this->mail);
        $notify->send($message);
    }

    public function notifyOnPhone($message)
    {
        if (!isset($this->phone) || $this->phone === '') {
            echo "Пользователь $this->name не указал свой телефон <br/>";
            return;
        }
        $notify = new Notification($this->name, 'phone', $this->phone);
        $notify->send($message);
    }

    public function notify($message)
    {
        $this->notifyOnEmail($message);

        if (!isset($this->phone) || $this->phone === '') {
            return;
        }

        $this->notifyOnPhone($message);
    }

    public function censor($message)
    {
        if (stripos($message, '*') !== false) {
            echo 'Сообщение не прошло цензуру <br/>';
        } else {
            echo 'Сообщение прошло цензуру <br/>';
            $this->notifyOnEmail($message);
        }
    }
}

class Notification
{
    public $receiver;
    public $via;
    public $to;

    public function __construct($receiver, $via, $to)
    {
        $this->receiver = $receiver;
        $this->via = $via === 'phone' ? 'телефон клиента' : 'email клиента';
        $this->to = $to;
    }

    public function send($message)
    {
        echo "Уведомление клиенту: $this->receiver на $this->via $this->to: $message <br/>";
    }
}

echo '<a href="/">Вернуться на главную</a><br /><br />';

$user = new User('Пользователь', 'user@gmail.com');
$user1 = new User('Новичок', 'new-user@gmail.com');
$user1->phone = '+7 999 999 99 99';
$user2 = new User('Тестировщик', 'test-user@gmail.com', 16, 'man', '+7 999 999 99 99');
$user3 = new User('Админ', 'super-user@gmail.com', 18, 'man', '+7 999 999 99 99');

$user->notifyOnEmail('Сообщение');
$user->notifyOnPhone('Сообщение');
$user1->notifyOnPhone('Сообщение 2');
if (isset($user2->age) && $user2->age >= 18) {
    $user2->notify('Сообщение * 31');
    $user2->notify('Сообщение 32');
} else {
    $user2->censor('Сообщение * 33');
    $user2->censor('Сообщение 34');
}
if (isset($user3->age) && $user3->age >= 18) {
    $user3->notifyOnPhone('Сообщение 4');
} else {
    $user3->censor('Сообщение 4');
}

$user->notify('Новое сообщение');
$user1->notify('Очередное сообщение');
