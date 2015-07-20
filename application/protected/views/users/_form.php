<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_md5'); ?>
		<?php echo $form->textField($model,'password_md5',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'password_md5'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_sha512'); ?>
		<?php echo $form->textField($model,'password_sha512',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password_sha512'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->