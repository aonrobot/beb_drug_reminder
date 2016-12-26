<?php
$access_token = 'l+7jn+Q1c7J4DrhKg4nFYVy4Dxz9iZ1GWTY3kunHqCEVqmwsUo5++rnnppHZB+h7OHuBia3rg3zA/nJiZV3GXBsjmnfe3UGPjg1PQcvSgED3ZTwn9ib4Vs58wuvRz8UHjdszh6uJ+LJphkF5KlVYrAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

function sent_userId($userId, $text){

	$messages = [
		'type' => 'text',
		'text' => $text
	];

	$data = [
		'to' => $userId,
		'messages' => [$messages],
	];

	$post = json_encode($data);

	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_close($ch);

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

			if(strpos($text, "userId") !== false)
			{

				sent_userId("U44b4093b6bcf03beefc01f5f5d4a62d3", $event['source']['userId'])

				// Build message to reply back
				$messages = [
					'type' => 'text',
					'text' => "ส่ง userId ของหมูอ้วนไปให้บู่บี้เรียบร้อยละนั"
				];

				// Make a POST Request to Messaging API to reply to sender
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages],
				];
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
			
		}
	}
}


echo "OK";