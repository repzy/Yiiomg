<?php /* @var $this Controller */ ?>
<?php $this->beginContent('/layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Admin',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->UserMenu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Post',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->PostMenu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();

		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Comments',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->CommentMenu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();

		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Users',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();

		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'PrFields',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->ProfileFieldMenu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>