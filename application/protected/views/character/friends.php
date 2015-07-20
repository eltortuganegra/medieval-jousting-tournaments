<?php //echo $knights_status_template;?>
<div id="friends">
	<h1>Sir <?php echo $this->knight->name;?>: amigos</h1>
	<?php 
	//Check total friends
	if( count( $friends) == 0 ):?>
		<p>Si y a lo dice el refrán: -"Más vale estar solos que mal acompañados."</p>
		<p>De todas maneras el juego se anima si machacas a tus amigos, así qué si todavía no estan jugando enviales una invitación y ¡MACHÁCALES!</p>
	<?php else:?>
		<?php foreach($friends as $friend):?>
			<?php
				$knight = new Knights();
				$knight->attributes = $friend;
				$this->renderPartial('/knights/_miniview', array('model'=>$knight) ); 
			?>		
			<!-- 
			<div class="friend">
				<div class="ui_icon left">
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$friend['avatars_id'].'.png'?>" alt="Avatar" id="avatar"/>
				</div>
				<h4><img src="<?php echo  Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['general']?>knight_login_status_<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights'].$friend['id'])?'online':'offline';?>.png" class="knight_login_status " title="<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights'].$friend['id'])?'¡CONECTADO!':'desconectado';?>"><a href="/character/events/sir/<?php echo $friend['name'];?>">Sir <?php echo $friend['name'];?></a></h4>
				<p class="fontXXsmall">Nivel: <span class="right"><?php echo $friend['level'];?></span></p>
				<p class="fontXXsmall">XP: <span class="right"><?php echo number_format( $friend['experiencie_earned'],0,',','.' );?></span></p>
				<div class="knights_status"> 
					<div class="ui_icon ui_icon_endurance" title="Aguante del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_laptop_battery.png">				
						<p class="ui_icon_value"><?php echo $friend['endurance']?></p>
					</div>		
					<div class="ui_icon ui_icon_life" title="Vida del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Nuvola_apps_package_favorite.png">		
						<p class="ui_icon_value"><?php echo $friend['life']?></p>		
					</div>
					<div class="ui_icon ui_icon_pain" title="Dolor del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_cache.png">		
						<p class="ui_icon_value"><?php echo $friend['pain']?></p>		
					</div>					
				</div>
			</div>
			 -->
		<?php endforeach;?>
	<?php endif;?>	
</div>