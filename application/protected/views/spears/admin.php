<?php
/* @var $this SpearsController */
/* @var $model Spears */

$this->breadcrumbs=array(
	'Spears'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Spears', 'url'=>array('index')),
	array('label'=>'Create Spears', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('spears-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Spears</h1>

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
	'id'=>'spears-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'spears_materials_id',
		'equipment_size_id',
		'equipment_qualities_id',
		'equipment_rarity_id',
		/*
		'damage',
		'pde',
		'prize',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
