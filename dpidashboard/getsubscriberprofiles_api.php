<?php
function GetSubscriberProfiles(){
	$url = 'http://213.175.177.246:6060/crm-quota-sql/GetSubscriberProfiles';
	//$url = 'http://camel-example-spring-boot-expo.apps.192.168.0.6.nip.io/crm-quota-sql/GetSubscriberProfiles';
				//$data = array('key1' => 'value1', 'key2' => 'value2');
				// use key 'http' even if you send the request to https://...
				$options = array(
					'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						//'content' => http_build_query($data)
					)
				);
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
				$json = json_decode($result, true);				
				if ($result === FALSE) {echo "error";}
				else{				
					for($a=0;$a<count($json);$a++){
							$data[] = '	<tr>
										<td>'.$json[$a]['id'].'</td>
										<td>'.$json[$a]['subscriberIdMask'].'</td>
										<td id="policyid">'.$json[$a]['policyId'].'</td>
										<td>00008888887878</td>
										<td>          
										<select  name="choices-single-defaul" id="ahmoptionpolicy" onchange="choosePolycy()">';
					}
				}
				$data = json_encode($data);
				echo $_GET['jsonCallback'].'('.$data.')';
	}
	
	
	
	function GetSubscriberProfilePerImei($imei){
	$url = 'http://213.175.177.246:6060/crm-quota-sql/findSubscriberProfile';
	//$url = 'http://camel-example-spring-boot-expo.apps.192.168.0.6.nip.io/crm-quota-sql/findSubscriberProfile';
				//$dataa = array($imei);
				// use key 'http' even if you send the request to https://...
				$options = array(
					'http' => array(
						'header'  => "Content-type: text/plain\r\n",
						'method'  => 'POST',
						'content' => $imei  //this api takes parameter as text in body
					)
				);
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
				$json = json_decode($result, true);					
				if ($result === FALSE) {
					echo $_GET['jsonCallback'].'("error")';
				}
				else{
					if (strpos($result, 'UNKNOWN_PROFILE_ID') !== false) {
						$data[] = '--';
						$data[] = substr($result, 19);
						$data[] = '';
					}else{					
						$data[] = $json['id'];
						$data[] = $json['subscriberIdMask'];
						$data[] = $json['policyId'];
					}
					
					$data = json_encode($data);
					echo $_GET['jsonCallback'].'('.$data.')';
				}
	}
	
	
	
if(function_exists($_GET['function'])){
	
	if(isset($_GET['imei'])){
		$_GET['function']($_GET['imei']);
	}else{
		$_GET['function']();
	}
}

?>
