<?php
/* @var $this SpearsMaterialsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spears Materials',
);

$this->menu=array(
	array('label'=>'Create SpearsMaterials', 'url'=>array('create')),
	array('label'=>'Manage SpearsMaterials', 'url'=>array('admin')),
);
?>

<h1>Spears Materials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
