<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
?>
<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>

<?php echo $this->renderPartial('/profileField/_menu',array(
		'list'=> array(),
	)); ?>

<?php echo $this->renderPartial('/profileField/_form', array('model'=>$model)); ?>