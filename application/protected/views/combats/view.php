<?php
/* @var $this CombatsController */
/* @var $model Combats */

$this->breadcrumbs=array(
	'Combats'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Combats', 'url'=>array('index')),
	array('label'=>'Create Combats', 'url'=>array('create')),
	array('label'=>'Update Combats', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Combats', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Combats', 'url'=>array('admin')),
);
?>

<h1>View Combats #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from_knight',
		'to_knight',
		'date',
		'type',
		'status',
		'result',
		'result_by',
		'from_knight_injury_type',
		'to_knight_injury_type',
	),
)); ?>
