<?php
/* @var $this SpearsMaterialsController */
/* @var $model SpearsMaterials */

$this->breadcrumbs=array(
	'Spears Materials'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SpearsMaterials', 'url'=>array('index')),
	array('label'=>'Create SpearsMaterials', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('spears-materials-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Spears Materials</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'spears-materials-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'level',
		'maximum_damage',
		'prize',
		'endurance',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
