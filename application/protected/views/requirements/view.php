<?php
/* @var $this RequirementsController */
/* @var $model Requirements */

$this->breadcrumbs=array(
	'Requirements'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Requirements', 'url'=>array('index')),
	array('label'=>'Create Requirements', 'url'=>array('create')),
	array('label'=>'Update Requirements', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Requirements', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Requirements', 'url'=>array('admin')),
);
?>

<h1>View Requirements #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'level',
		'attribute',
		'skill',
		'value',
	),
)); ?>
