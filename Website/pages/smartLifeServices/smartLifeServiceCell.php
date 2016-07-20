<div class="devices-device-box realsize"> 
    <div class="devices-device-inside-box realsize">
        <img class="assistance-service-detail-image" src="<?php if (!empty($_GET['Image'])){ echo $_GET['Image']; }?>">
        <div class="devices-device-description">
            <div class="devices-device-title-category-box">
                <h2 class="content-subtitle devices-device-title"><?php if (!empty($_GET['Name'])){ echo $_GET['Name']; }?></h2> 
            </div>
            <button class="devices-device-more-info-button" onclick="navigateToSmartlifeServiceDetailPage(<?php echo $_GET['ID']?><?php echo','.$_GET['Promotion'];?>)">More info</button>
        </div> 
    </div>
</div>