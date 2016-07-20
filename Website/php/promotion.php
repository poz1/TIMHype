<?php
require_once ("dbhelper.php");

if($_GET['Type']=="getPromotions"){
	$query ="SELECT * FROM promotions";
	$result = $conn->query($query);
	
	$deviceIDs= array();
	$assistanceServiceIDs= array();
	$smartLifeServiceIDs= array();
	
	if(!empty($result)){
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				switch ($row["Type"]){
					case "SmartLifeService":
											array_push($smartLifeServiceIDs, $row["PromotionID"]);
					break;
					case "AssistanceService":
											array_push($assistanceServiceIDs, $row["PromotionID"]);
					break;
					case "Device":	
											array_push($deviceIDs, $row["PromotionID"]);
					break;
				}
			}
		}
	}
	
	getDeviceCells($deviceIDs, $conn);
	getAssistanceServiceCells($assistanceServiceIDs, $conn);
	getSmartLifeServiceCells($smartLifeServiceIDs, $conn);
}

if($_GET['Type']=="getPromotionsMenu"){
	$query ="SELECT * FROM promotions";
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				if(($_GET["Id"] == $row["PromotionID"]) && ($_GET["Item"] == $row["Type"])){
					
					$previous = $row["ID"] - 1;
					$next = $row["ID"] + 1;


					if($previous>0){
						echo'
								<div class="navigation">
									<div class="devices-filter-title-box  device-detail-first">
										<h4 class="devices-filter-title"><a class="devices-filter-title" href="#" onclick="'.getLink($previous, $conn).'">Previous Promotion</a></h4>
									</div>
								</div>';
					}
					
					if($next<=$result->num_rows){
						echo'
								<div class="navigation">
									<div class="devices-filter-title-box  device-detail-first">
										<h4 class="devices-filter-title"><a class="devices-filter-title" href="#" onclick="'.getLink($next, $conn).'">Next Promotion</a></h4>
									</div>
								</div>';
					}
				}
			}
		}
	}
}

function getLink($id, $mySQL){
	$query ="SELECT * FROM promotions WHERE ID=".$id;
	$result = $mySQL->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				switch ($row["Type"]){
					case "SmartLifeService":
						return "navigateToSmartlifeServiceDetailPage(".$row['PromotionID'].",1)";
					case "AssistanceService":
						return "navigateToAssistanceServicesDetailPage(".$row['PromotionID'].",0,1)";
					case "Device":	
						return "navigateToDeviceDetailPage(".$row['PromotionID'].",1)";
				}
			}
		}
	}
}

function getDeviceCells($IDs, $mySQL){
	
	$query = "SELECT * FROM device Where ID=".$IDs[0];
	unset($IDs[0]);
	
	foreach ($IDs as $id) 
		{
		$query = $query." OR ID= ".$id;
	}
	
	$result = $mySQL->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {
			
			$ch = curl_init();
			$url="http://hypetim.azurewebsites.net/pages/device/deviceCell.php";
			
			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
					$row["Promotion"] = 1;
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

function getAssistanceServiceCells($IDs, $mySQL){
	
	$query = "SELECT * FROM assistanceservice Where ID=".$IDs[0];
	unset($IDs[0]);
	
	foreach ($IDs as $id) 
		{
		$query = $query." OR ID= ".$id;
	}
	
	$result = $mySQL->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {
			
			$ch = curl_init();
			$url="http://hypetim.azurewebsites.net/pages/assistanceservices/assistanceServiceCell.php";
			
			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
					$row["Highlights"] = 0;
					$row["Promotion"] = 1;
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

function getSmartLifeServiceCells($IDs, $mySQL){
	
	$query = "SELECT * FROM smartlifeservice Where ID=".$IDs[0];
	unset($IDs[0]);
	
	foreach ($IDs as $id) 
		{
		$query = $query." OR ID= ".$id;
	}
	
	$result = $mySQL->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {
			
			$ch = curl_init();
			$url="http://hypetim.azurewebsites.net/pages/smartLifeServices/smartLifeServiceCell.php";
			
			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
					$row["Promotion"] = 1;
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
