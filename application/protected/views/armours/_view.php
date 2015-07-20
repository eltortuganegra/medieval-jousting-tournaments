<?php
/* @var $this ArmoursController */
/* @var $model Armours */
?>

<div class="view">
	ARMOUR
	<br />
	<div class="right">
		<img alt="<?php echo $data->name?>" src="/images/items/<?php echo Inventory::EQUIPMENT_TYPE_ARMOUR . '_' . $data->id; ?>.png">
	</div>
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->getTypeText() ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('armours_materials_id')); ?>:</b>
	<?php echo CHtml::encode($data->getArmoursMaterialsText() ); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_qualities_id')); ?>:</b>
	<?php echo CHtml::encode($data->getEquipmentQualitiesText()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_size_id')); ?>:</b>
	<?php echo CHtml::encode($data->getEquipmentSizeText()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_rarity_id')); ?>:</b>
	<?php echo CHtml::encode($data->getEquipmentRarityText()); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('endurance')); ?>:</b>
	<?php echo CHtml::encode($data->endurance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pde')); ?>:</b>
	<?php echo CHtml::encode($data->pde); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize')); ?>:</b>
	<?php echo CHtml::encode($data->prize); ?>
	<br />

	*/ ?>
	<?php // Show requirement
	if ($equipmentRequirements_list = EquipmentRequirements::model()->findAll(
					'identificator=:identificator AND equipments_type=:equipments_type',
					array(':identificator'=>$data->id, 'equipments_type'=>Inventory::EQUIPMENT_TYPE_ARMOUR)	
					
	)) {
		foreach ($equipmentRequirements_list as $equipmentRequirements) {
			echo $this->renderPartial('/equipmentRequirements/_view', array('data'=>$equipmentRequirements));
		}
	} 
	?>
</div>