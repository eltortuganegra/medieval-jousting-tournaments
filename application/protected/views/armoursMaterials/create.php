<?php
/* @var $this ArmoursMaterialsController */
/* @var $model ArmoursMaterials */

$this->breadcrumbs=array(
	'Armours Materials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ArmoursMaterials', 'url'=>array('index')),
	array('label'=>'Manage ArmoursMaterials', 'url'=>array('admin')),
);
?>

<h1>Create ArmoursMaterials</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>