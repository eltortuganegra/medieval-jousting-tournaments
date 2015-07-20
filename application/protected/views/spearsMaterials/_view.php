<?php
/* @var $this SpearsMaterialsController */
/* @var $model SpearsMaterials */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maximum_damage')); ?>:</b>
	<?php echo CHtml::encode($data->maximum_damage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prize')); ?>:</b>
	<?php echo CHtml::encode($data->prize); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endurance')); ?>:</b>
	<?php echo CHtml::encode($data->endurance); ?>
	<br />


</div>