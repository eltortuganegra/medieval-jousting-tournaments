<?php
/* @var $this CombatsController */
/* @var $model Combats */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'combats-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from_knight'); ?>
		<?php echo $form->textField($model,'from_knight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'from_knight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to_knight'); ?>
		<?php echo $form->textField($model,'to_knight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'to_knight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'result'); ?>
		<?php echo $form->textField($model,'result',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'result'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'result_by'); ?>
		<?php echo $form->textField($model,'result_by',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'result_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'from_knight_injury_type'); ?>
		<?php echo $form->textField($model,'from_knight_injury_type',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'from_knight_injury_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to_knight_injury_type'); ?>
		<?php echo $form->textField($model,'to_knight_injury_type',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'to_knight_injury_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->