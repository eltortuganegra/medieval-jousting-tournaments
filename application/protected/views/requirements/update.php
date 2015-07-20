<?php
/* @var $this RequirementsController */
/* @var $model Requirements */

$this->breadcrumbs=array(
	'Requirements'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Requirements', 'url'=>array('index')),
	array('label'=>'Create Requirements', 'url'=>array('create')),
	array('label'=>'View Requirements', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Requirements', 'url'=>array('admin')),
);
?>

<h1>Update Requirements <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>