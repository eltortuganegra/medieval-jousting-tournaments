<?php
/* @var $this EquipmentQualitiesController */
/* @var $model EquipmentQualities */

$this->breadcrumbs=array(
	'Equipment Qualities'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EquipmentQualities', 'url'=>array('index')),
	array('label'=>'Create EquipmentQualities', 'url'=>array('create')),
	array('label'=>'View EquipmentQualities', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentQualities', 'url'=>array('admin')),
);
?>

<h1>Update EquipmentQualities <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>