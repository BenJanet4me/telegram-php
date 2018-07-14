<?php
// Ben-Ja for www.net4me.net
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
// menu buttons 1-20
$inline_button1=array("inline_message_id"=>"1","text"=>"Exit \xF0\x9F\x9A\xB6","callback_data"=>'/exit'); //exit
$inline_button2=array("inline_message_id"=>"2","text"=>"\xE2\x9B\xBA Menu","callback_data"=>'/menu'); //menu
// dialog buttons
//$inline_button3=array("inline_message_id"=>"3","text"=>"\xE2\x99\xA8 Debug","callback_data"=>'/debug'); 
$inline_button4=array("inline_message_id"=>"4","text"=>"Network","callback_data"=>'/network');
$inline_button5=array("inline_message_id"=>"5","text"=>"Linux","callback_data"=>'/linux');
$inline_button6=array("inline_message_id"=>"6","text"=>"Bash","callback_data"=>'/bash');
$inline_button7=array("inline_message_id"=>"7","text"=>"Telegram","callback_data"=>'/telegram');
$inline_button8=array("inline_message_id"=>"8","text"=>"\xF0\x9F\x92\xB3 Donate \xE2\x9B\xBD","callback_data"=>'/donate'); 
$inline_button9=array("inline_message_id"=>"9","text"=>"\xF0\x9F\x93\x9A Links","callback_data"=>'/links');
// debug
$inline_button13=array("inline_message_id"=>"13","text"=>"\xE2\x99\xA8 Debug","callback_data"=>'/debug'); //debug
// link buttons 20-30
$inline_button21=array("inline_message_id"=>"21","text"=>"Open Sourse portal net4me.net","url"=>"http://www.net4me.net");
$inline_button22=array("inline_message_id"=>"22","text"=>"Раздел примеров linux","url"=>"http://www.net4me.net/old/info/");
$inline_button23=array("inline_message_id"=>"23","text"=>"Раздел примеров bash","url"=>"http://www.net4me.net/old/bash-script-example-shell-linux/");
$inline_button24=array("inline_message_id"=>"24","text"=>"Раздел примеров telegram","url"=>"http://www.net4me.net/php/telegram-bot-php/");
$inline_button25=array("inline_message_id"=>"25","text"=>"Раздел примеров network","url"=>"http://www.net4me.net/old/info/net_protocol_ip_route/");
$inline_button26=array("inline_message_id"=>"26","text"=>"Помочь и поддержать net4me.net","url"=>"http://yasobe.ru/na/net4me");
$inline_button27=array("inline_message_id"=>"27","text"=>"Новостной канал net4me.net","url"=>"https://t.me/net4me_linux");
$inline_button28=array("inline_message_id"=>"28","text"=>"\xF0\x9F\x92\xB3 Поддержать net4me.net \xE2\x9B\xBD","url"=>"http://yasobe.ru/na/net4me");
$inline_button29=array("inline_message_id"=>"29","text"=>"\xF0\x9F\x92\xB3 Donate \xE2\x9B\xBD","url"=>"http://yasobe.ru/na/net4me");

