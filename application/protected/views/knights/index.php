<?php
/* @var $this KnightsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Knights',
);

$this->menu=array(
	array('label'=>'Create Knights', 'url'=>array('create')),
	array('label'=>'Manage Knights', 'url'=>array('admin')),
);
?>

<h1>Knights</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
