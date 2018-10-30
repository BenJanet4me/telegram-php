<?php
/**
 * Telegram Bot Debuger access token и URL.
 */
$access_token = 'XXXXX:XXXXXXXXXXXXXXXXXXXXXXX';
$api = 'https://api.telegram.org/bot' . $access_token;
/**
 * Задаём основные переменные.
 */
$output = json_decode(file_get_contents('php://input'), TRUE);
@$chat_id = $output['message']['chat']['id'];
@$message = $output['message']['text'];

switch($message) {
  case '/start':
    sendMessage($chat_id, "\xF0\x9F\x93\xA1 бот debugger на связи!");
  break;
  default:
    $myDebug = "<pre>". json_encode($output) ."</pre>"; sendMessage($chat_id, $myDebug);
  break;
}

function sendMessage($chat_id, $message) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&parse_mode=html');
}
