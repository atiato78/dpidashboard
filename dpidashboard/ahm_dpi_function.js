$(function(){
	
	/************************/
	/************************/
	
	var functionName = 'GetSubscriberProfiles';
	function Load_All_SubscriberProfilesData(){		
		$.getJSON("http://dpidashboard-expo.7e14.starter-us-west-2.openshiftapps.com/dpidashboard/getsubscriberprofiles_api.php?function="+functionName+"&jsonCallback=?", function(data1){
			Load_PoliciesData(data1, 'GetPolicies')
		});
	}
	function Load_PoliciesData(data1, thisfunctionName){
		$.getJSON("http://localhost:8080/kubernetes/dpidashboard/getpolicies_api.php?function="+thisfunctionName+"&jsonCallback=?", function(data2){
			
			if(data2==="error"){
				alert("error");
			}else{
				var array_data = "<table class='responstable' id='ahm_dpi_table'><tr><th>Id</th><th>MSISDN</th><th>Current Policy</th><th>IMEI</th><th>Change Policy</th></tr>";
				
				$.each(data1, function(k, name){
					 array_data = array_data + name+""+data2;			
				});
				array_data = array_data +"</table>";
				$('#ahm_dpi_table_div').append(array_data);
			}
		});
	}	
	
	
	//Load_All_SubscriberProfilesData();
	
	/************************/
	/************************/
	

	
	
	
});
