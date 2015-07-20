<?php
/* @var $this SpearsMaterialsController */
/* @var $model SpearsMaterials */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'spears-materials-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'level'); ?>
		<?php echo $form->textField($model,'level'); ?>
		<?php echo $form->error($model,'level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'maximum_damage'); ?>
		<?php echo $form->textField($model,'maximum_damage'); ?>
		<?php echo $form->error($model,'maximum_damage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prize'); ?>
		<?php echo $form->textField($model,'prize',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'prize'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endurance'); ?>
		<?php echo $form->textField($model,'endurance'); ?>
		<?php echo $form->error($model,'endurance'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->