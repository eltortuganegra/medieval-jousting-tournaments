<?php
/* @var $this EquipmentMaterialsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Materials',
);

$this->menu=array(
	array('label'=>'Create EquipmentMaterials', 'url'=>array('create')),
	array('label'=>'Manage EquipmentMaterials', 'url'=>array('admin')),
);
?>

<h1>Equipment Materials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
