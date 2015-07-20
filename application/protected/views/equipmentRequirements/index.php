<?php
/* @var $this EquipmentRequirementsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Requirements',
);

$this->menu=array(
	array('label'=>'Create EquipmentRequirements', 'url'=>array('create')),
	array('label'=>'Manage EquipmentRequirements', 'url'=>array('admin')),
);
?>

<h1>Equipment Requirements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
