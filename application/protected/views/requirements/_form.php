<?php
/* @var $this RequirementsController */
/* @var $model Requirements */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'requirements-form',
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
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'level'); ?>
		<?php echo $form->textField($model,'level'); ?>
		<?php echo $form->error($model,'level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute'); ?>
		<?php //echo $form->textField($model,'attribute',array('size'=>10,'maxlength'=>10)); 
		?>
		<?php echo CHtml::dropDownList(
					'Requirements[attribute]', 
					$model->attribute, 
					CHtml::listData(
						Constants::model()->findAll(
							'type=:type', 
							array(':type'=>Constants::KNIGHTS_ATTRIBUTES)
						), 
						'id', 
						'name'
					), 
					array('prompt'=>'Select a attribute')); ?>
		<?php echo $form->error($model,'attribute'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'skill'); ?>
		<?php echo CHtml::dropDownList('Requirements[skill]',$model->skill, CHtml::listData(Constants::model()->findAll('type=:type', array(':type'=>Constants::KNIGHTS_SKILLS)), 'id', 'name'), array('prompt'=>'Select skill')); ?>
		<?php echo $form->error($model,'skill'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
