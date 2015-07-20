<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['general']?>favicon.ico">	
	<link rel="icon" href="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['general']?>favicon.ico" type="image/gif">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/screen.css" media="screen, projection" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/validationEngine.jquery.css" media="screen, projection" />
	
	<!-- JQuery -->	
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jquery-1.7.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script> 	
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jquery.validationEngine.languages/jquery.validationEngine-es.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jquery.validationEngine.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/jquery.ui/ui-lightness/jquery-ui-1.8.22.custom.css" media="screen, projection" />
	
	<!-- jqplot -->
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/excanvas.js"></script><![endif]-->
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jquery.jqplot.min.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jqplot.barRenderer.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jqplot.categoryAxisRenderer.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jqplot.pieRenderer.min.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jqplot.canvasTextRenderer.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/jquery/jqplot.canvasAxisTickRenderer.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/jquery.jqplot.css" />	
	<!-- project -->	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['statics_cdn'];?>/css/campeonatojustasmedievales.css" media="screen, projection" />
	<script language="javascript">
	var app = {		
			total_attributes: 8,
			total_skills: 8,
			getXPLevel: function(level){
				var experience = 0;			
				for(i=1;i<=level;i++){			
					experience += (attribute_cost['level_'+i]*app.total_attributes ) + (skills_cost['level_'+i]*app.total_skills); 
				}
				return experience;
			},
			<?php if( !Yii::app()->user->isGuest):?>
			user: {
				knights: {
					name: '<?php echo $this->user_data['knights']->name;?>'
				},
				knights_card: new Object,
				knights_stats: new Object,
				hasCombats: true,
				knights_evolution: new Object,
				hasNewMessages: <?php echo count( $this->user_data['new_messages'] );?>
			},
			<?php endif;?>
	};

	var level_cost = new Object;
	var attribute_cost = new Object;
	var skills_cost = new Object;
	<?php if( !Yii::app()->user->isGuest):?>
		<?php //LOAD STATS?>
		app.user.knights_stats = {
				combats_draw: <?php echo $this->user_data['knights_stats']['combats_draw'];?> ,
				combats_draw_injury: <?php echo $this->user_data['knights_stats']['combats_draw_injury'];?>,
				combats_loose: <?php echo $this->user_data['knights_stats']['combats_loose'];?>,
				combats_loose_injury: <?php echo $this->user_data['knights_stats']['combats_loose_injury'];?>,
				combats_wins: <?php echo  $this->user_data['knights_stats']['combats_wins'];?>,
				combats_wins_injury	: <?php echo $this->user_data['knights_stats']['combats_wins_injury'];?>		
		};
		<?php //Check if user has combats 
		if(	$this->user_data['knights_stats']['combats_draw'] == 0 && 
			$this->user_data['knights_stats']['combats_draw_injury']== 0 && 
			$this->user_data['knights_stats']['combats_loose'] == 0 && 
			$this->user_data['knights_stats']['combats_loose_injury'] == 0 && 
			$this->user_data['knights_stats']['combats_wins'] == 0 && 
			$this->user_data['knights_stats']['combats_wins_injury'] == 0){
				
			echo 'app.user.hasCombats = false;';
		}  
		?>		
	<?php endif;?>
	</script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/global.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/CombatManager.js"></script>
	<script src="<?php echo Yii::app()->params['statics_cdn'];?>/js/lib.js"></script>
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	<?php $this->widget('Headers');?>
	<div id="content">
		<div id="content_lef_column">
			<?php if( Yii::app()->user->isGuest ):?>
				<div class="boxSmall box_register">
					<h2 class="title_orangeCenter">¡REGÍSTRATE GRATIS!</h2>
					<form action="#" method="post" name="form_register" id="form_register">
						<p>Correo electrónico</p>
						<p><input type="text" class="validate[required,custom[email]]" name="email" id="email"></p>
						<p>Contraseña</p>
						<p><input type="password" class="validate[required,minSize[6]]" id="password"></p>
						<p>Repite la contraseña</p>
						<p><input type="password" class="validate[required,equals[password]]" id="password_repeat"></p>
						<p>Nombre caballero</p>						
						<p><input type="text" class="validate[required,maxSize[10],minSize[3],custom[knightName]]" id="name"></p>
						<p class="fontSmall"><input type="checkbox" class="validate[required]" name="accept" id="accept"> He leido y acepto las <a title="Condiciones de uso" href="/site/conditionsOfUse" class="showInDialog">condiciones de uso</a> y la <a title="política de privacidad" href="/site/privacyPolicy" class="showInDialog">política de privacidad</a>.</p>		
						<p class="registerButton"><a class="button_yellow" href="#" id="button_register">¡REGISTRARME!</a></p>
					</form>	
				</div>
			<?php else:?>
				<div id="character">
					<h3 class="knightName"><a href="/character/events/sir/<?php echo $this->user_data['knights']['name'];?>">Sir <?php echo $this->user_data['knights']['name'];?></a></h3>
					<div id="character_header">
						<p id="user_knights_status" style="margin:0 0.5em 0 0.5em;" class="textAlignRight">
						<?php echo $this->user_data['knights']->statusHtml();?>
						</p>
						<div class="ui_icon left">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$this->user_data['knights']['avatars_id'].'.png'?>" alt="Avatar" id="avatar"/>
						</div>
						<p>Nivel <span class="right"><?php echo $this->user_data['knights']['level']?></span></p>
						<p><abbr title="Puntos de experiencia">PX</abbr><span class="right"><?php echo number_format( $this->user_data['knights']['experiencie_earned'], 0, ',','.');?></span></p>
						<p><abbr title="Puntos de experiencia">PX</abbr> disponible<span class="right"><?php echo number_format( $this->user_data['knights']['experiencie_earned']-$this->user_data['knights']['experiencie_used'], 0, ',','.');?></span></p>
						<p>Monedas <span class="right" id="knight_coins"><?php echo number_format($this->user_data['knights']['coins'], 0, ',','.');?></span></p>
					</div>
					<h3>ESTADO ACTUAL</h3>
					<div id="header_knight_profile"> 
						<div title="Aguante del caballero" class="ui_icon ui_icon_endurance">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_laptop_battery.png">				
							<p class="ui_icon_value"><?php echo $this->user_data['knights']->endurance;?></p>
						</div>		
						<div title="Vida del caballero" class="ui_icon ui_icon_life">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Nuvola_apps_package_favorite.png">		
							<p class="ui_icon_value"><?php echo $this->user_data['knights']->life;?></p>
						</div>
						<div title="Dolor del caballero" class="ui_icon ui_icon_pain">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_cache.png">		
							<p class="ui_icon_value"><?php echo $this->user_data['knights']->pain?></p>		
						</div>
						<!-- 
						<div title="Monedas del caballero" class="ui_icon ui_icon_coins">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_kgoldrunner.png">
							<p class="ui_icon_value">0</p>		
						</div>
						 -->
					</div>
					<h3>ATRIBUTOS</h3>
					<script language="javascript">
						app.user.knights_card = {
					<?php foreach( $this->user_data['knights_card'] as $key => $value):?>
						<?php if( $key != 'knight_id'):?>
							<?php echo $key.':'.$value.',';?><?php //echo $this->user_data['knights_card']->{$attribute->name}.( ($key < count($this->app_data['attribute_list']) )?',':'');?>
						<?php endif;?> 
					<?php endforeach;?>
						};
					</script>
					<div id="chart_knight_attributes" style="height:200px;width:100%; "></div>
					
					<h3>ESTADÍSTICAS COMBATES</h3>
					<div id="chart_knight_stats" style="height:320px;width:100%; "></div>
					
				</div>
			<?php endif;?>		
		</div>		
		<div id="content_center_column_100"><?php echo $content; ?></div>
	</div>
	<?php $this->widget('Footers');?>
</div><!-- page -->

</body>
</html>