<?php

class DefaultController extends RController
{
	public $layout='/layouts/column1';
	public function actionIndex()
	{
		$this->render('index');
	}
}