<div id="round_pending_round">
	<div id="layer2">	
		<div id="inventory_primary">
				<h3>EQUIPO EN USO</h3>							
				<div id="inventory_primary_list">
					<img id="knight_image" src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_kgoldrunner.png" alt="caballero"/>
					<div id="ui_inventory_position_1" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[1] ) ) echo $inventory[1];?></div>
					<div id="ui_inventory_position_2" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[2] ) ) echo $inventory[2];?></div>
					<div id="ui_inventory_position_3" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[3] ) ) echo $inventory[3];?></div>
					<div id="ui_inventory_position_4" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[4] ) ) echo $inventory[4];?></div>
					<div id="ui_inventory_position_5" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[5] ) ) echo $inventory[5];?></div>
					<div id="ui_inventory_position_6" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[6] ) ) echo $inventory[6];?></div>
					<div id="ui_inventory_position_7" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[7] ) ) echo $inventory[7];?></div>
					<div id="ui_inventory_position_8" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[8] ) ) echo $inventory[8];?></div>
					<div id="ui_inventory_position_9" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[9] ) ) echo $inventory[9];?></div>
					<div id="ui_inventory_position_10" class="ui_inventory_position ui_inventory_position_in_use"><?php if( isset($inventory[10] ) ) echo $inventory[10];?></div>				
				</div>			
			</div>
		<div id="inventory_secondary">
			<h3>EQUIPO SECUNDARIO</h3>
			<ul id="inventory_secondary_list">
				<?php for($i = 11;$i<43;$i++){				
					echo '<div id="ui_inventory_position_'.$i.'" class="ui_inventory_position ui_inventory_position_all">'.(( isset($inventory[$i] ) )?$inventory[$i]:'').'</div>';				
				}?>
			</ul>
		</div>
	</div>
	<div id="layer1">
		
	</div>
</div>