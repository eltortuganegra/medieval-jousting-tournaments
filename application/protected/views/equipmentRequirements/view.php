<?php
/* @var $this EquipmentRequirementsController */
/* @var $model EquipmentRequirements */

$this->breadcrumbs=array(
	'Equipment Requirements'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EquipmentRequirements', 'url'=>array('index')),
	array('label'=>'Create EquipmentRequirements', 'url'=>array('create')),
	array('label'=>'Update EquipmentRequirements', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentRequirements', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentRequirements', 'url'=>array('admin')),
);
?>

<h1>View EquipmentRequirements #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'identificator',
		'equipments_type',
		'requirements_id',
	),
)); ?>
