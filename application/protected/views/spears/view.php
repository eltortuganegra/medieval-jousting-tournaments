<?php
/* @var $this SpearsController */
/* @var $model Spears */

$this->breadcrumbs=array(
	'Spears'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Spears', 'url'=>array('index')),
	array('label'=>'Create Spears', 'url'=>array('create')),
	array('label'=>'Update Spears', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Spears', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Spears', 'url'=>array('admin')),
);
?>

<h1>View Spears #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'name'=>'spears_materials_id',
			'value'=>CHtml::encode( $model->getSpearsMaterialsText() )
		),
		array(
			'name'=>'equipment_size_id',
			'value'=>CHtml::encode( $model->getEquipmentSizeText() )
		),
		array(
			'name'=>'equipment_qualities_id',
			'value'=>CHtml::encode( $model->getEquipmentQualitiesText() )
		),
		array(
			'name'=>'equipment_rarity_id',
			'value'=>CHtml::encode( $model->getEquipmentRarityText() )
		),
		'damage',
		'pde',
		'prize',
	),
)); ?>

<?php //Check if has requirements

if ($equipmentRequirements_list = EquipmentRequirements::model()->findAll(
		'identificator=:identificator AND equipments_type=:equipments_type', 
		array(':identificator'=>$model->id,':equipments_type'=>Inventory::EQUIPMENT_TYPE_SPEAR	)
	)
) {	
	foreach ($equipmentRequirements_list as $equipmentRequirements) {
		echo $this->renderPartial('/equipmentRequirements/_view', array('data'=>$equipmentRequirements));
	}
} ?>
