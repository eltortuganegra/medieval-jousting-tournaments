<?php
/* @var $this KnightsController */
/* @var $model Knights */

$this->breadcrumbs=array(
	'Knights'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Knights', 'url'=>array('index')),
	array('label'=>'Create Knights', 'url'=>array('create')),
	array('label'=>'View Knights', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Knights', 'url'=>array('admin')),
);
?>

<h1>Update Knights <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>