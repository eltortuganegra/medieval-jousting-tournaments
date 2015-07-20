<?php
/* @var $this EquipmentQualitiesController */
/* @var $model EquipmentQualities */

$this->breadcrumbs=array(
	'Equipment Qualities'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List EquipmentQualities', 'url'=>array('index')),
	array('label'=>'Create EquipmentQualities', 'url'=>array('create')),
	array('label'=>'Update EquipmentQualities', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentQualities', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentQualities', 'url'=>array('admin')),
);
?>

<h1>View EquipmentQualities #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'percent',
	),
)); ?>
