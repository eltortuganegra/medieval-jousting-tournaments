<?php
/* @var $this SpearsMaterialsController */
/* @var $model SpearsMaterials */

$this->breadcrumbs=array(
	'Spears Materials'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SpearsMaterials', 'url'=>array('index')),
	array('label'=>'Create SpearsMaterials', 'url'=>array('create')),
	array('label'=>'Update SpearsMaterials', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SpearsMaterials', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SpearsMaterials', 'url'=>array('admin')),
);
?>

<h1>View SpearsMaterials #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'level',
		'maximum_damage',
		'prize',
		'endurance',
	),
)); ?>
