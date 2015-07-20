<?php
/* @var $this EquipmentRequirementsController */
/* @var $model EquipmentRequirements */

$this->breadcrumbs=array(
	'Equipment Requirements'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EquipmentRequirements', 'url'=>array('index')),
	array('label'=>'Create EquipmentRequirements', 'url'=>array('create')),
	array('label'=>'View EquipmentRequirements', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentRequirements', 'url'=>array('admin')),
);
?>

<h1>Update EquipmentRequirements <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>