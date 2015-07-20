<?php
/* @var $this EquipmentMaterialsController */
/* @var $model EquipmentMaterials */

$this->breadcrumbs=array(
	'Equipment Materials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EquipmentMaterials', 'url'=>array('index')),
	array('label'=>'Manage EquipmentMaterials', 'url'=>array('admin')),
);
?>

<h1>Create EquipmentMaterials</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>