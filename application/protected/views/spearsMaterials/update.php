<?php
/* @var $this SpearsMaterialsController */
/* @var $model SpearsMaterials */

$this->breadcrumbs=array(
	'Spears Materials'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SpearsMaterials', 'url'=>array('index')),
	array('label'=>'Create SpearsMaterials', 'url'=>array('create')),
	array('label'=>'View SpearsMaterials', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SpearsMaterials', 'url'=>array('admin')),
);
?>

<h1>Update SpearsMaterials <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>