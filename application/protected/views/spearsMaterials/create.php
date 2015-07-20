<?php
/* @var $this SpearsMaterialsController */
/* @var $model SpearsMaterials */

$this->breadcrumbs=array(
	'Spears Materials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SpearsMaterials', 'url'=>array('index')),
	array('label'=>'Manage SpearsMaterials', 'url'=>array('admin')),
);
?>

<h1>Create SpearsMaterials</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>