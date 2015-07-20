<?php
/* @var $this SpearsController */
/* @var $model Spears */

$this->breadcrumbs=array(
	'Spears'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Spears', 'url'=>array('index')),
	array('label'=>'Create Spears', 'url'=>array('create')),
	array('label'=>'View Spears', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Spears', 'url'=>array('admin')),
);
?>

<h1>Update Spears <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>