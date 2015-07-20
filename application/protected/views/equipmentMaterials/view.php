<?php
/* @var $this EquipmentMaterialsController */
/* @var $model EquipmentMaterials */

$this->breadcrumbs=array(
	'Equipment Materials'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List EquipmentMaterials', 'url'=>array('index')),
	array('label'=>'Create EquipmentMaterials', 'url'=>array('create')),
	array('label'=>'Update EquipmentMaterials', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentMaterials', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentMaterials', 'url'=>array('admin')),
);
?>

<h1>View EquipmentMaterials #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'endurance',
		'prize',
	),
)); ?>
