<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#post-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Posts</h1>

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

<?php /*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'content',
		'tags',
		'status',
		'create_time',
		/*'update_time',
		'author_id',
		array(
			'class'=>'CButtonColumn',
		),
	),*/

	$this->widget('booster.widgets.TbExtendedGridView', array(
    'sortableRows'=>true, //активируем возможность сортировки
    'sortableAttribute' => 'sort_order', //атрибут модели для записи порядка сортировки
    'sortableAjaxSave' => true, //сохранение с помощью AJAX
    'sortableAction' => 'post/sortable', //action для сохранения
    'afterSortableUpdate' => 'js:function(id, position){ console.log("id: "+id+", position:"+position);}', // возврат данных после переноса, видел применяли так 'js:function(id, position){ console.log("id: "+id+", position:"+position);}',
    'type'=>'striped bordered', //тип таблицы
    'dataProvider' => $model->search(),
    'template' => "{items}",
    'columns'=>array(
		'id',
		'title',
		'tags',
		'status',
		'create_time',
		'update_time',
		'author_id',
		'sort_order',
		array(
			'class'=>'CButtonColumn',
		),
	), //колонки для отображения задавайте сами
));
 ?>
