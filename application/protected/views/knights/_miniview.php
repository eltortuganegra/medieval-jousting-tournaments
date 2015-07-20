<?php
/* @var $this KnightsController */
/* @var $model Knights */
?>
<div class="knights_miniview">
	<div class="ui_icon left">
		<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$model->avatars_id.'.png'?>" alt="Avatar" id="avatar"/>
	</div>
	<h4><img src="<?php echo  Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['general']?>knight_login_status_<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights'].$model->id)?'online':'offline';?>.png" class="knight_login_status " title="<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights'].$model->id)?'¡CONECTADO!':'desconectado';?>"><a href="/character/events/sir/<?php echo $model->name;?>"><?php echo $model->name;?></a></h4>
	<p class="fontXXsmall">Nivel: <span class="right"><?php echo $model->level;?></span></p>
	<p class="fontXXsmall"><abbr title="Puntos de experiencia">PX</abbr> ganados: <span class="right"><?php echo number_format( $model->experiencie_earned,0,',','.' );?></span></p>
	<p class="fontXXsmall"><abbr title="Puntos de experiencia">PX</abbr> disponible<span id="knight_experience_enabled" class="right"><?php echo number_format( $model->experiencie_earned-$model->experiencie_used, 0, ',','.');?></span></p>
	<p class="fontXXsmall">Monedas <span class="right"><?php echo $model->coins?></span></p>
	<div class="knights_status"> 
		<div class="ui_icon ui_icon_endurance" title="Aguante del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_laptop_battery.png">				
			<p class="ui_icon_value"><?php echo $model->endurance?></p>
		</div>		
		<div class="ui_icon ui_icon_life" title="Vida del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Nuvola_apps_package_favorite.png">		
			<p class="ui_icon_value"><?php echo $model->life?></p>		
		</div>
		<div class="ui_icon ui_icon_pain" title="Dolor del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_cache.png">		
			<p class="ui_icon_value"><?php echo $model->pain?></p>		
		</div>					
	</div>
</div>