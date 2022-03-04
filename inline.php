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
@$callback_query = $output['callback_query'];
@$data = $callback_query['data'];
@$chat_id_in = $callback_query['message']['chat']['id'];
@$message_id = $callback_query['message']['message_id'];

// inline keyboard set:
$inline_button3 = array("inline_message_id"=>"3","text"=>"show all","callback_data"=>'/1');
$inline_button4 = array("inline_message_id"=>"4","text"=>"show callback","callback_data"=>'/2');
$inline_keyboard1 = [[$inline_button3,$inline_button4]];
$keyboard1=array("inline_keyboard"=>$inline_keyboard1);

// do markup with inline keyboard:
$replyMarkup1 = json_encode($keyboard1);
switch($message) {
    case '/start':
    	sendMessage($chat_id, "\xF0\x9F\x93\xA1 бот debugger на связи!");
    break;
    default:
		$myDebug = "<pre>". json_encode($output) ."</pre>";
		sendKeyboard($chat_id, $myDebug, $replyMarkup1); //send message with inline keyboard
    break;
}
// callback data
switch($data){
	case '/1':
		// чтоб не крутились часы, посылаем пустой ответ при нажатии на кнопку.
		// for delete "clock" on keyboard button - send null callback query answer:
		send_answerCallbackQuery($callback_query['id'], null, false);
		$myDebug = "<pre>". json_encode($output) ."</pre>";
		sendKeyboard($chat_id_in, $myDebug);
    break;
	case '/2':
		send_answerCallbackQuery($callback_query['id'],'callback id: ' . $callback_query['id'],true);
		$myDebug = "<pre>". json_encode($output) ."</pre>";
		sendKeyboard($chat_id_in, $myDebug);
    break;
}

// Вместо универсальной функции, для наглядности используем различные функции отправки сообщений.

// Посылаем сообщение (send only message)
function sendMessage($chat_id, $message) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&parse_mode=html');
}

// Посылаем сообщение с клавиатурой (send message with inline keyboard in reply markup)
function sendKeyboard($chat_id, $message, $replyMarkup) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&parse_mode=html&reply_markup=' . $replyMarkup);
}

// Посылае ответ на нажатие кнопок (send callback query answer):
function send_answerCallbackQuery($callback_query_id, $text, $show_alert){
  file_get_contents($GLOBALS['api'] . '/answerCallbackQuery?callback_query_id=' . $callback_query_id . '&text=' . $text . '&show_alert=' . $show_alert );
}


