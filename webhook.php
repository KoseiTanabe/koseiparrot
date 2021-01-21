<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('LINEBotTiny.php');

$channelAccessToken = 'XTUXbtcyMfHjFNW/4U5c23i+h82Jpk22BfVfI37tH7PHZuMiQ5m65pNubFfEZkW0JbHYO/DZOmdEnaOh2YBsa1Zp6+lXtWF5ItdkwpLbUhIY//dN5F8KQezktXG4igFg6mkqaWXNwnjScsV6rir/OAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '4806448192de8cb41ccf3d2857b92e07';

//LinebotTinyクラスのインスタンスを生成し、$clientに格納する
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
	//イベントのタイプがmessageだったら
	case 'message':
	$message = $event['message'];
            switch ($message['type']) {
		/* 送信されたメッセージを含むwebhookイベント
		   メッセージオブジェクトのtypeがtextだったら */
                case 'text':
                    $client->replyMessage([
			//イベントへの応答に使用するトークン
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
				//メッセージオブジェクトのタイプをtextにする
                                'type' => 'text',
				//応答メッセージ内容を送られてきたメッセージと同じにする
                                'text' => $message['text']
                            ]
                        ]
                    ]);
                    break;
                default:
                    error_log('Unsupported message type: ' . $message['type']);
                    break;
            }
            break;
        default:
            error_log('Unsupported event type: ' . $event['type']);
            break;
    }
};
