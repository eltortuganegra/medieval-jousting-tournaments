<?php
/* @var $this EquipmentRequirementsController */
/* @var $model EquipmentRequirements */

$this->breadcrumbs=array(
	'Equipment Requirements'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EquipmentRequirements', 'url'=>array('index')),
	array('label'=>'Manage EquipmentRequirements', 'url'=>array('admin')),
);
?>

<h1>Create EquipmentRequirements</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>