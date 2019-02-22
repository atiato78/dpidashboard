<?php
function UpdateSubscriberPolicy($msisdn, $suscriberid, $policyid){
	$url = 'http://213.175.177.246:6060/crm-quota-sql/UpdateProfile';
	//$url = 'http://camel-example-spring-boot-expo.apps.192.168.0.6.nip.io/crm-quota-sql/UpdateProfile';
	
	
	$data = array('1' => array('i32' => (int)$suscriberid), '2' => array('str' => $msisdn), '3' => array('i32' => (int)$policyid), '4' => array('tf' => 0));
	
	 $opts = array('http' =>
        array(
            'method'  => 'POST',
			'header'  => "Content-type: application/json\r\n",
            'content' => json_encode($data)
        )
    );
	
	
	$context  = stream_context_create($opts);
	$result = file_get_contents($url, false, $context);
	$json = json_decode($result, true);				
	if ($result === FALSE) {
		echo $_GET['jsonCallback'].'("error")';
	}
	else{				
		//$data = json_encode($json);
		echo $_GET['jsonCallback'].'('.$result.')';
	}

}
if(function_exists($_GET['function'])){
	
	if(isset($_GET['msisdn']) && isset($_GET['policyid']) && isset($_GET['suscriberid'])){
		$_GET['function']($_GET['msisdn'], $_GET['suscriberid'], $_GET['policyid']);
	}
}

?>
