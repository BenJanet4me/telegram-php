<?php
/**
 * Telegram Bot Debugger. Telegram curl post message.
 * 
 *  Edit by 4eburashk http://csn.net4me.net
 *    On Sat 22 Jan 2022 07:15:17 PM MSK
 * 
 *    version: 2.1
 *    release: 2022-01-23
 */
$access_token = '12345678:AAF-XXXXXXXXXXXXXXXXXX';
$api = 'https://api.telegram.org/bot' . $access_token;
/**
 * Задаём основные переменные.
 */
$output = json_decode(file_get_contents('php://input'), TRUE);
@$chat_id = $output['message']['chat']['id'];
@$message = $output['message']['text'];
@$from = $output['message']['from'];
@$names = $from['id']." ".$from['first_name']." ".$from['username'];
@$callback_query = $output['callback_query'];
@$data = $callback_query['data'];
@$chat_id_in = $callback_query['message']['chat']['id'];
@$message_id = $callback_query['message']['message_id'];
// Инлайн клавиатура:
$inline_button3 = array("inline_message_id"=>"3","text"=>"send pic","callback_data"=>'/3');
$inline_button4 = array("inline_message_id"=>"4","text"=>"send location","callback_data"=>'/4');
$inline_button5 = array("inline_message_id"=>"5","text"=>"show all","callback_data"=>'/1');
$inline_button6 = array("inline_message_id"=>"6","text"=>"show callback","callback_data"=>'/2');
$inline_keyboard1 = [[$inline_button3,$inline_button4],[$inline_button5,$inline_button6]];
$keyboard1=array("inline_keyboard"=>$inline_keyboard1);
$replyMarkup1 = json_encode($keyboard1);
// Ожидаем сообщения:
switch($message) {
    case '/start':
        sendMessage($chat_id, "\xF0\x9F\x93\xA1 бот debugger на связи!");
    break;
    default:
        $myDebug = "<pre>". json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).PHP_EOL."</pre>"; 
        sendMessage($chat_id, $myDebug, 0, 'html', $replyMarkup1);
    break;
}

// callback data Реакции на нажатие кнопок.
switch($data){
    case '/1':
        send_answerCallbackQuery($callback_query['id'], null, false); // убираем ожидание (часы на кнопке)
        $myDebug = "<pre>".json_encode($output)."</pre>";
        sendMessage($chat_id_in, $myDebug, 0, 'html');
    break;
    case '/2':
        send_answerCallbackQuery($callback_query['id'],'callback id: '.$callback_query['id'], true); // c алертом
        $myDebug = "<pre>". json_encode($output) ."</pre>";
        sendMessage($chat_id_in, $myDebug, 0, 'html', $replyMarkup1);
    break;
    case '/3':
        send_answerCallbackQuery($callback_query['id'], null, false); // убираем ожидание (часы на кнопке)
        $text = "Отправка *картинки* _с текстом_, разметка текста в caption не рабоает. Только текст.";
        sendPhoto($chat_id_in, $text, '../images/icon-256x256.png', 0);
    break;
    case '/4':
        send_answerCallbackQuery($callback_query['id'], null, false); // убираем ожидание (часы на кнопке)
        // Отправка координаты. К сожалению (пока?), без текста и возможности подписи.
        sendLocation($chat_id_in, '55.85303647558608', '37.61637715031881');
    break;
}

exit(0);
//***************** functions ******************

// Отправка сообщения или сообщения с клавиатурой. Возвращает id отправленного сообщения.
function sendMessage($chat_id, $message, $mute=false, $pmode='HTML', $replyMarkup=false){
    $url = $GLOBALS['api'] . "/sendMessage";
    $post_fields = array(
        'chat_id'   => $chat_id,
        'text'      => $message,
        'disable_notification' => $mute,
        'parse_mode'=> $pmode,
        'reply_markup'=>$replyMarkup
    );
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Content-Type:multipart/form-data" ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $response = curl_exec($ch);
    curl_close($ch);
    usleep(500);
    $res = json_decode($response, TRUE);
    return isset($res['result'])?$res['result']['message_id']:0; //int id сообщения.
}

// Ответ на нажатие кнопок
function send_answerCallbackQuery($callback_query_id, $text='', $show_alert=false){
  @file_get_contents($GLOBALS['api'] . '/answerCallbackQuery?callback_query_id=' . $callback_query_id . '&text=' . $text . '&show_alert=' . $show_alert );
}

// отправка location в telegram:
function sendLocation($chat_id, $latitude='55.75236229347181', $longitude='37.66827791767219', $mute=false){
    $url = $GLOBALS['api'] . "/sendLocation";
    $post_fields = array(
        'chat_id'   => $chat_id,
        'latitude'  => $latitude,
        'longitude' => $longitude,
        'disable_notification'      => $mute,
    );
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Content-Type:multipart/form-data" ));
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
    $res = curl_exec($ch);
    return $res;
}

// отправка сообщения с картинкой в telegram:
function sendPhoto($chat_id, $caption, $img, $mute=false){
    $url = $GLOBALS['api'] . "/sendPhoto";
    // в картинках, парсмод только html! проверено.
    $post_fields = array(
        'chat_id'   => $chat_id,
        'disable_notification'  => $mute,
        'caption'   => htmlspecialchars($caption,ENT_QUOTES),
        'photo'     => new CURLFile(realpath($img))
    );
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Content-Type:multipart/form-data" ));
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
    $res = curl_exec($ch);
    return $res;
}

// удаление сообщения из tg:
function deleteMessage($cid, $mid){
    $dresponse = @file_get_contents($GLOBALS['api'] . '/deleteMessage?chat_id=' . $cid . '&message_id=' . $mid);
    return $dresponse;
}

// END 
