<?php
/* @var $this ArmoursMaterialsController */
/* @var $model ArmoursMaterials */

$this->breadcrumbs=array(
	'Armours Materials'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ArmoursMaterials', 'url'=>array('index')),
	array('label'=>'Create ArmoursMaterials', 'url'=>array('create')),
	array('label'=>'View ArmoursMaterials', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ArmoursMaterials', 'url'=>array('admin')),
);
?>

<h1>Update ArmoursMaterials <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>