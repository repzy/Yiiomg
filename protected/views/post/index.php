<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

/*$this->breadcrumbs=array(
	'Posts',
);*/
?>

<?php
$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php if(!empty($_GET['tag'])): ?>
<h1>Записи із тегом <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
 
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'template'=>"{items}\n{pager}",
    'sortableAttributes' => 'sort_order ASC',
    
)); 

/*$this->widget('booster.widgets.TbExtendedGridView', array(
    'sortableRows'=>true, //активируем возможность сортировки
    'sortableAttribute' => 'sort_order', //атрибут модели для записи порядка сортировки
    'sortableAjaxSave' => true, //сохранение с помощью AJAX
    'sortableAction' => 'Post/sortable', //action для сохранения
    'afterSortableUpdate' => 'js:function(){}', // возврат данных после переноса, видел применяли так 'js:function(id, position){ console.log("id: "+id+", position:"+position);}',
    'type'=>'striped bordered', //тип таблицы
    'dataProvider' => $dataProvider,
    'template' => "{items}\n{pager}",
    'columns'=>array(
		'id',
		'title',
		'content',
		'tags',
		'status',
		'create_time',
		'update_time',
		'author_id',
		
	), //колонки для отображения задавайте сами
));
*/
?>
