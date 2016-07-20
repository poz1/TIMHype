<div class="devices-device-box realsize"> 
    <div class="devices-device-inside-box realsize">
        <img class="devices-device-image" src="<?php if (!empty($_GET['Image'])){ echo $_GET['Image']; }?>">
        <div class="devices-device-description">
            <div class="devices-device-title-category-box">
                <h2 class="content-subtitle devices-device-title"><?php if (!empty($_GET['Brand'])){ echo $_GET['Brand']; }?> <?php if (!empty($_GET['Name'])){ echo $_GET['Name']; }?></h2> 
                <h3 class="devices-device-category"><?php if (!empty($_GET['Category'])){ echo $_GET['Category']; }?></h3>
            </div>
            <h2 class="devices-device-content-text"><?php if (!empty($_GET['Price'])){ echo $_GET['Price']; }?>€</h2>  
            <button class="devices-device-more-info-button" onclick="navigateToDeviceDetailPage(<?php echo $_GET['ID'].','.$_GET['Promotion'] ?>)">More info</button>
        </div> 
    </div>
</div>