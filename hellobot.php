<?php
// hello world telegram bot
$access_token = 'XXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXXXXXX';
$api = 'https://api.telegram.org/bot' . $access_token;
$output = json_decode(file_get_contents('php://input'), TRUE);

// for message:
$chat_id = $output['message']['chat']['id'];
$message = $output['message']['text'];
// for inline keyboard:
$inline_button1 = array("inline_message_id"=>"1","text"=>"Cyber Security News","url"=>'http://csn.net4me.net');
$inline_button2 = array("inline_message_id"=>"2","text"=>"Simple PHP Telegram Bots","url"=>'http://www.net4me.net/php/telegram-bot-php/');
$inline_keyboard1 = [[$inline_button1],[$inline_button2]];
$keyboard1=array("inline_keyboard"=>$inline_keyboard1);
$replyMarkup1 = json_encode($keyboard1);
// read incoming messages:
switch($message) {
    case '/start':
        $mess = 'Hello World!
This is test message';
        sendKeyboard($chat_id, $mess, $replyMarkup1);
    break;
}

function sendKeyboard($chat_id, $message, $replyMarkup) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&parse_mode=html&reply_markup=' . $replyMarkup);
}

