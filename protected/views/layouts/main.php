<?php /* @var $this Controller */ ?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="uk" />
    
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>" />
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>" />


	<!-- blueprint CSS framework -->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/my-screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/my-main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?> | <?php echo Yii::app()->name; ?></title>

	
</head>

<body>

	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div id="header">	
	<div id="left-menu">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->name), array('/site/index')); ?>
	</div>
		<div id="right-menu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Post', 'url'=>array('/post')),
					array('label'=>'Comments', 'url'=>array('/comment')),
					//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
				    array('url'=>Yii::app()->getModule('user')->profileUrl, 
				      'label'=>Yii::app()->getModule('user')->t("Profile"), 
				      'visible'=>!Yii::app()->user->isGuest && !Yii::app()->user->getState('service') && !Yii::app()->user->checkAccess('superuser')),
				    array('url'=>Yii::app()->getModule('user')->registrationUrl, 
				      'label'=>Yii::app()->getModule('user')->t("Register"), 
				      'visible'=>Yii::app()->user->isGuest || Yii::app()->user->getState('service')),
				    array('label'=>'Admin', 
				      'url'=>array('/admin'),
				      'visible'=>Yii::app()->user->checkAccess('superuser')),
					),

				)); ?>
		</div><!-- mainmenu -->	
</div><!-- header -->

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->

	<div id="footer">
		<div class="footer" id="footer_content" >
			Quisque turpis lorem, vehicula eget rhoncus vel. Quisque turpis lorem, vehicula eget rhoncus vel. 
			Quisque turpis lorem, vehicula eget rhoncus vel. Quisque turpis lorem, vehicula eget rhoncus vel. 
			Quisque turpis lorem, vehicula eget rhoncus vel. Quisque turpis lorem, vehicula eget rhoncus vel. 
			Quisque turpis lorem, vehicula eget rhoncus vel. Quisque turpis lorem, vehicula eget rhoncus vel. 
			Quisque turpis lorem, vehicula eget rhoncus vel. 
		</div>
		<div class="footer" id="footer_newsLetter">
			
				<?php echo TbHtml::textField('appendedInputButton', 'enter email',
    				array('append' => TbHtml::button('Join!'), 'span' => 4)); ?>
    		
		</div>
		<div>

		</div class="footer" id="footer_social">
		<div class="footer" id="footer_copyright">
			Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
			All Rights Reserved.<br/>
			<?php echo Yii::powered(); ?>
		</div>
		
	</div><!-- footer -->

</body>
</html>
