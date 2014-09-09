<?php
/* @var $this PostController */
/* @var $model Post */

$this->description = $model->description;
$this->keywords = $model->keywords;


$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>

<div class="fb-like" 
    data-href= <?php echo "localhost/" . Yii::app()->getRequest()->getUrl()?>
    data-layout="button_count" 
    data-action="like" 
    data-show-faces="true" 
    data-share="true">
</div>

<div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'content:html',
		'tags',
		'status',
		'create_time',
		'update_time',
		'author_id',
	),

)); ?>


<?php $this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        'Comments'=>array('content'=>$this->renderPartial('my_comm', array(
			'comment'=>$comment,
			'model'=>$model
			), true), 'id'=>'tab1'),
        'Facebook'=>array('content'=>$this->renderPartial('fb_comm', null, true), 'id'=>'tab2'),
        
        // panel 3 contains the content rendered by a partial view
        //'AjaxTab'=>array('ajax'=>$ajaxUrl),
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),


 
));?>
</div>

