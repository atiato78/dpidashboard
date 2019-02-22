<?php



$connect = mysqli_connect('localhost:3306','root','','test') or die('Database connection error.'.mysqli_error($connect));
if(!isset($_GET['function'])){
	//die('Some error occured!');
}

function GetProducts($db){
	$sql = mysqli_query($db, 'SELECT * FROM users ORDER BY id ASC LIMIT 0, 10');
	$data = array();
	
	if(mysqli_num_rows($sql) > 0){
		while($row = mysqli_fetch_array($sql)){
			$data[] = $row['name'].' -  IMEI: '.$row['imei'];
		}
		
		$data = json_encode($data);
		echo $_GET['jsonCallback'].'('.$data.')';
	}else{
		echo $_GET['jsonCallback'].'("error")';
	}
	
	
}


if(function_exists($_GET['function'])){
	$_GET['function']($connect);
}

?>