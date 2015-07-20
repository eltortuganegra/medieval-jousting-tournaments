<div id="medievalmarket">
	<h1>Mercado Medieval</h1>
	<div id="filter">
		<div id="filter_legend">			
			<p>Para buscar un tipo de equipamiento selecciona las características que deseas que tenga y pulsa 'buscar'.</p>
			<p>Para comprar un objeto primero tendrás que <strong>encontrar a un mercader que lo venda</strong>. La <strong>rareza</strong> del equipo representa lo difícil que es encontrar ese equipamiento y dependerá de tus <strong>carisma</strong> y <strong>mercadear</strong> el que encuentres el objeto.</p>
			<p>Encontrar un objeto de una determinada rareza te llevará un determinado tiempo, por lo que no podrás hacer búsquedas de otros objetos que no sean 'muy frecuentes'.</p>
			<p>Puedes consultar tu <a href="/medievalmarket/purchasesHistory">historial de compras</a></p>
			<p>¿Sin un moneda? <a href="/jobs">¡Presta tus servicios como caballero!</a></p>
		</div>
		
			<p>Tipo
				<?php echo CHtml::dropDownList( 'inventory_type', $defaultValues['inventory_type'], $inventory_type_list );?>
			</p>
			<div id="filter_spears">	
				<form action="medievalmarket" method="post">
					<input type="hidden" name="inventory_type" value="57"/>
					<table>
						<caption>Lanzas</caption>
						<tbody>
							<tr>
								<td>Nombre</td>
								<td><input type="text" name="spear_name" value="<?php echo $defaultValues['spear_name']?>"/></td>
								<td>Material</td>
								<td><?php echo CHtml::dropDownList( 'spear_material', $defaultValues['spear_material'], $spear_material_list, array('empty' => 'Todos') );?></td>
							</tr>
							<tr>
								<td>Daño</td>
								<td>desde <input type="text" name="spear_damage_min" value="<?php echo $defaultValues['spear_damage_min']?>" class="validate[optional,custom[integer]] shortInput"/> hasta <input type="text" name="spear_damage_max" value="<?php echo  $defaultValues['spear_damage_max']?>" class="validate[optional,custom[integer]] shortInput"/></td>	
								<td>Tamaño</td>
								<td><?php echo CHtml::dropDownList( 'spear_equipment_size',  $defaultValues['spear_equipment_size'], $equipment_size_list, array('empty' => 'Todos') );?></td>						
							</tr>
							<tr>
								<td>PDE</td>
								<td>desde <input type="text" name="spear_pde_min" value="<?php echo  $defaultValues['spear_pde_min']?>" class="validate[optional,custom[integer]] shortInput"/> hasta <input type="text" name="spear_pde_max" value="<?php echo  $defaultValues['spear_pde_max']?>" class="validate[optional,custom[integer]] shortInput"/></td>
								<td>Calidad</td>
								<td><?php echo CHtml::dropDownList( 'spear_equipment_quality',  $defaultValues['spear_equipment_quality'], $equipment_quality_list, array('empty' => 'Todas') );?></td>							
							</tr>
							<tr>
								<td>Precio</td>
								<td>desde <input type="text" name="spear_prize_min" value="<?php echo  $defaultValues['spear_prize_min']?>" class="validate[optional,custom[integer]] shortInput"/> hasta <input type="text" name="spear_prize_max" value="<?php echo  $defaultValues['spear_prize_max']?>" class="validate[optional,custom[integer]] shortInput"/></td>
								<td>Rareza</td>
								<td><?php echo CHtml::dropDownList( 'spear_equipment_rarity',  $defaultValues['spear_equipment_rarity'], $equipment_rarity_list, array('empty' => 'Todas') );?></td>							
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td><input type="submit" value="buscar"/></td>						
							</tr>
						</tbody>
					</table>
				</form>	
			</div>
			<div id="filter_armours">
				<form action="medievalmarket" method="post">
					<input type="hidden" name="inventory_type" value="56"/>
					<table>
						<caption>Armaduras</caption>
						<tbody>
							<tr>
								<td>Nombre</td>
								<td><input type="text" name="armour_name" value="<?php echo $defaultValues['armour_name']?>"/></td>
								<td>Material</td>
								<td><?php echo CHtml::dropDownList( 'armour_material',  $defaultValues['armour_material'], $armour_material_list, array('empty' => 'Todos') );?></td>
							</tr>
							<tr>
								<td>Resistencia</td>
								<td>desde <input type="text" name="armour_endurance_min" value="<?php echo  $defaultValues['armour_endurance_min']?>" class="validate[optional,custom[integer]] shortInput"/> hasta <input type="text" name="armour_endurance_max" value="<?php echo  $defaultValues['armour_endurance_max']?>" class="validate[optional,custom[integer]] shortInput"/></td>	
								<td>Tamaño</td>
								<td><?php echo CHtml::dropDownList( 'armour_equipment_size',  $defaultValues['armour_equipment_size'], $equipment_size_list, array('empty' => 'Todos') );?></td>						
							</tr>
							<tr>
								<td>PDE</td>
								<td>desde <input type="text" name="armour_pde_min" value="<?php echo  $defaultValues['armour_pde_min']?>" class="validate[optional,custom[integer]] shortInput"/> hasta <input type="text" name="armour_pde_max" value="<?php echo  $defaultValues['armour_pde_max']?>" class="validate[optional,custom[integer]] shortInput"/></td>
								<td>Calidad</td>
								<td><?php echo CHtml::dropDownList( 'armour_equipment_quality',  $defaultValues['armour_equipment_quality'], $equipment_quality_list, array('empty' => 'Todas') );?></td>							
							</tr>
							<tr>
								<td>Precio</td>
								<td>desde <input type="text" name="armour_prize_min" value="<?php echo  $defaultValues['armour_prize_min']?>" class="validate[optional,custom[integer]] shortInput"/> hasta <input type="text" name="armour_prize_max" value="<?php echo  $defaultValues['armour_prize_max']?>" class="validate[optional,custom[integer]] shortInput"/></td>
								<td>Rareza</td>
								<td><?php echo CHtml::dropDownList( 'armour_equipment_rarity',  $defaultValues['armour_equipment_rarity'], $equipment_rarity_list, array('empty' => 'Todas') );?></td>							
							</tr>
							<tr>								
								<td>Tipo</td>
								<td><?php echo CHtml::dropDownList( 'armour_type',  $defaultValues['armour_type'], $armour_type_list, array('empty' => 'Todas') );?></td>
								<td></td>
								<td><input type="submit" value="buscar"/></td>						
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div id="filter_tricks">
				<table>
					<caption>Trampas</caption>
					<tbody>
						<tr>
							<td>No disponible</td>
							
						</tr>
					</tbody>
				</table>
			</div>			
		</form>
	</div>
	<div id="list">
		<p>Resultados de la búsqueda (<?php echo count($result)?>)</p>
		<?php if($defaultValues['inventory_type']==Inventory::EQUIPMENT_TYPE_ARMOUR):?>			
			<?php if( count($result) > 0 ):?>			
			<table>
				<thead>
					<tr>
						<td>Imagen</td>
						<td>Nombre</td>
						<td>Tipo</td>
						<td>Material</td>
						<td>Calidad</td>
						<td>Tamaño</td>
						<td>Rareza</td>
						<td>Resistencia</td>
						<td>PDE</td>
						<td>Precio</td>
						<td>Acción</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($result as $row):?>
					<tr>
						<td><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$row->id;?>.png" alt="<?php echo $row->name?>"></td>
						<td><?php echo $row->name?></td>
						<td><?php echo $armour_type_list[$row->type]?></td>
						<td><?php echo $armour_material_list[$row->armours_materials_id]?></td>
						<td><?php echo $equipment_quality_list[$row->equipment_qualities_id]?></td>
						<td><?php echo $equipment_size_list[$row->equipment_size_id]?></td>
						<td><?php echo $equipment_rarity_list[$row->equipment_rarity_id]?></td>
						<td><?php echo ($row->endurance+1).'-'.($row->endurance+10)?></td>
						<td><?php echo $row->pde?></td>
						<td><?php echo $row->prize?></td>
						<?php if($row->equipment_rarity_id==EquipmentRarity::VERY_COMMON):?>
							<td><a href="/medievalmarket/confirmBuy/inventory_type/<?php echo Inventory::EQUIPMENT_TYPE_ARMOUR.'/id/'.$row->id?>" class="medievalmarket_buy">comprar</a></td>
						<?php else:?>
							<td><a href="/medievalmarket/confirmFind/inventory_type/<?php echo Inventory::EQUIPMENT_TYPE_ARMOUR.'/id/'.$row->id?>" class="medievalmarket_find">encontrar</a></td>
						<?php endif;?>						
					</tr>	
					<?php endforeach;?>
				</tbody>
			</table>
			<?php endif;?>
		<?php elseif ($defaultValues['inventory_type']==Inventory::EQUIPMENT_TYPE_SPEAR):?>
			<?php if( count($result) > 0 ):?>			
			<table>
				<thead>
					<tr>
						<td>Imagen</td>
						<td>Nombre</td>						
						<td>Material</td>
						<td>Calidad</td>
						<td>Tamaño</td>
						<td>Rareza</td>
						<td>Daño</td>
						<td>PDE</td>
						<td>Precio</td>
						<td>Acción</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($result as $row):?>
					<tr>
						<td><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$row->id;?>.png" alt="<?php echo $row->name?>"></td>
						<td><?php echo $row->name?></td>						
						<td><?php echo $spear_material_list[$row->spears_materials_id]?></td>
						<td><?php echo $equipment_quality_list[$row->equipment_qualities_id]?></td>
						<td><?php echo $equipment_size_list[$row->equipment_size_id]?></td>
						<td><?php echo $equipment_rarity_list[$row->equipment_rarity_id]?></td>
						<td><?php echo (1+$row->damage).' - '.($row->damage+10)?></td>
						<td><?php echo $row->pde?></td>
						<td><?php echo $row->prize?></td>
						<?php // Check if knight has item requirements			
						/*			
						$requirementsAccomplish = true; // 
						if (!Yii::app()->user->isGuest 
							&& $equipmentRequirementsList = EquipmentRequirements::model()->findAll(
									'identificator=:identificator AND equipments_type=:equipments_type',
									array(':identificator'=>$row->id, ':equipments_type'=>Inventory::EQUIPMENT_TYPE_SPEAR))
						) {

							// Check if all requirements are accomplish. Load requirements
							foreach ($equipmentRequirementsList as $equipmentRequirements) {
								// Load requirement
								$requirement = Requirements::model()->findByPk($equipmentRequirements->requirements_id);
								// Check level								
								if (($requirement->level!=null && $requirement->value < $this->user_data['knights']->level)) {
									$requirementsAccomplish = false;
									 
								} //Check attribute 
								else if ($requirement->attribute!=null) {
									// Load name of characteristic
									$attributeName = Constants::model()->findByPk($requirement->attribute);									
									if ($requirement->value >= $this->user_data['knights_card']->{$attributeName->name}){
										$requirementsAccomplish = false;
									}
								} // Check skill
								else if ($requirement->skill!=null) {
									$attributeName = Constants::model()->findByPk($requirement->skill);
									if ($requirement->value >= $this->user_data['knights_card']->{$attributeName->name}) {
										$requirementsAccomplish = false;
									}
								}
							}
						}
						*/
