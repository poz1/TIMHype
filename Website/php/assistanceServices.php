<?php
//Connessione al DB
require_once ("dbhelper.php");

if($_GET['Type'] == "getDevices")
{
	$query = "SELECT DISTINCT assistanceservice.id as id, device.id as DeviceID, device.Name as DeviceName, device.Brand as Brand, assistanceservice.Image as Image, assistanceservice.Name as Name, assistanceservice.Description as Description FROM assistanceservice join servicesfordevice on assistanceservice.id = servicesfordevice.Service_ID join device WHERE assistanceservice.ID =".$_GET['Id']." and (device.ID = Device_ID or device.Category = Device_ID ) LIMIT 10;";
	
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) 
		{
			$counter = 0;			
			while($row = $result->fetch_assoc()) {
				if ($counter<10){
					if( count($row) > 0 ) {
						echo '<p class="devices-filter-checkbox-description" onclick="navigateToDeviceDetailPage('.$row['DeviceID'].')" ><a href="#">'.$row['Brand'].' '.$row['DeviceName'].'</a></p>';						
					}
				}
				$counter +=1;
			}
			echo '</div></div></div>';
		}
		else {
			echo ' <p class="devices-filter-checkbox-description" style="margin-left: 10px;" > No device is elegible for this Assistance </p></div></div></div>';
		}
		$result->close();
	}
}

if($_GET['Type'] == "getAssistanceService")
{
	$query = " SELECT * FROM assistanceservice WHERE ID =".$_GET['AssistanceServiceId'];

	$result = $conn->query($query);
	if(!empty($result)){
		if ($result->num_rows > 0) {
			$ch = curl_init();	
			$url="http://hypetim.azurewebsites.net/pages/assistanceServices/assistanceServiceDetail.php";
			
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

if($_GET['Type'] == "getAssistanceServiceFAQ")
{
	$query = "SELECT * FROM faqaserivices WHERE ID_Service =".$_GET['AssistanceServiceId'];
	$result = $conn->query($query);
	if(!empty($result)){
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
					echo '<h4 class="assistance-services-detail-field">'.$row['Faq_Title'].'</h4><p class="content-text">'.$row['Faq_Description'].'</p>';
				}
			}
		}
		$result->close();
	}
} 

if($_GET['Type'] == "getCategories")
{
	$query = "SELECT DISTINCT * FROM assistanceservicecategory";
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

if($_GET['Type'] == "getAssistanceServices")
{
	$query = "SELECT * FROM assistanceservice" ;
	
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
				$url="http://hypetim.azurewebsites.net/pages/assistanceServices/assistanceServiceCell.php";
				
				while($row = $result->fetch_assoc()) {
					if( count($row) > 0 ) {
						$row['Highlights'] = 0;
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

if($_GET['Type'] == "getHighlights"){
	
	$query = "SELECT * FROM assistanceservice Where Highlights = 1" ;
	
	$result = $conn->query($query);
	if(!empty($result)){
		if ($result->num_rows > 0) {
			
			$ch = curl_init();
			$url="http://hypetim.azurewebsites.net/pages/assistanceServices/assistanceServiceCell.php";
			
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

if($_GET['Type'] == "getHighlightsMenu"){
	$query = "SELECT * FROM assistanceservice Where Highlights = 1";
	
	$result = $conn->query($query);
	if(!empty($result))
	{		
		$IDs = array();
		while($row = $result->fetch_assoc()) 
		{
			if( count($row) > 0 ) 
			{
				array_push($IDs,$row['ID']);
			}
		}
		for ($i = 0; $i < count($IDs); $i++) 
		{
			if($IDs[$i] == $_GET['ID'])
			{
				$previous = $i - 1;
				$next = $i+1;

						if($i>0){
						echo'
						<div class="navigation">
          					<div class="devices-filter-title-box  device-detail-first">
         						<h4 class="devices-filter-title"><a class="devices-filter-title" href="#" onclick="navigateToAssistanceServicesDetailPage('.$IDs[$previous].',1,0)">Previous Highlight</a></h4>
     						</div>
     					</div>';
						}

						if($next<count($IDs)){
						echo'
						<div class="navigation">
          					<div class="devices-filter-title-box  device-detail-first">
         						<h4 class="devices-filter-title"><a class="devices-filter-title" href="#" onclick="navigateToAssistanceServicesDetailPage('.$IDs[$next].',1,0)">Next Highlight</a></h4>
    						</div>
     					</div>';
						}
			}
		}	
	}
	$result->close();
}
?>