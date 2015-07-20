<?php
/* @var $this ArmoursController */
/* @var $model Armours */

$this->breadcrumbs=array(
	'Armours'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Armours', 'url'=>array('index')),
	array('label'=>'Create Armours', 'url'=>array('create')),
	array('label'=>'View Armours', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Armours', 'url'=>array('admin')),
);
?>

<h1>Update Armours <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>