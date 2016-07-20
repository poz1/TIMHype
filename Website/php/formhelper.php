<?php
//Connessione al DB
require_once ("dbhelper.php");
if($_GET['object'] == "Device"){
if($_GET['Type'] == "BuyDevice")
{
	$query = "SELECT * FROM device WHERE ID =".$_GET['DeviceId'];
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
                     echo ' <div style=" float: left; width: 45%; color: #083D86; text-align: right; margin-left:20px;">';
                    echo '<img src="'.$row["Image"].'" style="height: 120px;" alt="logo"/> </div>';
                    echo ' <div style=" float: left; width: 50%; color: #083D86; text-align: left">';
					echo '<h1 style="color: #083D86" class="form-title">'.$row["Name"].'</h1>';
                    echo '<h1 style="color: #083D86" class="form-title"> Price '.$row["Price"].'€</h1>  </div>';
                    
				}
				
				$response = curl_exec($ch);
			}
			curl_close($ch);
		}
		$result->close();
	}
}
}

if($_GET['object'] == "Smartlife"){
    	$query = "SELECT * FROM slservice WHERE ID =".$_GET['DeviceId'];
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
                     echo ' <div style=" float: left; width: 45%; color: #083D86; text-align: right; margin-left:20px;">';
                    echo '<img src="'.$row["Image_Url"].'" style="height: 120px;" alt="logo"/> </div>';
                    echo ' <div style=" float: left; width: 50%; color: #083D86; text-align: left">';
					echo '<h2 style="color: #083D86" class="form-title">'.$row["Nome"].'</h2>';
                    echo '<h2 style="color: #083D86" class="form-title"> Price '.$row["Prezzo"].'</h2>  </div>';
                    
				}
				
				$response = curl_exec($ch);
			}
			curl_close($ch);
		}
		$result->close();
	}
}
if($_GET['object'] == "Assistance"){
    	$query = "SELECT * FROM aservices WHERE ID =".$_GET['DeviceId'];
	$result = $conn->query($query);
	
	if(!empty($result)){
		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
				
				if( count($row) > 0 ) {
                     echo ' <div style=" float: left; width: 45%; color: #083D86; text-align: right; margin-left:20px;">';
                    echo '<img src="'.$row["Image_Url"].'" style="height: 120px; margin-right:20px;" alt="logo"/> </div>';
                    echo ' <div style=" float: left; width: 50%; color: #083D86; text-align: left">';
					echo '<h2 style="color: #083D86" class="form-title">'.$row["Nome"].'</h2>';
                    echo '<h3 style="color: #083D90" class="form-title">'.$row["DescrizioneBreve"].'</h3>  </div>';
                    
				}
				
				$response = curl_exec($ch);
			}
			curl_close($ch);
		}
		$result->close();
	}
}

?>
