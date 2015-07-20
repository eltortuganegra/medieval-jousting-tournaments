<?php
/* @var $this EquipmentSizeController */
/* @var $model EquipmentSize */

$this->breadcrumbs=array(
	'Equipment Sizes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EquipmentSize', 'url'=>array('index')),
	array('label'=>'Create EquipmentSize', 'url'=>array('create')),
	array('label'=>'View EquipmentSize', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentSize', 'url'=>array('admin')),
);
?>

<h1>Update EquipmentSize <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>