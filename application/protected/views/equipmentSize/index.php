<?php
/* @var $this EquipmentSizeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Sizes',
);

$this->menu=array(
	array('label'=>'Create EquipmentSize', 'url'=>array('create')),
	array('label'=>'Manage EquipmentSize', 'url'=>array('admin')),
);
?>

<h1>Equipment Sizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
