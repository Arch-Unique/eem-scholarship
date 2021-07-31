<?php

	if($_POST){
		$data = [
			'email' => $_POST['email'],
			'status' => 'subscribed'
		];

		$res = syncmail($data);

		if($res == 200){
			echo '<div class="alert alert-success" role="alert"> Subscribed Successfully</div>';
		}else{
			echo '<div class="alert alert-danger" role="alert"> unable to subscribe at the moment</div>';
		}
	}

	function syncmail($data){
		$apiKey = '';
		$listId = '';

		$memberId = md5(strtolower($data['email']));
		$dataCenter = substr($apikey, strpos($apiKey, '-')+1);
		$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
		
		$query = [
			'email_address' => $data['email'],
			'status' => $data['status']
		]
		
		$data_string = json_encode($query);
                
        $ch = curl_init($url);    
		curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);                                                                  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $httpcode;
	}
?>