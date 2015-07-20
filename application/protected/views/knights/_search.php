<?php
/* @var $this KnightsController */
/* @var $model Knights */
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
		<?php echo $form->label($model,'users_id'); ?>
		<?php echo $form->textField($model,'users_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'suscribe_date'); ?>
		<?php echo $form->textField($model,'suscribe_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unsuscribe_date'); ?>
		<?php echo $form->textField($model,'unsuscribe_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'level'); ?>
		<?php echo $form->textField($model,'level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'endurance'); ?>
		<?php echo $form->textField($model,'endurance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'life'); ?>
		<?php echo $form->textField($model,'life'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pain'); ?>
		<?php echo $form->textField($model,'pain'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coins'); ?>
		<?php echo $form->textField($model,'coins',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'experiencie_earned'); ?>
		<?php echo $form->textField($model,'experiencie_earned',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'experiencie_used'); ?>
		<?php echo $form->textField($model,'experiencie_used',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'avatars_id'); ?>
		<?php echo $form->textField($model,'avatars_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->