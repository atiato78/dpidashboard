<?php
function GetMobilockDevicesProfiles(){
	$url = 'https://mobilock.in/api/v1/devices.json';
	$options = array(
			'http' => array(
			'header'  => "Authorization: Token 0632751c7a424c30b1d882f6a31a53a6\r\n",
			'method'  => 'GET',
			)
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	
	if ($result === FALSE) {
		echo $_GET['jsonCallback'].'("error")';
	}
	else{
		$json_profiles = json_decode($result, true);
		for($b=0;$b<count($json_profiles["devices"]);$b++){			
			$data[] = str_replace('"', '', json_encode($json_profiles["devices"][$b]["device"]["name"],true)).' -  IMEI: '.str_replace('"', '', json_encode($json_profiles["devices"][$b]["device"]["imei_no"],true));			
		}
		$data = json_encode($data);
		echo $_GET['jsonCallback'].'('.$data.')';
	}
}

if(function_exists($_GET['function'])){
	$_GET['function']();
}


?>