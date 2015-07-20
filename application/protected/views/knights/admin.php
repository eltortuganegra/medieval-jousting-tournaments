<?php
/* @var $this KnightsController */
/* @var $model Knights */

$this->breadcrumbs=array(
	'Knights'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Knights', 'url'=>array('index')),
	array('label'=>'Create Knights', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('knights-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Knights</h1>

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
	'id'=>'knights-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'users_id',
		'suscribe_date',
		'unsuscribe_date',
		'name',
		'status',
		/*
		'level',
		'endurance',
		'life',
		'pain',
		'coins',
		'experiencie_earned',
		'experiencie_used',
		'avatars_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
