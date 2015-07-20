<?php
/* @var $this EquipmentQualitiesController */
/* @var $model EquipmentQualities */

$this->breadcrumbs=array(
	'Equipment Qualities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EquipmentQualities', 'url'=>array('index')),
	array('label'=>'Manage EquipmentQualities', 'url'=>array('admin')),
);
?>

<h1>Create EquipmentQualities</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>