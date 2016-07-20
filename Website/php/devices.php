<?php
//Connessione al DB
require_once ("dbhelper.php");

if($_GET['Type'] == "getDevice")
{
	$query = "SELECT * FROM device WHERE ID =".$_GET['DeviceId'];
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {
			
			$ch = curl_init();
			$url="http://hypetim.azurewebsites.net/pages/device/deviceDetail.php";
			
			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
					$query = http_build_query($row);
					curl_setopt($ch, CURLOPT_URL, "$url?$query");
				}
				
				$response = curl_exec($ch);
			}
			curl_close($ch);
		}
		$result->close();
	}
}

if($_GET['Type'] == "getDevices")
{
	$query = "SELECT * FROM device";
	$firstParameter = true;
	
	if(!empty($_GET['Brand'])){
		if(!is_array($_GET['Brand']))
					$query = $query." WHERE Brand='". $_GET['Brand'] . "'";
		else
				{
			$query = $query." WHERE (Brand='". $_GET['Brand'][0] . "'";
			unset($_GET['Brand'][0]);
			foreach ($_GET['Brand'] as $param) 
						{
				$query = $query." OR Brand='". $param . "'";
			}
			$query = $query.")";
		}
		$firstParameter = false;
	}
	else {
		$query = $query." WHERE Brand=' '";
	}
	
	if(!empty($_GET['PriceMin'])){
		if($firstParameter){
			$query = $query." WHERE Price>'". $_GET['PriceMin'] . "'";
			$firstParameter = false;
		}
		else {
			$query = $query." AND Price>". $_GET['PriceMin'] . "";
		}
	}
	
	if(!empty($_GET['PriceMax'])){
		if($firstParameter){
			$query = $query." WHERE Price<'". $_GET['PriceMax'] . "'";
			$firstParameter = false;
		}
		else {
			$query = $query." AND Price<". $_GET['PriceMax'] . "";
		}
	}
	
	if(!empty($_GET['Category'])){
		
		if(!($_GET['Category'] == "AllCategories")){
			if($firstParameter){
				$query = $query." WHERE Category='". $_GET['Category'] . "'";
				$firstParameter = false;
			}
			else {
				$query = $query." AND Category='". $_GET['Category'] . "'";
			}
		}
	}
	
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {
			
			$ch = curl_init();
			$url="http://hypetim.azurewebsites.net/pages/device/deviceCell.php";
			
			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
					$row["Promotion"] = 0;
					$query = http_build_query($row);
					curl_setopt($ch, CURLOPT_URL, "$url?$query");
				}
				
				$response = curl_exec($ch);
			}
			curl_close($ch);
		}
		$result->close();
	}
}

if($_GET['Type'] == "getBrands"){
	
	/*$query = "SELECT DISTINCT Brand FROM Device";*/
	$query ="SELECT Brand, COUNT(Brand) FROM device GROUP by Brand ORDER BY COUNT(Brand) ASC";
	$result = $conn->query($query);
	
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if( count($row) > 0 ) {
				if($row['COUNT(Brand)'] >= 4){
					echo "<p class=\"devices-filter-checkbox-description\">";
					echo "<input type=\"checkbox\" class=\"devices-filter-checkbox brand\" checked=\"\" id=\"". $row['Brand'] ."\" onclick=\"getDevicesFromDB()\">". $row['Brand'] ."</p>";
				}
			}
		}
	}
}

if($_GET['Type'] == "getCategories"){
	
	$query = "SELECT DISTINCT Category FROM device";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if( count($row) > 0 ) {
				echo "<p class=\"devices-filter-category-description\"><a href=\"#\" id=\"".$row['Category']."\">".$row['Category']."</a></p>";
			}
		}
	}
}

if($_GET['Type']=="getAssistanceServices"){
	
	$query = "SELECT * FROM servicesfordevice join assistanceservice on ID=Service_ID WHERE Service_Type='Assistance' AND (Device_ID=".$_GET['DeviceId']." OR Device_ID= (SELECT Category from device where ID =".$_GET['DeviceId']."))";
	$result = $conn->query($query);

	if(!empty($result)){
		
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc()) {	
				echo '<a href="#" style=" text-decoration: none; color: #083D86"> <p class="devices-filter-checkbox-description" onclick="navigateToAssistanceServicesDetailPage('.$row['ID'].',0,0)">'.$row["Name"].'</p></a>' ;			
			}
		}
		$result->close();
	}
}

if($_GET['Type']=="getSmartLifeServices"){

	$query = "SELECT * FROM servicesfordevice join smartlifeservice on ID=Service_ID WHERE Service_Type='Smartlife' AND (Device_ID=".$_GET['DeviceId']." OR Device_ID= (SELECT Category from device where ID =".$_GET['DeviceId']."))";
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo '<a href="#" style=" text-decoration: none; color: #083D86"> <p class="devices-filter-checkbox-description" onclick="navigateToSmartlifeServiceDetailPage('.$row['ID'].',0)">'.$row["Name"].'</p></a>' ;
			}
		}
		$result->close();
	}	
}
?>
 