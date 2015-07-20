<?php
/* @var $this SpearsController */
/* @var $model Spears */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spears_materials_id'); ?>
		<?php echo $form->textField($model,'spears_materials_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'equipment_size_id'); ?>
		<?php echo $form->textField($model,'equipment_size_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'equipment_qualities_id'); ?>
		<?php echo $form->textField($model,'equipment_qualities_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'equipment_rarity_id'); ?>
		<?php echo $form->textField($model,'equipment_rarity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'damage'); ?>
		<?php echo $form->textField($model,'damage'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pde'); ?>
		<?php echo $form->textField($model,'pde'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prize'); ?>
		<?php echo $form->textField($model,'prize',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->