<?php
/**
 * Telegram Cowsay Bot Example.
 * Add @cowmooobot to try it!
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'Telegram.php';

// Set the bot TOKEN
$bot_token = '5132260282:AAFgVVmhexEGLvKAjqzl8uXAqKL-D3ns9g0';
// Instances the class
$telegram = new Telegram($bot_token);

/* If you need to manually take some parameters
*  $result = $telegram->getData();
*  $text = $result["message"] ["text"];
*  $chat_id = $result["message"] ["chat"]["id"];
*/

// Take text and chat_id from the message
$text = $telegram->Text();
$chat_id = $telegram->ChatID();

if ($text == '/start') {
    $option = [["\xF0\x9F\x90\xAE"], ['Git', 'Credit']];
    // Create a permanent custom keyboard
    $keyb = $telegram->buildKeyBoard($option, $onetime = false);
    $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Welcome to CowBot \xF0\x9F\x90\xAE \nPlease type /cowsay or click the Cow button !"];
    $telegram->sendMessage($content);
}

if ($text == '/git' || $text == 'Git') {
    $reply = 'Check me on GitHub: https://github.com/Eleirbag89/TelegramBotPHP';
    $content = ['chat_id' => $chat_id, 'text' => $reply];
    $telegram->sendMessage($content);
}


/* If you need to manually take some parameters
*  $result = $telegram->getData();
*  $text = $result["message"] ["text"];
*  $chat_id = $result["message"] ["chat"]["id"];
*/

// Take text and chat_id from the message
$text = $telegram->Text();
$chat_id = $telegram->ChatID();

// Test CallBack
$callback_query = $telegram->Callback_Query();
if ($callback_query !== null && $callback_query != '') {
    $reply = 'Callback value '.$telegram->Callback_Data();
    $content = ['chat_id' => $telegram->Callback_ChatID(), 'text' => $reply];
    $telegram->sendMessage($content);

    $content = ['callback_query_id' => $telegram->Callback_ID(), 'text' => $reply, 'show_alert' => true];
    $telegram->answerCallbackQuery($content);
}

//Test Inline
$data = $telegram->getData();
if ($data['inline_query'] !== null && $data['inline_query'] != '') {
    $query = $data['inline_query']['query'];
    // GIF Examples
    if (strpos('testText', $query) !== false) {
        $results = json_encode([['type' => 'gif', 'id'=> '1', 'gif_url' => 'http://i1260.photobucket.com/albums/ii571/LMFAOSPEAKS/LMFAO/113481459.gif', 'thumb_url'=>'http://i1260.photobucket.com/albums/ii571/LMFAOSPEAKS/LMFAO/113481459.gif']]);
        $content = ['inline_query_id' => $data['inline_query']['id'], 'results' => $results];
        $reply = $telegram->answerInlineQuery($content);
    }

    if (strpos('dance', $query) !== false) {
        $results = json_encode([['type' => 'gif', 'id'=> '1', 'gif_url' => 'https://media.tenor.co/images/cbbfdd7ff679e2ae442024b5cfed229c/tenor.gif', 'thumb_url'=>'https://media.tenor.co/images/cbbfdd7ff679e2ae442024b5cfed229c/tenor.gif']]);
        $content = ['inline_query_id' => $data['inline_query']['id'], 'results' => $results];
        $reply = $telegram->answerInlineQuery($content);
    }
}

// Check if the text is a command
if (!is_null($text) && !is_null($chat_id)) {
    if ($text == '/test') {
        if ($telegram->messageFromGroup()) {
            $reply = 'Chat Group';
        } else {
            $reply = 'Private Chat';
        }
        // Create option for the custom keyboard. Array of array string
        $option = [['A', 'B'], ['C', 'D']];
        // Get the keyboard
        $keyb = $telegram->buildKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == '/git') {
        $reply = 'Check me on GitHub: https://github.com/Eleirbag89/TelegramBotPHP';
        // Build the reply array
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } elseif ($text == '/img') {
        // Load a local file to upload. If is already on Telegram's Servers just pass the resource id
        $img = 'AgACAgQAAxkBAAEIZnBiPMYmt_KOumM1t09ITNaauTTLxAACpb0xG8KAaFFx8xqGPEroJgEAAwIAA3gAAyME';
        $content = ['chat_id' => $chat_id, 'photo' => $img];
        $telegram->sendPhoto($content);
    } elseif ($text == '/where') {
        // Send the Catania's coordinate
        $content = ['chat_id' => $chat_id, 'latitude' => '37.5', 'longitude' => '15.1'];
        $telegram->sendLocation($content);
    } elseif ($text == '/inlinekeyboard') {
        // Shows the Inline Keyboard and Trigger a callback on a button press
        $option = [
            [
                $telegram->buildInlineKeyBoardButton('Callback 1', $url = '', $callback_data = '2'),
                $telegram->buildInlineKeyBoardButton('Callback 2', $url = '', $callback_data = '3'),
            ],
        ];

        $keyb = $telegram->buildInlineKeyBoard($option);
        $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'This is an InlineKeyboard Test with Callbacks'];
        $telegram->sendMessage($content);
    }
}

