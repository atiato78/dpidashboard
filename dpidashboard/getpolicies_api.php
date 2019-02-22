<?php
function GetPolicies(){
	$url = 'http://213.175.177.246:6060/crm-quota-sql/GetPolicies';
	//$url = 'http://camel-example-spring-boot-expo.apps.192.168.0.6.nip.io/crm-quota-sql/GetPolicies';
	$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			)
		);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$json_policies = json_decode($result, true);
	if ($result === FALSE) {
		echo $_GET['jsonCallback'].'("error")';
	}
	else{
		for($b=0;$b<count($json_policies);$b++){			
			$data[] = $json_policies[$b]['id'];
			$data[] = $json_policies[$b]['name'];			
		}
		$data = json_encode($data);
		echo $_GET['jsonCallback'].'('.$data.')';
	}
}
	
if(function_exists($_GET['function'])){
	$_GET['function']();
}

?>
