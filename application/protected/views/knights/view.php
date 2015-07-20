<?php
/* @var $this KnightsController */
/* @var $model Knights */

$this->breadcrumbs=array(
	'Knights'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Knights', 'url'=>array('index')),
	array('label'=>'Create Knights', 'url'=>array('create')),
	array('label'=>'Update Knights', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Knights', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Knights', 'url'=>array('admin')),
);
?>

<h1>View Knights #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'users_id',
		'suscribe_date',
		'unsuscribe_date',
		'name',
		'status',
		'level',
		'endurance',
		'life',
		'pain',
		'coins',
		'experiencie_earned',
		'experiencie_used',
		'avatars_id',
	),
)); ?>
