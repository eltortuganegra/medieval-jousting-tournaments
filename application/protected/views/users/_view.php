<?php
/* @var $this UsersController */
/* @var $model Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password_md5')); ?>:</b>
	<?php echo CHtml::encode($data->password_md5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password_sha512')); ?>:</b>
	<?php echo CHtml::encode($data->password_sha512); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suscribe_date')); ?>:</b>
	<?php echo CHtml::encode($data->suscribe_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unsuscribe_date')); ?>:</b>
	<?php echo CHtml::encode($data->unsuscribe_date); ?>
	<br />


</div>