
<div class="content-container">
        <h1 class="content-title"><?php if (!empty($_GET['Brand'])){ echo $_GET['Brand']; }?> <?php if (!empty($_GET['Name'])){ echo $_GET['Name']; }?></h1>
        <div class="devices-device-detail-box realsize">
            <div>
                    <img class="devices-device-detail-image" src="<?php if (!empty($_GET['Image'])){ echo $_GET['Image']; }?>">
                    <div class="devices-device-detail-description"> 
                    
                    <?php if (!empty($_GET['OperativeSystem'])){?>
                    <div class="device-detail-field-box">
                        <h3 class="device-detail-field">Operative System:</h3> 
                        <h3 class="device-detail-field-item"><?php echo $_GET['OperativeSystem'];?></h3>
                    </div>
                    <?php }?>

                    <?php if (!empty($_GET['Storage'])){?>
                    <div class="device-detail-field-box">
                        <h3 class="device-detail-field">Storage:</h3> 
                        <h3 class="device-detail-field-item"><?php echo $_GET['Storage'];?></h3>
                    </div>
                    <?php }?>

                    <?php if (!empty($_GET['Cpu'])){?>
                    <div class="device-detail-field-box">
                        <h3 class="device-detail-field">CPU:</h3> 
                        <h3 class="device-detail-field-item"><?php echo $_GET['Cpu'];?></h3>
                    </div>
                    <?php }?>

                    <?php if (!empty($_GET['Size'])){?>
                    <div class="device-detail-field-box">
                        <h3 class="device-detail-field">Size:</h3> 
                        <h3 class="device-detail-field-item"><?php echo $_GET['Size'];?></h3>
                    </div>
                    <?php }?>

                    <?php if (!empty($_GET['Weight'])){?>
                    <div class="device-detail-field-box">
                        <h3 class="device-detail-field">Weight:</h3> 
                        <h3 class="device-detail-field-item"><?php echo $_GET['Weight'];?></h3>
                    </div>
                    <?php }?>
                
                    <div>
                        <button class="devices-device-detail-buy-button" onclick="navigateToBuyDeviceFormPage(<?php echo $_GET['ID'];?>)">Aquista Ora!</button>
                    </div>
            </div>
            <div class="devices-device-detail-techspec"> 
                <?php if (!empty($_GET['Description'])){?>
                <h3 class="orientation-info">Description</h3> 
                <p class="content-text"><?php echo $_GET['Description'];?></p>
                <?php } ?>
            </div>
        </div>
</div>