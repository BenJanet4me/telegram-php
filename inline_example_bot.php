<?php
// 4eburashk для примера тестов.
// Задача: Показать примериспользования инлайн клавиатур 
// в основе примера - шутливый врачебный тест. 
$access_token = 'XXXXXXX:XXXXXXXXXXXXXXXXXXXXXX';
$api = 'https://api.telegram.org/bot' . $access_token;
// query:
$output = json_decode(file_get_contents('php://input'), TRUE);
$chat_id = $output['message']['chat']['id'];
$message = $output['message']['text'];
// callback:
$callback_query = $output['callback_query'];
$data = $callback_query['data'];
$chat_id_in = $callback_query['message']['chat']['id'];
$message_id = $callback_query['message']['message_id'];
$query_id = $callback_query['id'];
//
// Общие кнопки, клавы и ответы лучше расположить здесь, чтоб были доступны в любом кейсе.
// Можно описать кнопки, клавы и ответы в каждом кейсе отдельно, а можно описать всё и сразу и вызывать нужную клаву.
// Для наглядности, покажу оба варианта.
$inline_keyboard0 = [[]];
$keyboard0 = array("inline_keyboard"=>$inline_keyboard0); $replyMarkup0 = json_encode($keyboard0);

// Создаём кнопки:
// зарезервируем первые две кнопки - на общее меню и прощание. Начнем с третьей.
$inline_button3=array("inline_message_id"=>"3","text"=>"Оторву руку","callback_data"=>'/3');
$inline_button4=array("inline_message_id"=>"4","text"=>"Оторву ногу","callback_data"=>'/4');
$inline_button5=array("inline_message_id"=>"5","text"=>"Пожалею и поплачу","callback_data"=>'/5');
$inline_button6=array("inline_message_id"=>"6","text"=>"Дам снотворное","callback_data"=>'/6');
// из кнопок строим клаву:
$inline_keyboard1 = [[$inline_button3],[$inline_button4],[$inline_button5],[$inline_button6]];
// создаём ответ с клавиатурой:
$keyboard1 = array("inline_keyboard"=>$inline_keyboard1); $replyMarkup1 = json_encode($keyboard1);

//commands
switch($message) {
  case '/start':
    $mess = "  Пример бота с тестами
  Например, будем лечить больного.
  Приступим?
  
  К вам пришел пациент и жалуется на боль в руке.

  Как вы поступите?";
	// отправляем сообщение и ответ с готовой клавиатурой в функцию отправки:
    sendKeyboard($chat_id, $mess, $replyMarkup1);
  break;
}

// ловим калбэк.
switch($data){
  case '/3':
	// чтобы бесконечно не крутились часы на кнопках в ожидании ответа, сразу отправляем пустой ответ:
 	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "  Вы оторвали руку человеку!
    Ай-ай!
    Теперь же её надо приделать обратно.";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup1);
  break;
  case '/4':
	send_answerCallbackQuery($callback_query[id], null, false);
	$mess = "  АААА!
  Нога то тут вообще при чём?!
  Он же на руку жаловался.
";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup1);
  break;
  case '/5':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "  Да.
    Лучше уж порыдать вместе, чем руки ноги отрывать.
    Не самое профессиональное решение,
    зато хоть не навредили. 
";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup1);
  break;
  case '/6':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "  Хрррр...
    Фуф, уснул.
    Помощи не просит, не беспокоит.
    Как бы его теперь отсюда вытащить?
";
    // пример инлайн клавиатуры внутри кейса:
    // Создаём кнопки:
    $inline_button7=array("inline_message_id"=>"7","text"=>"Ждать когда проснется","callback_data"=>'/exit');
    $inline_button8=array("inline_message_id"=>"8","text"=>"Оторвать руку пока спит","callback_data"=>'/exit');
    $inline_button9=array("inline_message_id"=>"9","text"=>"Выволочь спящее тело","callback_data"=>'/exit');
    $inline_button10=array("inline_message_id"=>"10","text"=>"Звонок другу","callback_data"=>'/exit');
    // из кнопок строим клаву:
    $inline_keyboard2 = [[$inline_button7],[$inline_button8],[$inline_button9],[$inline_button10]];
    // создаём ответ с клавиатурой:
    $keyboard2 = array("inline_keyboard"=>$inline_keyboard2); $replyMarkup2 = json_encode($keyboard2);
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup2);
  break;
  case '/exit':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "
    Спасибо что посетили наш госпиталь.
    Надеемся, что были вам полезны. 

			\xF0\x9F\x99\x8F

    Покупайте наших слонов!";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup0);
  break;
}

// send functions:
function editMessageText($chid, $mid, $mes, $repl) {
  file_get_contents($GLOBALS['api'] . '/editMessageText?chat_id='.$chid.'&message_id='.$mid.'&text='.urlencode($mes).'&parse_mode=html&reply_markup='.$repl );
}

function sendKeyboard($chat_id, $message, $replyMarkup) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&parse_mode=html&reply_markup=' . $replyMarkup);
}

// Ответ на нажатие кнопок
function send_answerCallbackQuery($callback_query_id, $text, $show_alert){
  file_get_contents($GLOBALS['api'] . '/answerCallbackQuery?callback_query_id=' . $callback_query_id . '&text=' . $text . '&show_alert=' . $show_alert );
}

// END
