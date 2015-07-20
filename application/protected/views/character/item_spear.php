<div class="item item_position_lanza">
	<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$item->type.'_'.$item_info['spears_id'];?>.png"/>
	<div class="item_info" style="display:none">		
		<div class="item_info_background"></div>
		<h3><?php echo $item_info['name'];?></h3>
		<p class="description"></p>
		<table>
			<tbody>				
				<tr>					
					<tr>
						<td>Material</td>
						<td><?php echo $item_info['spearsMaterialName'];?></td>
					</tr>
					<tr>
						<td>Calidad</td>
						<td><?php echo $item_info['equipmentQualitiesName'];?></td>
					</tr>
					<tr>
						<td>Tamaño</td>
						<td><?php echo $item_info['equipmentSizeName'];?></td>
					</tr>
					<tr>
						<td>Rareza</td>
						<td><?php echo $item_info['equipmentRarityName'];?></td>
					</tr>
					<tr>
						<td>Daño</td>
						<td><?php echo ($item_info['spears_damage']+1).' - '.($item_info['spears_damage']+10);?></td>
					</tr>
					<tr>
						<td><abbr title="Puntos de Daño Estructural">PDE</abbr></td>
						<td><?php echo $item_info['current_pde'].'/'.$item_info['PDE'];?></td>
					</tr>
					<tr>
						<td>Precio</td>
						<td><?php echo $item_info['spearPrize'];?></td>
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
				</tr>
			</tbody>
		</table>	
	</div>
</div>