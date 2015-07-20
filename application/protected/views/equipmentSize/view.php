<?php
/* @var $this EquipmentSizeController */
/* @var $model EquipmentSize */

$this->breadcrumbs=array(
	'Equipment Sizes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List EquipmentSize', 'url'=>array('index')),
	array('label'=>'Create EquipmentSize', 'url'=>array('create')),
	array('label'=>'Update EquipmentSize', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentSize', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentSize', 'url'=>array('admin')),
);
?>

<h1>View EquipmentSize #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'size',
		'percent',
	),
)); ?>