Yii::trace('[APP] checkAccomplish index');
						?>
						<?php if (!Yii::app()->user->isGuest && !EquipmentRequirements::checkAccomplish(
								Inventory::EQUIPMENT_TYPE_SPEAR, 
								$row->id, 
								$this->user_data['knights']->id)) :?>
							<td><a href="/medievalmarket/requirements/equipments_type/<?php echo Inventory::EQUIPMENT_TYPE_SPEAR.'/id/'.$row->id?>" class="medievalmarket_requirements">requisitos</a></td>
						<?php else :?> 
							<?php if($row->equipment_rarity_id==EquipmentRarity::VERY_COMMON):?>
								<td><a href="/medievalmarket/confirmBuy/equipments_type/<?php echo Inventory::EQUIPMENT_TYPE_SPEAR.'/id/'.$row->id?>" class="medievalmarket_buy">comprar</a></td>
							<?php else:?>
								<td><a href="/medievalmarket/confirmFind/equipments_type/<?php echo Inventory::EQUIPMENT_TYPE_SPEAR.'/id/'.$row->id?>" class="medievalmarket_find">encontrar</a></td>
							<?php endif;?>						
						<?php endif;?>
					</tr>	
					<?php endforeach;?>
				</tbody>
			</table>
			<?php endif;?>
		<?php elseif ($defaultValues['inventory_type']==Inventory::EQUIPMENT_TYPE_TRICK):?>
		
		<?php endif;?>
	</div>
</div>