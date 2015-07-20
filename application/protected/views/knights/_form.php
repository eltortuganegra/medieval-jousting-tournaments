<?php
/* @var $this KnightsController */
/* @var $model Knights */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'knights-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'users_id'); ?>
		<?php echo $form->textField($model,'users_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'users_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'suscribe_date'); ?>
		<?php echo $form->textField($model,'suscribe_date'); ?>
		<?php echo $form->error($model,'suscribe_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unsuscribe_date'); ?>
		<?php echo $form->textField($model,'unsuscribe_date'); ?>
		<?php echo $form->error($model,'unsuscribe_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'level'); ?>
		<?php echo $form->textField($model,'level'); ?>
		<?php echo $form->error($model,'level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endurance'); ?>
		<?php echo $form->textField($model,'endurance'); ?>
		<?php echo $form->error($model,'endurance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'life'); ?>
		<?php echo $form->textField($model,'life'); ?>
		<?php echo $form->error($model,'life'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pain'); ?>
		<?php echo $form->textField($model,'pain'); ?>
		<?php echo $form->error($model,'pain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coins'); ?>
		<?php echo $form->textField($model,'coins',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'coins'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'experiencie_earned'); ?>
		<?php echo $form->textField($model,'experiencie_earned',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'experiencie_earned'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'experiencie_used'); ?>
		<?php echo $form->textField($model,'experiencie_used',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'experiencie_used'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'avatars_id'); ?>
		<?php echo $form->textField($model,'avatars_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'avatars_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->