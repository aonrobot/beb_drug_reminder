<?php

$access_token = 'l+7jn+Q1c7J4DrhKg4nFYVy4Dxz9iZ1GWTY3kunHqCEVqmwsUo5++rnnppHZB+h7OHuBia3rg3zA/nJiZV3GXBsjmnfe3UGPjg1PQcvSgED3ZTwn9ib4Vs58wuvRz8UHjdszh6uJ+LJphkF5KlVYrAdB04t89/1O/w1cDnyilFU=';

$url_reply = 'https://api.line.me/v2/bot/message/reply';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);


function get_profile($userId){

	$access_token = 'l+7jn+Q1c7J4DrhKg4nFYVy4Dxz9iZ1GWTY3kunHqCEVqmwsUo5++rnnppHZB+h7OHuBia3rg3zA/nJiZV3GXBsjmnfe3UGPjg1PQcvSgED3ZTwn9ib4Vs58wuvRz8UHjdszh6uJ+LJphkF5KlVYrAdB04t89/1O/w1cDnyilFU=';

	$url_profile = "https://api.line.me/v2/bot/profile/$userId";

	$headers = array('Authorization: Bearer ' . $access_token);

	$ch = curl_init($url_profile);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	return json_decode($result);
}

function push_text($userId, $sentText){

	$access_token = 'l+7jn+Q1c7J4DrhKg4nFYVy4Dxz9iZ1GWTY3kunHqCEVqmwsUo5++rnnppHZB+h7OHuBia3rg3zA/nJiZV3GXBsjmnfe3UGPjg1PQcvSgED3ZTwn9ib4Vs58wuvRz8UHjdszh6uJ+LJphkF5KlVYrAdB04t89/1O/w1cDnyilFU=';

	$url_push = "https://api.line.me/v2/bot/message/push";

	//$profile_info = get_profile($sentText);

	//$sentText = $profile_info['displayName'] . " : " . $sentText;

	$messages = [
		'type' => 'text',
		'text' => $sentText
	];

	$data = [
		'to' => $userId,
		'messages' => [$messages],
	];

	$post = json_encode($data);

	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

	$ch = curl_init($url_push);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	echo $result . "\r\n";

	return true;

}

function reply($data, $access_token, $url){

	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	echo $result . "\r\n";
}

// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			if(strpos($text, "userId") !== false || strpos($text, "id") !== false || strpos($text, "ไอดี") !== false)
			{

				if(push_text("U44b4093b6bcf03beefc01f5f5d4a62d3", $event['source']['userId'])){

					// Build message to reply back
					$messages = [
						'type' => 'text',
						'text' => "ส่ง userId ของหมูอ้วนไปให้บู่บี้เรียบร้อยละนะ <3"
					];

					// Make a POST Request to Messaging API to reply to sender
					$data = [
						'replyToken' => $replyToken,
						'messages' => [$messages],
					];
					$post = json_encode($data);
					$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

					$ch = curl_init($url_reply);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					$result = curl_exec($ch);
					curl_close($ch);

					echo $result . "\r\n";
				}

				
			}
			
		}

		// Reply only when message sent is in 'image' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'image') {
			// Get text sent
			$imgId = $event['message']['id'];
			$imgUrl = $event['message']['originalContentUrl'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => 'ส่งรูปมาแล้ว id คือ -> ' . $imgId . ' url คือ -> ' . $imgUrl
			];

			// Make a POST Request to Messaging API to reply to sender
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];

			reply($data, $access_token, $url_reply);
			
		}
	}
}

echo "OK4";