// keyboards vertical 5 lines.
$inline_keyboard0 = [[]];
// start
$inline_keyboard1 = [[$inline_button21],[$inline_button5,$inline_button6],[$inline_button4,$inline_button7],[$inline_button2,$inline_button1],[$inline_button9,$inline_button8]];
// linux
$inline_keyboard2 = [[$inline_button22],[$inline_button6],[$inline_button4,$inline_button7],[$inline_button2,$inline_button1],[$inline_button9,$inline_button8]];
// bash
$inline_keyboard3 = [[$inline_button23],[$inline_button5],[$inline_button4,$inline_button7],[$inline_button2,$inline_button1],[$inline_button9,$inline_button8]];
// network
$inline_keyboard4 = [[$inline_button25],[$inline_button5,$inline_button6],[$inline_button7],[$inline_button2,$inline_button1],[$inline_button9,$inline_button8]];
// telegram
$inline_keyboard5 = [[$inline_button24],[$inline_button5,$inline_button6],[$inline_button4],[$inline_button2,$inline_button1],[$inline_button9,$inline_button8]];
// links
$inline_keyboard6 = [[$inline_button21],[$inline_button27],[$inline_button22],[$inline_button23],[$inline_button24],[$inline_button25],[$inline_button26],[$inline_button2,$inline_button1],[$inline_button9,$inline_button8]];
// donate
$inline_keyboard7 = [[$inline_button28],[$inline_button21],[$inline_button2,$inline_button1],[$inline_button9,$inline_button29]];
// exit
$inline_keyboard8 = [[$inline_button21],[$inline_button28]];
// create inline keyboards and their replyMarkup
$keyboard0 = array("inline_keyboard"=>$inline_keyboard0); $replyMarkup0 = json_encode($keyboard0);
$keyboard1 = array("inline_keyboard"=>$inline_keyboard1); $replyMarkup1 = json_encode($keyboard1);
$keyboard2 = array("inline_keyboard"=>$inline_keyboard2); $replyMarkup2 = json_encode($keyboard2);
$keyboard3 = array("inline_keyboard"=>$inline_keyboard3); $replyMarkup3 = json_encode($keyboard3);
$keyboard4 = array("inline_keyboard"=>$inline_keyboard4); $replyMarkup4 = json_encode($keyboard4);
$keyboard5 = array("inline_keyboard"=>$inline_keyboard5); $replyMarkup5 = json_encode($keyboard5);
$keyboard6 = array("inline_keyboard"=>$inline_keyboard6); $replyMarkup6 = json_encode($keyboard6);
$keyboard7 = array("inline_keyboard"=>$inline_keyboard7); $replyMarkup7 = json_encode($keyboard7);
$keyboard8 = array("inline_keyboard"=>$inline_keyboard8); $replyMarkup8 = json_encode($keyboard8);
// обработка поступающего
//commands
switch($message) {
  case '/start':
    $mess = "\xF0\x9F\x93\xA1 <b>NET4ME</b>.
  Open Source Portal
<i>Технологии в простых примерах.</i>
Новые, современные технологии часто создают ауру \"это только для избраных\".
Это выгодно. Выгодно сделать технологию \"для элиты\" и требовать больше денег за разработку приложений.
Но такой подход элитарности убивает саму технологию. Начинающему, часто нужен простой и быстрый результат \"чтоб заработало\".
Имея этот изначальный простой результат, начинающему проще идти дальше в изучение.
Да, net4me занимается упрощением до элементарного. \xF0\x9F\x94\x8E

<b>Пусть всё будет просто!</b>";
    sendKeyboard($chat_id, $mess, $replyMarkup1);
  break;
  case 'Hi':
  case 'Hello':
    sendKeyboard($chat_id, "Hello!");
  break;
  case 'Привет':
  case 'Хаюшки':
    sendKeyboard($chat_id, "Здарова!");
  break;
}
// callback_query commands!
switch($data){
  case '/menu':
 	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x93\xA1 <b>NET4ME</b>.
  Open Source Portal
<i>Технологии в простых примерах.</i>

Мы занимаемся тем, что берем сложные технологии и раскладываем их до простых, элементарных примеров.
Благодаря нашим примерам, любой начинающий может понять суть технологии и начать творить сам. \xF0\x9F\x94\xAC

<b>Пусть всё будет просто!</b>";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup1);
  break;
  case '/linux':
	send_answerCallbackQuery($callback_query[id], null, false);
	$mess = "\xF0\x9F\x90\xA7 <b>OS linux</b>
Конечно, мир без linux был бы другим.
Open Source это наше всё.

Пусть всё будет просто и открыто!
Авторы портала net4me знакомы с OS linux со времен 286х-486х компьютеров (это конец 1980х начало 1990х).
Да, тогда не было доступного интернет \xF0\x9F\x92\xBE, ОS выходили на CD \xF0\x9F\x92\xBF дисках и редкая книга документации на английском была навес золота.
Поэтому мы научились изучать и ценить документацию.
";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup2);
  break;
  case '/bash':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x92\xBB <b>BASH</b>
BASH это Unix shell (в общем, командная строка, оболочка) переводится как Bourne-again shell.
Используется в очень многих Unix-like системах как оболочка по умолчанию.
Linux, Mac OS X, FreeBSD, *BSD и т.д. даже под винду есть.
На bash пишутся скрипты (последовательности команд, автоматизация) примеры этих вот скриптов мы и рассматриваем. 
";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup3);
  break;
  case '/network':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x8C\x8D <b>Компьютерные сети.</b>
Сейчас передача данных по сети - норма окружающего нас мира.
Но как это работает?
Об основах, битах, байтах и протоколах мы попробуем рассказать просто.
";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup4);
  break;
  case '/telegram':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x92\xBC <b>telegram bot</b>
Пусть боты будут простыми.
Собственные сервера с интерпретаторами, сертификатами, сложные громоздкие билиотеки, SDK, фреймвворки... 
Каких только сложностей я ни насмотрелся, когда заинтересовался написанием телеграм ботов!
Конечно, серьёзные нагрузки, крупные проекты, требуют серьёзных ресурсов и основательных знаний.

Ну, а у нас всё тупо и просто! Учимся и экспериментируем на простом.
Любой хостинг с php+ssl и несколько строчек кода - этого достаточно, чтобы наши боты заработали.";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup5);
  break;
  case '/links':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x93\x9A <b>Links</b>";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup6);
  break;
  case '/donate':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x92\xB3 <b>Помочь и поддержать www.net4me.net</b>
Очень нужна ваша помощь. \xE2\x9B\xBD
Конечно, всё что мы делаем - <b>абсолютно бесплатно</b>.
И конечно нам нужны средства, чтобы работали наши сервера, хостинг, домен, сайт.

И мы <b>благодарны</b> за вашу поддержку net4me, какой бы они ни была.
Большое вам <b>спасибо</b> за ваш вклад!

Поддержать net4me можно по ссылке
http://yasobe.ru/na/net4me
";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup7);
  break;
  case '/exit':
	send_answerCallbackQuery($callback_query[id], null, false);
    $mess = "\xF0\x9F\x9A\xAA\xF0\x9F\x9A\xB6 <b>Выход</b>
Спасибо что посетили нас.
Надеемся, что были вам полезны. 

            \xF0\x9F\x99\x8F

Оставайтесь с нами";
    editMessageText($chat_id_in, $message_id, $mess, $replyMarkup8);
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
