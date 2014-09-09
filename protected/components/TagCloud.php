<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
	public $title='Popular tags';
	public $maxTags=20;

	protected function renderContent()
	{
		$tags=Tag::model()->findTagWeights($this->maxTags);

		foreach($tags as $tag=>$weight)
		{
			$link=CHtml::link(CHtml::encode($tag), array('post/index','tag'=>$tag));
			echo CHtml::tag('button', array(
				'class'=>'btn',
				'style'=>"font-size:{$weight}pt; margin-bottom: 4px; font-weight: bold; ",
			), $link)."\n";
			
		}
	}
}?>