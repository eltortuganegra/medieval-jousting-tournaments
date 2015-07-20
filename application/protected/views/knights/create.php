<?php
/* @var $this KnightsController */
/* @var $model Knights */

$this->breadcrumbs=array(
	'Knights'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Knights', 'url'=>array('index')),
	array('label'=>'Manage Knights', 'url'=>array('admin')),
);
?>

<h1>Create Knights</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>