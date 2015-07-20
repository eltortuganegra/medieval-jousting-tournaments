<h3>ATAQUE Y DEFENSA</h3>
<div id="attack_zone" class="select_point_zone">
	<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>knight_armour.png" class="knight_image"/>		
	<table id="attack_table" class="select_point">
		<thead>
			<tr>
				<td colspan="8">ATAQUE</td>
			</tr>
		</thead>				
		<tbody>				
			<?php
			$totalRows = 6;
			$totalColumns = 8; 
			//Make select 
			for($i=0;$i<$totalRows;$i++){ //rows
				echo '<tr>';
				for($j=1;$j<=$totalColumns;$j++){
					$position = $i*$totalColumns+$j;
					if( $position == 1){
						//Insert point for dragg and drop
						//echo '<td id="ui_attack_point_1" class="ui_attack_point_position"><div id="ui_icon_attack_point"><img src="'.Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'attack_point.png"/></div></td>';
						echo '<td id="ui_attack_point_1"><div id="ui_icon_attack_point"><img src="'.Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'attack_point.png"/></div></td>';
					}else{
						//normal
						//echo '<td id="ui_attack_point_'.($i*$totalColumns+$j).'" class="ui_attack_point_position"></td>';
						if( in_array( $position, array(2,3,6,7,8,9,10,11,14,15,16,17,24)) ){
							echo '<td id="ui_attack_point_'.$position.'" class=""></td>';
						}else{
							echo '<td id="ui_attack_point_'.$position.'" class="ui_attack_point_position"></td>';
						}
					}
				}					
				echo '</tr>';
			}?>
		</tbody>
	</table>			
</div>
<div id="defense_zone" class="select_point_zone">
	<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>knight_armour.png" class="knight_image"/>
	<table id="defense_table" class="select_point">
		<thead>
			<tr>
				<td colspan="8">DEFENSA</td>
			</tr>
		</thead>
		<tbody>				
			<?php //Make select 
			for($i=0;$i<$totalRows;$i++){ //rows
				echo '<tr>';
				for($j=1;$j<=$totalColumns;$j++){
					if( $i*$totalColumns+$j == 1){
						//Insert point for dragg and drop
						if( $result ){
							echo '<td class="ui_defense_point_position"><div id="ui_defense_point_1" class="ui_defense_point_position_inner_wrapper"><div id="ui_icon_defense_point" class="ui_icon_shield_size_'.$result[0]['armour_type'].'"><img src="'.Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$result[0]['inventory_type'].'_'.$result[0]['armour_id'].'.png"/></div></div></td>';
						}else{
							echo '<td class="ui_defense_point_position"><div id="ui_defense_point_1" class="ui_defense_point_position_inner_wrapper"></div></td>';
						}
					}else{
						//normal
						echo '<td class="ui_defense_point_position"><div id="ui_defense_point_'.($i*$totalColumns+$j).'" class="ui_defense_point_position_inner_wrapper"></div></td>';
					}
				}					
				echo '</tr>';
			}?>
		</tbody>
	</table>
</div>
<p>La zona de 'ATAQUE' define donde vas a golpear a tu adversario. Arrastra el punto de ataque a la casilla donde quieras.</p>
<p>La zona de 'DEFENSA' define donde vas a cubrirte con tu escudo. Si aciertas a cubrir el punto de ataque del adversario su golpe tendrá mucho menos efecto.</p>