<div class="item item_position_<?php echo str_replace(' ', '_', (strpos( $item_info['armours_type_name'], 'escudo')!==false )?'escudo':$item_info['armours_type_name'] )?>">
	<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$item->type.'_'.$item_info['armours_id'];?>.png" class="item_img"/>
	<div class="item_info">
		<div class="item_info_background"></div>
		<h3><?php echo $item_info['armours_type_name'];?></h3>		
		<table>
			<tbody>
				<tr>
					<td>Tipo</td>
					<td class="right"><?php echo $item_info['armours_type_name'];?></td>
				</tr>
				<tr>
					<td>Material</td>
					<td class="right"><?php echo $item_info['armoursMaterialName'];?></td>
				</tr>
				<tr>
					<td>Calidad</td>
					<td class="right"><?php echo $item_info['equipmentQualitiesName'];?></td>
				</tr>
				<tr>
					<td>Tamaño</td>
					<td class="right"><?php echo $item_info['equipmentSizeName'];?></td>
				</tr>
				<tr>
					<td>Rareza</td>
					<td class="right"><?php echo $item_info['equipmentRarityName'];?></td>
				</tr>
				<tr>
					<td>Resistencia</td>
					<?php 
					//Check if shield or armour
					if(strpos( $item_info['armours_type_name'], 'escudo')!==false ):?>
						<td class="right"><?php echo '+'.$item_info['armoursMaterialEndurance'];?></td>
					<?php else:?>
						<td class="right"><?php echo ($item_info['armoursMaterialEndurance']+1).'-'.($item_info['armoursMaterialEndurance']+10);?></td>
					<?php endif;?>
				</tr>
				<tr>
					<td><abbr title="Puntos de Daño Estructural">PDE</abbr></td>
					<td class="right"><?php echo $item_info['current_pde'].'/'.$item_info['armoursPDE'];?></td>
				</tr>
				<tr>
					<td>Precio</td>
					<td class="right"><?php echo $item_info['armoursMaterialPrize'];?></td>
				</tr>
				<?php if ($item_info['requirement_list']!=null) :?>
					<tr>
						<td>Requirements</td>
						<td class="right"></td>
					</tr>
					<?php foreach ($item_info['requirement_list'] as $requirement) :?>
					<tr>
						<td><?php echo $requirement->name;?></td>
						<td class="right"><?php echo $requirement->description;?></td>
					</tr>
					<?php endforeach;?>
				<?php endif;?>				
			</tbody>
		</table>		
	</div>
</div>