<?php

class LoginController extends RController
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	/*
	public function actionLogin()
	{
	  $serviceName = Yii::app()->request->getQuery('service');
	  if (isset($serviceName))
	  {
	      $eauth = Yii::app()->eauth->getIdentity($serviceName);
	      $eauth->redirectUrl = Yii::app()->user->returnUrl;
	      $eauth->cancelUrl = $this->createAbsoluteUrl('user/login');

	      try
	      {
	          if ($eauth->authenticate())
	          {
	              $identity = new ServiceUserIdentity($eauth);

	              // успешная аутентификация
	              if ($identity->authenticate())
	              {
	                  Yii::app()->user->login($identity);
	                  $eauth->redirect();
	              }
	              else
	              {
	                  // закрытие popup-окна
	                  $eauth->cancel();
	              }
	          }
	          $this->redirect(array('user/login'));
	      }
	      catch (EAuthException $e)
	      {
	          Yii::app()->user->setFlash('error',
	              'EAuthException: '.$e->getMessage());
	          $eauth->redirect($eauth->getCancelUrl());
	      }
	  }
	  elseif (Yii::app()->user->isGuest)
	  {
	    $model=new UserLogin;
	    // collect user input data
	    if(isset($_POST['UserLogin']))
	    {
	      $model->attributes=$_POST['UserLogin'];
	      // validate user input and redirect to previous page if valid
	      if($model->validate())
	      {
	        $this->lastViset();
	        if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
	          $this->redirect(Yii::app()->controller->module->returnUrl);
	        else
	          $this->redirect(Yii::app()->user->returnUrl);
	      }
	    }
	    // display the login form
	    $this->render('/user/login',array('model'=>$model));
	  } else
	      $this->redirect(Yii::app()->controller->module->returnUrl);
	}*/
	public function actionLogin()
	{
	  $serviceName = Yii::app()->request->getQuery('service');
	  if (isset($serviceName))
	  {
	      $eauth = Yii::app()->eauth->getIdentity($serviceName);
	      $eauth->redirectUrl = Yii::app()->user->returnUrl;
	      $eauth->cancelUrl = $this->createAbsoluteUrl('user/login');

	      try
	      {
	          if ($eauth->authenticate())
	          {
	              $identity = new ServiceUserIdentity($eauth);

	              // успешная аутентификация
	              if ($identity->authenticate())
	              {
	                  if(Yii::app()->user->isGuest){
	                    Yii::app()->user->login($identity);
	                    $eauth->redirect();
	                  }
	                  else
	                  {
	                    $eauth->redirectUrl = $this->createAbsoluteUrl('/user/profile');
	                    $eauth->cancelUrl = $this->createAbsoluteUrl('/user/profile');
	                
	                    $service = new Service();
	                    $service->identity = $eauth->id;
	                    $service->service_name = $eauth->serviceName;
	                    $service->user_id = Yii::app()->user->id;

	                    if ($service->save()) {
	                        $eauth->redirect();
	                    }
	                  }
	              }
	              else
	              {
	                  // закрытие popup-окна
	                  $eauth->cancel();
	              }
	          }
	          $this->redirect(array('user/login'));
	      }
	      catch (EAuthException $e)
	      {
	          Yii::app()->user->setFlash('error',
	              'EAuthException: '.$e->getMessage());
	          $eauth->redirect($eauth->getCancelUrl());
	      }
	  }
	  elseif (Yii::app()->user->isGuest)
	  {
	    $model=new UserLogin;
	    // collect user input data
	    if(isset($_POST['UserLogin']))
	    {
	      $model->attributes=$_POST['UserLogin'];
	      // validate user input and redirect to previous page if valid
	      if($model->validate())
	      {
	        $this->lastViset();
	        if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
	          $this->redirect(Yii::app()->controller->module->returnUrl);
	        else
	          $this->redirect(Yii::app()->user->returnUrl);
	      }
	    }
	    // display the login form
	    $this->render('/user/login',array('model'=>$model));
	  } else
	      $this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}