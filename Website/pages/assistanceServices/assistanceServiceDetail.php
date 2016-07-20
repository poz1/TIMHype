<h1 class="content-title"><?php if (!empty($_GET['Name'])){ echo $_GET['Name']; }?></h1>
<div class="devices-device-detail-box realsize" id="AssistanceServiceDetail">
    <div>
        <?php if (!empty($_GET['Abstract'])){?>
            <p class="assistance-service-abstract"><?php echo $_GET['Abstract'];?></p>
        <?php }?>
        <img class="devices-device-detail-image" src="<?php if (!empty($_GET['Image'])){ echo $_GET['Image']; }?>"/>
        <div class="devices-device-detail-description"> 
        
        <?php if (!empty($_GET['Description'])){?>
        	<h3 class="assistance-services-detail-field">Description:</h3> 
            <p class="content-text"><?php echo $_GET['Description'];?></p>
        <?php }?>
        
        <?php if (!empty($_GET['Benefits'])){?>
            <h3 class="assistance-services-detail-field">Benefits:</h3> 
            <p class="content-text"><?php echo $_GET['Benefits'];?></p>
        <?php }?>

        <?php if (!empty($_GET['HowToRequireIt'])){?>
            <h3 class="assistance-services-detail-field">How to require it:</h3> 
            <p class="content-text"><?php echo $_GET['HowToRequireIt'];?></p>
        <?php }?>
        
        <h3 class="assistance-services-detail-field" id="FAQ">FAQ:</h3> 
    </div>
    <button class="devices-device-detail-buy-button" onclick="navigateToAssistanceFormPage(<?php echo $_GET['ID'] ?>)">Richiedi ora!</button>
</div>
   