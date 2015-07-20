<?php
/* @var $this ArmoursMaterialsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Armours Materials',
);

$this->menu=array(
	array('label'=>'Create ArmoursMaterials', 'url'=>array('create')),
	array('label'=>'Manage ArmoursMaterials', 'url'=>array('admin')),
);
?>

<h1>Armours Materials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
