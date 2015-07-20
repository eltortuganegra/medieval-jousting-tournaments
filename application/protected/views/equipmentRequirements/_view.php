<?php
/* @var $this EquipmentRequirementsController */
/* @var $model EquipmentRequirements */
?>

<div class="view">
	EQUIPMENT REQUIREMENT
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('equipmentRequirements/view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identificator')); ?>:</b>
	<?php echo CHtml::encode($data->identificator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipments_type')); ?>:</b>
	<?php echo CHtml::encode($data->equipments_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requirements_id')); ?>:</b>
	<?php echo CHtml::encode(Requirements::model()->findByPk($data->requirements_id)->name); ?>
	<br />


</div>