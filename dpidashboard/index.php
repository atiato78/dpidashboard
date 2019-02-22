<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>DPI Provisioning Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
</head>

<body>
</br>
<div style="background-color: #0D7681; height:75px;" >
	<img src="logo_immovate.png" alt="Cinque Terre" width="200" height="70" style="margin-left:30px;margin-top:4px;">
</div>	<div align="center">
	<div id="data">
	</div>
		<h1>MobiLock <span>Subscribers</span></h1>
		<div style="width:30%" >
			<select   id="ahmoption" onchange="chooseSubscriber()">
			</select>
		</div>
		</br></br>
		</br></br>
		
		<div style="width:70%">
		<h1>DPI<span> Information</span></h1>
		<div id="ahm_dpi_table_div">
			<table class='responstable' id='ahm_dpi_table'><tr><th>Id</th><th>MSISDN</th><th>Current Policy</th><th>IMEI</th><th>Change Policy</th></tr><tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr></table>
		</div>
		</br></br>
			
		<button onClick="submit()">Save changes</button>
	  </div>
	  </div>
	  <script type="text/javascript" src="ahm_mobilock_imei_function.js"></script>
	  <script type="text/javascript" src="ahm_dpi_function.js"></script>
	  
	  
	  
	  <script>
	  
	  	
	function chooseSubscriber(){
		
		var e = document.getElementById("ahmoption");
		//var value = e.options[e.selectedIndex].value;
		//var index = e.options[e.selectedIndex].index;
		var text = e.options[e.selectedIndex].text;
		var imei = text.substring(text.indexOf(":")+2);
		removeElement("ahm_dpi_table");
		if(text!=="Choose subscriber"){
			var functionName = 'GetSubscriberProfilePerImei';	
			$.getJSON("http://dpidashboard-expo.7e14.starter-us-west-2.openshiftapps.com/dpidashboard/getsubscriberprofiles_api.php?function="+functionName+"&imei="+imei+"&jsonCallback=?", function(data){
				if(data==="error"){
					alert("error");
				}else{
					Load_PoliciesData2(data, 'GetPolicies');
				}
			});
		}else{
			var array_data = "<table class='responstable' id='ahm_dpi_table'><tr><th>Id</th><th>MSISDN</th><th>Current Policy</th><th>IMEI</th><th>Change Policy</th></tr><tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr></table>";
			
			$('#ahm_dpi_table_div').append(array_data);
		}
	}
	
	function Load_PoliciesData2(data1, thisfunctionName){
		$.getJSON("http://dpidashboard-expo.7e14.starter-us-west-2.openshiftapps.com/dpidashboard/getpolicies_api.php?function="+thisfunctionName+"&jsonCallback=?", function(data2){
			
			if(data2==="error"){
				alert("error");
			}else{
				var array_data = "<table class='responstable' id='ahm_dpi_table'><tr><th>Id</th><th>MSISDN</th><th>Current Policy</th><th>IMEI</th><th>Change Policy</th></tr>";
				
				//$.each(data1, function(k, name){
				//	 array_data = array_data + name +""+data2;			
				//});
				var thisoption = '<option value="">--</option>';			
				for(var b=0; b<data2.length;b=b+2){
					if(b==data2.length-1){
						thisoption = thisoption + '<option value="'+data2[b]+'">'+data2[b+1]+'</option></select></td></tr>';
					}else{
						thisoption = thisoption + '<option value="'+data2[b]+'">'+data2[b+1]+'</option>';
					}
				}
				
				for(var a=0;a<data1.length;a=a+3){
					var policy="";
					for(var b=0; b<data2.length;b=b+2){
						if(data1[a+2]===data2[b]){
							//alert(data1[a+2] + " --- " + data2[b]);
							//policy = data1[a+2] + " - " +data2[b+1];
							policy = data2[b+1];
						}
					}
					
					
					var imeioption = document.getElementById("ahmoption");
					var imeistr = imeioption.options[imeioption.selectedIndex].text;
			
					var imei = imeistr.substring(imeistr.indexOf(":")+2);
					
					array_data = array_data + "<tr><td id='suscriberid'>"+data1[a]+"</td><td id='msisdn'>"+data1[a+1]+"</td><td id='policyname'>"+policy+"</td><td id='imei'>"+imei+"</td><td><select  name='choices-single-defaul' id='ahmoptionpolicy' onchange='choosePolycy()'>"+thisoption;
				}
				array_data = array_data +"</table>";
				$('#ahm_dpi_table_div').append(array_data);
			}
		});
	}
	
	function removeElement(id) {
		var elem = document.getElementById(id);
		return elem.parentNode.removeChild(elem);
	}
	
	
	
	
	function choosePolycy(){
		//$("#ahmoptionpolicy option").each(function(){
		//	alert($(this).val() + " -- " + $(this).text());
		//});
	}
	
	
	function submit(){		
		
		var policyoption = document.getElementById("ahmoptionpolicy");
		var imeioption = document.getElementById("ahmoption");
		var imeistr = imeioption.options[imeioption.selectedIndex].text;
		
		var imei = imeistr.substring(imeistr.indexOf(":")+2);
		var policyid = policyoption.options[policyoption.selectedIndex].value;
		var newpolicyname = policyoption.options[policyoption.selectedIndex].text;
		var msisdn = document.getElementById("msisdn").innerHTML;
		var suscriberid = document.getElementById("suscriberid").innerHTML;
		
		if(policyid!==""){
			if(suscriberid !="--"){
				var functionName = 'UpdateSubscriberPolicy';	
                $.getJSON("http://dpidashboard-expo.7e14.starter-us-west-2.openshiftapps.com/dpidashboard/updatesubscriberpolicy_api.php?function="+functionName+"&msisdn="+msisdn+"&policyid="+policyid+"&suscriberid="+suscriberid+"&jsonCallback=?", function(data){
						if(data==="error"){
							alert("error");
						}else{
							//alert(data);
							document.getElementById("policyname").innerHTML=newpolicyname;
						}
				});
			}else{
				var functionName = 'AddSubscriberPolicy';	
					$.getJSON("http://dpidashboard-expo.7e14.starter-us-west-2.openshiftapps.com/dpidashboard/addsubscriberpolicy_api.php?function="+functionName+"&imei="+imei+"&policyid="+policyid+"&jsonCallback=?", function(data){
						if(data==="error"){
							alert("error");
						}else{
							//alert(data);
							document.getElementById("policyname").innerHTML=newpolicyname;
							document.getElementById("suscriberid").innerHTML=data;
						}
				});
			}
		}
		
	}
	  </script>
	
</body>
</html>
