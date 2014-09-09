<?php

class PostController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    private $_model;
	/**
	 * @return array action filters
	 */
	public function actions()
	{
	    return array(
	        'sortable' => array(
	            'class' => 'booster.actions.TbSortableAction',
	            'modelName' => 'Post'
	        ),
	    );
	}

	public function filters()
	{
	    return array(
	      'rights', 
	    );
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
	    $post=$this->loadModel();
	    $comment=$this->newComment($post);
		
	    if(!Yii::app()->request->cookies['count']) { 
	    $cookie = new CHttpCookie('count', true);    
	    $cookie->expire = time()+3600;                        
	    Yii::app()->request->cookies['count'] = $cookie;    
	    $post = Post::model()->findByPk($id);
	    $post->saveCounters(array('visits'=>1));
	    $this->render('view', array(
	    	'model'=>$post,
		    'comment'=>$comment,));             
	  	}else{
	  		$this->render('view',array(
	        'model'=>$post,
	        'comment'=>$comment,
	    ));
	  	}
	}
	 
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			$model->icon=CUploadedFile::getInstance($model,'icon');
			if ($model->icon){	
				$sourcePath = pathinfo($model->icon->getName());	
				$fileName = $sourcePath['filename'].".".$sourcePath['extension'];
				$model->image = $fileName;
			}
			if($model->save()){
				if ($model->icon){				
					$file = $_SERVER['DOCUMENT_ROOT'].'/images/'.$fileName;
					$model->icon->saveAs($file);
				}
				$this->redirect(array('view','id'=>$model->id));}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			$model->icon=CUploadedFile::getInstance($model,'icon');
			if ($model->icon){		
				$sourcePath = pathinfo($model->icon->getName());	
				$fileName = $sourcePath['filename'].".".$sourcePath['extension'];
				$model->image = $fileName;
			}
			if($model->save())
				if ($model->icon){				
					$file = $_SERVER['DOCUMENT_ROOT'].
					'/images/'.$fileName;
					$model->icon->saveAs($file);
				}
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		$this->loadModel($id)->delete();
		unlink($_SERVER['DOCUMENT_ROOT'].'/images/'.$model->image);		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			$this->redirect(array('returnUrl'));

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	    $criteria=new CDbCriteria(array(
	        'condition'=>'status='.Post::STATUS_PUBLISHED,
	        'order'=>'sort_order ASC',
	        'with'=>'commentCount',
	    ));
	    if(isset($_GET['tag']))
	        $criteria->addSearchCondition('tags',$_GET['tag']);
	 
	    $dataProvider=new CActiveDataProvider('Post', array(
	        'pagination'=>array(
	            'pageSize'=>5,
	        ),
	        'criteria'=>$criteria,
	    ));
	 
	    $this->render('index',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel()
	{
	    if($this->_model===null)
	    {
	        if(isset($_GET['id']))
	        {
	            if(Yii::app()->user->isGuest)
	                $condition='status='.Post::STATUS_PUBLISHED
	                    .' OR status='.Post::STATUS_ARCHIVED;
	            else
	                $condition='';
	            $this->_model=Post::model()->findByPk($_GET['id'], $condition);
	        }
	        if($this->_model===null)
	            throw new CHttpException(404,'Запитувана сторінка не існує.');
	    }
	    return $this->_model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function newComment($post)
	{
	    $comment=new Comment;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
	    {
	        echo CActiveForm::validate($comment);
	        Yii::app()->end();
	    }
	    
	    if(isset($_POST['Comment']))
	    {
	        $comment->attributes=$_POST['Comment'];
	        if($post->addComment($comment))
	        {
	            if($comment->status==Comment::STATUS_PENDING)
	                Yii::app()->user->setFlash('commentSubmitted','Дякуємо за ваш коментар. 
	                    Ваш коментар зʼявиться одразу після ухвалення.');
	            $this->refresh();
	        }
	    }
	    return $comment;
	}

	public function show_image($id, $image, $width='150', $class='material_img')
	{
		if(isset($image) && file_exists($_SERVER['DOCUMENT_ROOT'].'/images/'.$image))

			return CHtml::image(Yii::app()->getBaseUrl(true).'/images/'.$image);
		else
			return CHtml::image(Yii::app()->getBaseUrl(true).'/images/noimage.jpg');
	}
}
