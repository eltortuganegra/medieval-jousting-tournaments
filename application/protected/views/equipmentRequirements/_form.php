<?php
/* @var $this EquipmentRequirementsController */
/* @var $model EquipmentRequirements */
/* @var $model equipment */
/* @var $model requirementsList */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-requirements-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php // Load equipment view


if( $model->equipments_type == Inventory::EQUIPMENT_TYPE_ARMOUR ) {
	// Load view for armour	
	echo $this->renderPartial('/armours/_view', array('data'=>Armours::model()->findByPk($model->identificator)));
} else {	
    // Load view for spear
	echo $this->renderPartial('/spears/_view', array('data'=>Spears::model()->findByPk($model->identificator)));    	
} ?>
	<?php echo $form->errorSummary($model); ?>
<?php 
/* by default
	<div class="row">
		<?php echo $form->labelEx($model,'identificator'); ?>
		<?php echo $form->textField($model,'identificator',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'identificator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipments_type'); ?>
		<?php echo $form->textField($model,'equipments_type',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'equipments_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requirements_id'); ?>
		<?php echo $form->textField($model,'requirements_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'requirements_id'); ?>
	</div>
*/
?>
	<div class="row">
		<input type="hidden" name="identificator" value="<?php echo $model->id;?>" />
		<input type="hidden" name="equipments_type" value="<?php echo $model->equipments_type;?>" />
		<?php echo $form->labelEx($model,'requirements_id'); ?>
		<?php //echo $form->textField($model,'requirements_id',array('size'=>10,'maxlength'=>10)); ?>		
		<?php //echo $form->dropDownList('EquipmentRequirements', $model->requirements_id, CHTML::listData(Requirements::model()->findAll(), 'id', 'name' )); 
			echo $form->dropDownList( $model, 'requirements_id', CHTML::listData(Requirements::model()->findAll(), 'id', 'name' ));
		?>
		<?php echo $form->error($model,'requirements_id'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->