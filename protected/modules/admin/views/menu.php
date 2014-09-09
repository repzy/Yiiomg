<?php 

$this->UserMenu=array(
	array('label'=>'List User', 'url'=>array('/admin/index')),
	array('label'=>'Create User', 'url'=>array('/admin/create')),
	);

$this->PostMenu=array(
	array('label'=>'List Post', 'url'=>array('/admin/post/admin')),
	array('label'=>'Update Post', 'url'=>array('/admin/post/update')),
	);

$this->ProfileFieldMenu=array(
	array('label'=>'List Profile', 'url'=>array('index')),
	array('label'=>'Create Profile', 'url'=>array('create')),
	);

$this->CommentMenu=array(
	array('label'=>'List Comment', 'url'=>array('index')),
	array('label'=>'Create Comment', 'url'=>array('create')),
	);
?>