<?php
/* @var $this SpearsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spears',
);

$this->menu=array(
	array('label'=>'Create Spears', 'url'=>array('create')),
	array('label'=>'Manage Spears', 'url'=>array('admin')),
);
?>

<h1>Spears</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
