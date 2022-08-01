<?php

namespace App\Helper\Installer\trait;

use App\Helper\Curl;

trait ApichecktraitHelper
{
    /**
	 * IMPORTANT: Do not change this part of the code to prevent any data losing issue.
	 *
	 * @param $purchaseCode
	 * @return false|mixed|string
	 */

    private function purchaseCodeChecker($purchaseCode)
	{
		$apiUrl = config('installer.requirements.purchasecodCheckerUrl') . $purchaseCode . '&item_id=' . config('installer.requirements.itemId');
		$data = Curl::fetch($apiUrl);
		
		// Format object data
		$data = json_decode($data);
		
		// Check if 'data' has the valid json attributes
		if (!isset($data->valid) || !isset($data->message)) {
			$data = json_encode(['valid' => false, 'message' => 'Invalid purchase code. Incorrect data format.']);
			$data = json_decode($data);
		}
		
		return $data;
	}


	private function purchaseCodecreate($purchaseCodes, $firstname, $lastname, $email, $url,$license,$buyer,$author)
	{
		// A sample PHP Script to POST data using cURL
		// Data in JSON format
		$data = array(
			'name' => $firstname .' '.$lastname,
			'email' => $email,
			'purchaseCode' => $purchaseCodes,
            'url' => $url,
            'license' => $license,
            'buyer' => $buyer,
            'author' => $author,
		);
		
		$payload = json_encode($data);

		// Prepare new cURL resource
		$ch = curl_init('https://api.spruko.com/api/api/apicreate');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		
		// Set HTTP Header for POST request 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($payload))
		);
		
		// Submit the POST request
		$result = curl_exec($ch);
		

		// Close cURL session handle
		curl_close($ch);

		// Format object data
		$result = json_decode($result);
		return $result;
	}


	private function purchaseCodecheckingapi($purchaseCodes)
	{	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.spruko.com/api/api/apidetail/". $purchaseCodes);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch); 
		
		return $result;
	}
}