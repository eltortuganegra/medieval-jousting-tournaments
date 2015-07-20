<?php
/* @var $this CombatsController */
/* @var $model Combats */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_knight')); ?>:</b>
	<?php echo CHtml::encode($data->from_knight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_knight')); ?>:</b>
	<?php echo CHtml::encode($data->to_knight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('result')); ?>:</b>
	<?php echo CHtml::encode($data->result); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('result_by')); ?>:</b>
	<?php echo CHtml::encode($data->result_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_knight_injury_type')); ?>:</b>
	<?php echo CHtml::encode($data->from_knight_injury_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_knight_injury_type')); ?>:</b>
	<?php echo CHtml::encode($data->to_knight_injury_type); ?>
	<br />

	*/ ?>

</div>