<?php
/* @var $this RequirementsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Requirements',
);

$this->menu=array(
	array('label'=>'Create Requirements', 'url'=>array('create')),
	array('label'=>'Manage Requirements', 'url'=>array('admin')),
);
?>

<h1>Requirements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
