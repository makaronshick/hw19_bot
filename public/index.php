<?php

//2144883279:AAHrhDgcS3kZxCt64qMG1cgqpcc6RmvQ9-0
$url = 'https://api.telegram.org/bot<token>/getUpdates';
$sendMessageUrl = 'https://api.telegram.org/bot<token>/sendMessage';
$lastUpdateId = null;
$_url = $url;

do {
    if (null !== $lastUpdateId) {
        $_url = $url . '?offset=' . $lastUpdateId;
    }

    $response = json_decode(file_get_contents($_url), true);

    $text = json_decode(file_get_contents('https://icanhazdadjoke.com/slack'), true);;

    foreach ($response['result'] as $result) {
        if ($lastUpdateId == $result['update_id']) {
            continue;
        }
        $lastUpdateId = $result['update_id'];

        $chatId = $result['message']['chat']['id'];
        $messageId = $result['message']['message_id'];

        $response = [
          'chat_id' => $chatId,
          'text' => $text["attachments"][0]["text"],
        ];

        file_get_contents($sendMessageUrl . '?' . http_build_query($response));
    }
    sleep(5);
} while(true);
