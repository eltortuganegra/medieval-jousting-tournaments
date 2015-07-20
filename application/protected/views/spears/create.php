<?php
/* @var $this SpearsController */
/* @var $model Spears */

$this->breadcrumbs=array(
	'Spears'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Spears', 'url'=>array('index')),
	array('label'=>'Manage Spears', 'url'=>array('admin')),
);
?>

<h1>Create Spears</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>