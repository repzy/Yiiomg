<ul id="recent_post">

<?php foreach($this->getRecentPosts() as $post): ?>

<li id="recent_post_title">
	<div class="marked"><?php echo "►"; ?></div>
	<div class="recent_post_title"><?php echo CHtml::link(CHtml::encode($post->title),array('id'=>$post->id)); ?></div>
</li>
<li id="recent_post_date"><?php echo date("jS  F Y",$post->create_time); ?></li>



<?php endforeach; ?>

</ul>