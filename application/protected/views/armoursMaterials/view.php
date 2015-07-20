<?php
/* @var $this ArmoursMaterialsController */
/* @var $model ArmoursMaterials */

$this->breadcrumbs=array(
	'Armours Materials'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ArmoursMaterials', 'url'=>array('index')),
	array('label'=>'Create ArmoursMaterials', 'url'=>array('create')),
	array('label'=>'Update ArmoursMaterials', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ArmoursMaterials', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ArmoursMaterials', 'url'=>array('admin')),
);
?>

<h1>View ArmoursMaterials #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'endurance',
		'prize',
	),
)); ?>
