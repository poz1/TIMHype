<?php
//Connessione al DB
require_once ("dbhelper.php");

if($_GET['Type']=="getDevices"){
	
	$query = "SELECT * FROM devicesforsmartlifeservice join device on ID=deviceID Where smartLifeServiceID=".$_GET['Id'];
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

if($_GET['Type'] == "getService")
{
	$query = " SELECT * FROM smartlifeservice WHERE ID =".$_GET['Id'];

	$result = $conn->query($query);
	if(!empty($result)){
		if ($result->num_rows > 0) {
			$ch = curl_init();	
			$url="http://hypetim.azurewebsites.net/pages/smartLifeServices/smartLifeServiceDetail.php";
			
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

if($_GET['Type'] == "getCategories")
{
	$query = "SELECT DISTINCT * FROM smartlifeservicecategory";
	$result = $conn->query($query);
	
	if(!empty($result)){
			while($row = $result->fetch_assoc()) {
				if( count($row) > 0 ) {
					echo "<p class=\"devices-filter-category-description\"><a href=\"#\" id=\"".$row['ID']."\">".$row['Name']."</a></p>";
				}
			}
		$result->close();
	}
}

if($_GET['Type'] == "getServices")
{
	$query = "SELECT * FROM smartlifeservice" ;
	if(!empty($_GET['Category']))
	{	
		if(!($_GET['Category'] == 0)){
			$query = $query." WHERE Category=". $_GET['Category'] . "";		
		}
	}

	$result = $conn->query($query);

	if(!empty($result)){
		if ($result->num_rows > 0) 
		{
				$ch = curl_init();
				$url="http://hypetim.azurewebsites.net/pages/smartLifeServices/smartLifeServiceCell.php";
				
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
?>