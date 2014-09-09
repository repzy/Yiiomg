<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-17 lasst">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-7 last " style="background-color: #EFEFEF">
	<div id="sidebar">

		<div id="about">
			<p class="portlet-title "><?php echo CHtml::encode(Yii::app()->name)?></p>
			<p class="portlet-sub-title">Your Bi-Line to go her</p>
			<p class="portlet-content" style="color:#afafaf">
				Pellentesque habitant morbi tristique senectus et netus et male. 
				Pellentesque habitant morbi tristique senectus et netus et male.
			</p>
		</div><!-- about -->

		<div id="updates">
			<p class="portlet-title">Recieve Updates</p>
			<p class="portlet-content" style="color:#afafaf">

				<?php echo TbHtml::textField('appendedInputButton', 'enter email',
    				array('append' => TbHtml::button('Join!'), 'span' => 2)); ?>
    		</p>
    		<p class="portlet-content" style="">
    			Ut eget metus nibh, nec scelerisque sem. Nulla dui purus, pelle.
    		</p>
		</div><!-- updates -->

		<div id="recent_comments">
			<?php $this->widget('RecentComments', array(
				'maxComments'=>Yii::app()->params['recentCommentCount'],
			)); ?>
		</div><!-- recent_comments -->

		<div id="recent_posts">
			<?php $this->widget('RecentPosts', array(
				'maxPosts'=>Yii::app()->params['recentPostCount'],
			)); ?>
		</div><!-- recent_posts -->

		<div id="tags">
			<?php $this->widget('TagCloud', array(
				'maxTags'=>10,
			)); ?>
		</div><!-- tags -->

		<div id="menu">

			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Operations',
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'operations'),
				));
				$this->endWidget();
			?>
		</div><!-- menu -->	

	</div><!-- sidebar -->
<div id="div-bottom1" class=""></div>
<div id="div-bottom2" class=""></div>
</div>

<?php $this->endContent(); ?>