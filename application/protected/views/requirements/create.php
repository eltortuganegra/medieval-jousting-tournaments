<?php
/* @var $this RequirementsController */
/* @var $model Requirements */

$this->breadcrumbs=array(
	'Requirements'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Requirements', 'url'=>array('index')),
	array('label'=>'Manage Requirements', 'url'=>array('admin')),
);
?>

<h1>Create Requirements</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>