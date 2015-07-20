<?php
/* @var $this CombatsController */
/* @var $model Combats */

$this->breadcrumbs=array(
	'Combats'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Combats', 'url'=>array('index')),
	array('label'=>'Create Combats', 'url'=>array('create')),
	array('label'=>'View Combats', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Combats', 'url'=>array('admin')),
);
?>

<h1>Update Combats <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>