<div id="knight_status">
<input type="hidden" id="knight_name" value="<?php echo $knight->name;?>" />
<input type="hidden" id="isMyProfile" value="<?php echo (!Yii::app()->user->isGuest && $knight->name==Yii::app()->user->knights_name)?'1':'0';?>" />

<h2>Sir <?php echo $knight->name;?></h2>
		<div class="ui_icon">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$knight->avatars_id?>.png" alt="avatar">
		</div>
		<div class="ui_icon" title="Nivel del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_kdict.png" alt=nivel />
			<p class="ui_icon_title">NIVEL</p>
			<p class="ui_icon_value"><?php echo $knight->level;?></p>
			
		</div>		
		<div class="ui_icon ui_icon_endurance" title="Aguante del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_laptop_battery.png" alt="Aguante">
		
			<p class="ui_icon_value"><?php echo $knight->endurance;?></p>		
		</div>
		<div class="ui_icon ui_icon_life" title="Vida del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Nuvola_apps_package_favorite.png" alt="Aguante">		
			<p class="ui_icon_value"><?php echo $knight->life;?></p>		
		</div>
		<div class="ui_icon ui_icon_pain" title="Dolor del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_cache.png" alt="Aguante">		
			<p class="ui_icon_value"><?php echo $knight->pain;?></p>		
		</div>
		<div class="ui_icon ui_icon_coins" title="Monedas del caballero">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_kgoldrunner.png" alt="Aguante">
			<p class="ui_icon_value"><?php echo $knight->coins;?></p>		
		</div>		
		<div id="experience_bar">
			<p><span class="">EXPERIENCIA ACUMULADA:<?php echo number_format( $knight->experiencie_earned, 0, ',','.' );?> <span class="flotarDerecha">Nivel <?php echo $knight->level+1;?></span></p>
			<div id="experience_bar_total">
				<div id="experience_bar_percent"></div>
			</div>
			<p>EXPERIENCIA DISPONIBLE: <span id="px_disponibles"><?php echo number_format($knight->experiencie_earned-$knight->experiencie_used ,0,',','.');?></span> PX</p>
			<p></p>
		</div>
	</div>