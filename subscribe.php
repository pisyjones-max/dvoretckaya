<?php
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['message']['chat']['id'])) exit;

$chat_id = $input['message']['chat']['id'];
$file = 'subscribers.json';
$subscribers = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

if (!in_array($chat_id, $subscribers)) {
    $subscribers[] = $chat_id;
    file_put_contents($file, json_encode($subscribers, JSON_PRETTY_PRINT));
}

// Ответ пользователю
$token = "8288844028:AAHmXPVi3TmwyvTu_sfTrL2jfL15_lR2KOc";
$text = "Вы подписались на уведомления о новых заказах!";
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($text));
