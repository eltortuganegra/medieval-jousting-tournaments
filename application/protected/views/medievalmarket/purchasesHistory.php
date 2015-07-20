<div id="purchasesHistory">
	<h2>Historial de compras</h2>
	<p>Aquí aparecen todas las compras y búsquedas que has realizado en el <a href="/medievalmarket" title="ir a mercado medieval">mercado medieval</a>.</p>
	
	<?php if(count( $result)>0 ):?>		
		<p class="paginator">
			<?php 
				$maxPages = ceil($total_purchases/$rowsByPage);
				if( $maxPages > 1){
					for($i=1;$i<=$maxPages;$i++){
						if( $i == $page ){
							echo '<span class="paginator_enable">'.$i.'</span> ';
						}else{
							echo '<a href="/medievalmarket/purchasesHistory/page/'.$i.'">'.$i.'</a>';
						} 
					}
				} 
			?>
		</p>
		<table>
			<thead>
				<tr>
					<td>Imagen</td>
					<td>Nombre</td>
					<td>Precio</td>
					<td>Rareza</td>
					<td><abbr title="Dificultad de busqueda">Dificultad</abbr></td>
					<td>Carisma</td>
					<td>Mercadear</td>
					<td>% éxito</td>
					<td>fecha</td>
					<td>estado</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $result as $row):?>
					<?php if( $row->inventory_type_id == Inventory::EQUIPMENT_TYPE_ARMOUR ):?>
						<tr>
							<td><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$row->inventory_type_id.'_'.$row->identificator?>.png"></td>
							<td><?php echo $armours_list[$row->identificator]->name?></td>
							<td><?php echo $armours_list[$row->identificator]->prize?></td>
							<td><?php echo $equipment_rarity[$armours_list[$row->identificator]->equipment_rarity_id]->name?></td>
							<td><?php echo $equipment_rarity[$armours_list[$row->identificator]->equipment_rarity_id]->difficulty?></td>
							<td><?php echo $row->knights_card_charisma?></td>
							<td><?php echo $row->knights_card_trade?></td>
							<?php if( $armours_list[$row->identificator]->equipment_rarity_id == EquipmentRarity::VERY_COMMON):?>
								<td>100%</td>
							<?php else:?>
								<td>
									<?php 
									$percent = $row->knights_card_charisma+$row->knights_card_trade+10-$equipment_rarity[$armours_list[$row->identificator]->equipment_rarity_id]->difficulty;
									echo ($percent < 0)?0:$percent*10;
									?>%
								</td>
							<?php endif;?>
							<td><?php echo $row->date?></td>
							<td>
							<?php 
							switch($row->status){
								case KnightsPurchases::STATUS_PURCHASED:
									echo 'comprado';
									break;
								case KnightsPurchases::STATUS_SEARCHING:
									echo 'buscando';
									break;
								case KnightsPurchases::STATUS_FOUND:
									echo 'encontrado';
									break;
								case KnightsPurchases::STATUS_NOT_FOUND:
									echo 'no encontrado';
									break;
							}
							?>
							</td>
						</tr>
					<?php elseif( $row->inventory_type_id == Inventory::EQUIPMENT_TYPE_SPEAR):?>
						<tr>
							<td><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$row->inventory_type_id.'_'.$row->identificator?>.png"></td>
							<td><?php echo $spears_list[$row->identificator]->name?></td>
							<td><?php echo $spears_list[$row->identificator]->prize?></td>
							<td><?php echo $equipment_rarity[$spears_list[$row->identificator]->equipment_rarity_id]->name?></td>
							<td><?php echo $equipment_rarity[$spears_list[$row->identificator]->equipment_rarity_id]->difficulty?></td>
							<td><?php echo $row->knights_card_charisma?></td>
							<td><?php echo $row->knights_card_trade?></td>
							<?php if( $spears_list[$row->identificator]->equipment_rarity_id == EquipmentRarity::VERY_COMMON):?>
								<td>100%</td>
							<?php else:?>
								<td>
									<?php 
									$percent = $row->knights_card_charisma+$row->knights_card_trade+10-$equipment_rarity[$spears_list[$row->identificator]->equipment_rarity_id]->difficulty;
									echo ($percent < 0)?0:$percent*10;
									?>%
								</td>
							<?php endif;?>
							<td><?php echo $row->date?></td>
							<td>
							<?php 
							switch($row->status){
								case KnightsPurchases::STATUS_PURCHASED:
									echo 'comprado';
									break;
								case KnightsPurchases::STATUS_SEARCHING:
									echo 'buscando';
									break;
								case KnightsPurchases::STATUS_FOUND:
									echo 'encontrado';
									break;
								case KnightsPurchases::STATUS_NOT_FOUND:
									echo 'no encontrado';
									break;
							}
							?>
							</td>
						</tr>
					<?php endif;?>
				<?php endforeach;?>
			</tbody>
		</table>
		<p class="paginator">
			<?php 
				$maxPages = ceil($total_purchases/$rowsByPage);
				if( $maxPages > 1){
					for($i=1;$i<=$maxPages;$i++){
						if( $i == $page ){
							echo '<span class="paginator_enable">'.$i.'</span> ';
						}else{
							echo '<a href="/medievalmarket/purchasesHistory/page/'.$i.'">'.$i.'</a>';
						} 
					}
				} 
			?>
		</p>
	<?php else:?>
		<p>Todavía no has realizado ninguna compra ni búsqueda.</p>
	<?php endif;?>
</div>