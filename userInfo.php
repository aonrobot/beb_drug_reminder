<?php

	$access_token = 'l+7jn+Q1c7J4DrhKg4nFYVy4Dxz9iZ1GWTY3kunHqCEVqmwsUo5++rnnppHZB+h7OHuBia3rg3zA/nJiZV3GXBsjmnfe3UGPjg1PQcvSgED3ZTwn9ib4Vs58wuvRz8UHjdszh6uJ+LJphkF5KlVYrAdB04t89/1O/w1cDnyilFU=';

	$userId = "aonrobot";
	
	$url = "https://api.line.me/v2/bot/profile/$userId";

	$headers = array('Authorization: Bearer ' . $access_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	echo $result;

