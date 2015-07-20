<?php
/* @var $this CombatsController */
/* @var $model Combats */

$this->breadcrumbs=array(
	'Combats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Combats', 'url'=>array('index')),
	array('label'=>'Manage Combats', 'url'=>array('admin')),
);
?>

<h1>Create Combats</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>