<?php
/* @var $this ArmoursController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Armours',
);

$this->menu=array(
	array('label'=>'Create Armours', 'url'=>array('create')),
	array('label'=>'Manage Armours', 'url'=>array('admin')),
);
?>

<h1>Armours</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
