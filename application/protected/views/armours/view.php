<?php
/* @var $this ArmoursController */
/* @var $model Armours */

$this->breadcrumbs=array(
	'Armours'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Armours', 'url'=>array('index')),
	array('label'=>'Create Armours', 'url'=>array('create')),
	array('label'=>'Update Armours', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Armours', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Armours', 'url'=>array('admin')),
);
?>

<h1>View Armours #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'name'=>'type',
			'value'=>CHtml::encode( $model->getTypeText() )
		),
		array(
			'name'=>'armours_materials_id',
			'value'=>CHtml::encode( $model->getArmoursMaterialsText() )
		),
		array(
			'name'=>'equipment_qualities_id',
			'value'=>CHtml::encode( $model->getEquipmentQualitiesText() )
		),
		array(
			'name'=>'equipment_size_id',
			'value'=>CHtml::encode( $model->getEquipmentSizeText() )
		),
		array(
			'name'=>'equipment_rarity_id',
			'value'=>CHtml::encode( $model->getEquipmentRarityText() )
		),
		'endurance',
		'pde',
		'prize',
	),
)); ?>
<?php //Check if has requirements

if ($equipmentRequirements_list = EquipmentRequirements::model()->findAll(
		'identificator=:identificator AND equipments_type=:equipments_type', 
		array(':identificator'=>$model->id,':equipments_type'=>Inventory::EQUIPMENT_TYPE_ARMOUR)
	)
) {	
	foreach ($equipmentRequirements_list as $equipmentRequirements) {
		echo $this->renderPartial('/equipmentRequirements/_view', array('data'=>$equipmentRequirements));
	}
} ?>