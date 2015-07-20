<?php
/* @var $this EquipmentQualitiesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Qualities',
);

$this->menu=array(
	array('label'=>'Create EquipmentQualities', 'url'=>array('create')),
	array('label'=>'Manage EquipmentQualities', 'url'=>array('admin')),
);
?>

<h1>Equipment Qualities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
