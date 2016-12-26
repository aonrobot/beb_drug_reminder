<?php

	$access_token = 'l+7jn+Q1c7J4DrhKg4nFYVy4Dxz9iZ1GWTY3kunHqCEVqmwsUo5++rnnppHZB+h7OHuBia3rg3zA/nJiZV3GXBsjmnfe3UGPjg1PQcvSgED3ZTwn9ib4Vs58wuvRz8UHjdszh6uJ+LJphkF5KlVYrAdB04t89/1O/w1cDnyilFU=';

	$url = "https://api.line.me/v2/bot/message/push";

	$userId = "aonrobot";

	$text = "กินยาด้วยน้าา";

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
	$result = curl_exec($ch);
	curl_close($ch);

	echo $result . "\r\n";

