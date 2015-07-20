<?php
/* @var $this ArmoursMaterialsController */
/* @var $model ArmoursMaterials */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'armours-materials-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endurance'); ?>
		<?php echo $form->textField($model,'endurance'); ?>
		<?php echo $form->error($model,'endurance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prize'); ?>
		<?php echo $form->textField($model,'prize',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'prize'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->