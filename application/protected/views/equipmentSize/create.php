<?php
/* @var $this EquipmentSizeController */
/* @var $model EquipmentSize */

$this->breadcrumbs=array(
	'Equipment Sizes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EquipmentSize', 'url'=>array('index')),
	array('label'=>'Manage EquipmentSize', 'url'=>array('admin')),
);
?>

<h1>Create EquipmentSize</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>