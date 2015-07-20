<?php
/* @var $this EquipmentMaterialsController */
/* @var $model EquipmentMaterials */

$this->breadcrumbs=array(
	'Equipment Materials'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EquipmentMaterials', 'url'=>array('index')),
	array('label'=>'Create EquipmentMaterials', 'url'=>array('create')),
	array('label'=>'View EquipmentMaterials', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EquipmentMaterials', 'url'=>array('admin')),
);
?>

<h1>Update EquipmentMaterials <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>