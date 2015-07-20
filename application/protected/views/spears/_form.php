<?php
/* @var $this SpearsController */
/* @var $model Spears */
/* @var $form CActiveForm */
?>
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/Spears.js');
  //$cs->registerCssFile($baseUrl.'/css/yourcss.css');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'spears-form',
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
		<?php echo $form->labelEx($model,'spears_materials_id'); ?>		
		<?php echo $form->dropDownList($model,'spears_materials_id',$model->getSpearsMaterialsOptions()); ?>
		<?php echo $form->error($model,'spears_materials_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipment_size_id'); ?>
		<?php echo $form->dropDownList($model,'equipment_size_id', $model->getEquipmentSizeOptions() ); ?>
		<?php echo $form->error($model,'equipment_size_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipment_qualities_id'); ?>
		<?php echo $form->dropDownList($model,'equipment_qualities_id', $model->getEquipmentQualityOptions()); ?>
		<?php echo $form->error($model,'equipment_qualities_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipment_rarity_id'); ?>
		<?php echo $form->dropDownList($model,'equipment_rarity_id', $model->getEquipmentRarityOptions()); ?>
		<?php echo $form->error($model,'equipment_rarity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'damage'); ?>
		<?php echo $form->textField($model,'damage'); ?>
		<?php echo $form->error($model,'damage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pde'); ?>
		<?php echo $form->textField($model,'pde'); ?>
		<?php echo $form->error($model,'pde'); ?>
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
<h1>Requirements</h1>
<?php // Load requirements
/*
 * Requirements
 * Only for update.
 */
if( empty($model->id ) ) {
	// For new requeriments the spears must to exist
	echo "First, you must built the spear for later update and to add requirements.";
} else {
	echo '<p><a href="/equipmentRequirements/create/identificator/' . $model->id . '/equipments_type/' . Inventory::EQUIPMENT_TYPE_SPEAR . '">Add new requirement</a></p>';
	// Updating 
	$equipmentRequirementsList = EquipmentRequirements::model()->findAll( 
			'identificator=:identificator AND equipments_type=:equipments_type',
			array(':identificator'=>$model->id, ':equipments_type'=>Inventory::EQUIPMENT_TYPE_SPEAR));
	// Check if spear has requirements
	if( $equipmentRequirementsList ) {
		foreach ($equipmentRequirementsList as $equipmentRequirements) {
			echo $this->renderPartial('/equipmentRequirements/_view', array('data'=>$equipmentRequirements));
		}	
	} else {
		// No requirements found
		echo "Not found";
	}
} ?>
</div><!-- form -->