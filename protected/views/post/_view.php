<?php
/* @var $this PostController */
/* @var $data Post */
?>

<div class="image">
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>false));
			//echo $data->image;
			//echo $data->id;
			echo $this->show_image($data->id, $data->image, '500','image_content');
			$this->endWidget();
		?>
	</div>
</div>

<div class="post ">
	<div class="title">
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</div>
	<div class="date">
		<?php echo  date('jS F Y',$data->create_time); ?>
	</div>

	<div class="link">Sub heading to go here</div>

	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	
	

</div>
<div id="div-bottom1" class=""></div>
<div id="div-bottom2" class=""></div>