<?php
/* @var $this CombatsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Combats',
);

$this->menu=array(
	array('label'=>'Create Combats', 'url'=>array('create')),
	array('label'=>'Manage Combats', 'url'=>array('admin')),
);
?>

<h1>Combats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
