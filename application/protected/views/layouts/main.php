<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/validationEngine.jquery.css" media="screen, projection" />
	<!-- <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" type="text/css" /> -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.ui/ui-lightness/jquery-ui-1.8.22.custom.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/campeonatojustasmedievales.css" media="screen, projection" />

	<!-- JS -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>  -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-1.7.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script> 	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.validationEngine.languages/jquery.validationEngine-es.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.validationEngine.js"></script>		
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/lib.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/CombatManager.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/global.js"></script>	
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	<?php $this->widget('Headers');?>
	<?php  // Only visible for admin user
	if( !Yii::app()->user->isGuest && Yii::app()->user->email == Yii::app()->params['adminEmail']):?>
		<div id="mainmenu">
		<?php 	 
			$this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					//array('label'=>'Stats', 'url'=>array('/site/index')),
					array('label'=>'Armours', 'url'=>array('/armours')),
					array('label'=>'Spears', 'url'=>array('/spears')),
					array('label'=>'Requirements', 'url'=>array('/requirements')),
					//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					//array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			)); ?>
		</div>
	<?php endif;?>
		
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php echo $content; ?>
	<?php $this->widget('Footers');?>
</div><!-- page -->

</body>
</html>
