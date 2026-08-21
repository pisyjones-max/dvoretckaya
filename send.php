<?php
$token = "8288844028:AAHmXPVi3TmwyvTu_sfTrL2jfL15_lR2KOc";

// Получаем JSON из POST
$input = json_decode(file_get_contents('php://input'), true);

$name = htmlspecialchars($input['name'] ?? '');
$phone = htmlspecialchars($input['phone'] ?? '');
$message = htmlspecialchars($input['message'] ?? '');

if (empty($name) || empty($phone)) {
    echo json_encode(["status" => "error", "message" => "Имя и телефон обязательны"]);
    exit;
}

// Текст сообщения
$text = "📩 Новая заявка с сайта\n";
$text .= "👤 Имя: $name\n";
$text .= "📞 Телефон: $phone\n";
if ($message) $text .= "💬 Сообщение: $message";

// Читаем подписчиков
$subscribers_file = 'subscribers.json';
$subscribers = file_exists($subscribers_file) ? json_decode(file_get_contents($subscribers_file), true) : [];

// Отправляем всем
foreach ($subscribers as $chat_id) {
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($text));
}

echo json_encode(["status" => "ok"]);
