$(function(){
	//var functionName = 'GetProducts';
	var functionName = 'GetMobilockDevicesProfiles';
	
	
	//Get Products
	function LoadData(){
		var all_data = [];		
		//$.getJSON("http://192.168.0.77:9999/kubernetes/dpidashboard/imei_api.php?function="+functionName+"&jsonCallback=?", function(data){
		$.getJSON("http://dpidashboard-expo.7e14.starter-us-west-2.openshiftapps.com/dpidashboard/mobilock_api.php?function="+functionName+"&jsonCallback=?", function(data){
			
			if(data==="error"){
				alert("error");
			}else{
				var array_data = '<option>Choose subscriber</optionn>';
					all_data.push(array_data);
				$.each(data, function(k, name){
					var array_data = '<option>'+name+'</optionn>';
					all_data.push(array_data);
				});
				$('#ahmoption').append(all_data);
			}
		});
	}
	
	LoadData();
	
});
