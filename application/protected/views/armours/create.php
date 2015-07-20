<?php
/* @var $this ArmoursController */
/* @var $model Armours */

$this->breadcrumbs=array(
	'Armours'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Armours', 'url'=>array('index')),
	array('label'=>'Manage Armours', 'url'=>array('admin')),
);
?>

<h1>Create Armours</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>