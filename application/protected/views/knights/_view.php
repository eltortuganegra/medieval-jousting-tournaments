<?php
/* @var $this KnightsController */
/* @var $model Knights */
?>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users_id')); ?>:</b>
	<?php echo CHtml::encode($data->users_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suscribe_date')); ?>:</b>
	<?php echo CHtml::encode($data->suscribe_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unsuscribe_date')); ?>:</b>
	<?php echo CHtml::encode($data->unsuscribe_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('endurance')); ?>:</b>
	<?php echo CHtml::encode($data->endurance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('life')); ?>:</b>
	<?php echo CHtml::encode($data->life); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pain')); ?>:</b>
	<?php echo CHtml::encode($data->pain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coins')); ?>:</b>
	<?php echo CHtml::encode($data->coins); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experiencie_earned')); ?>:</b>
	<?php echo CHtml::encode($data->experiencie_earned); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experiencie_used')); ?>:</b>
	<?php echo CHtml::encode($data->experiencie_used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('avatars_id')); ?>:</b>
	<?php echo CHtml::encode($data->avatars_id); ?>
	<br />

	*/ ?>

</div>