<div class="event event_type_combat">
	<div class="event_type_combat_header">
		<h4>COMBATE <span class="right"><?php echo $combat->date;?></span></h4>
	</div>
	<div class="event_type_combat_knights">
		<div class="event_type_combat_knights_from_knight">
			<p><img src="<?php echo  Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['general']?>knight_login_status_<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$combat->fromKnight->id)?'online':'offline';?>.png" class="knight_login_status " title="<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$combat->fromKnight->id)?'¡CONECTADO!':'desconectado';?>"/> <a href="/character/events/sir/<?php echo $combat->fromKnight->name;?>">Sir <?php echo $combat->fromKnight->name;?></a></p>
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$combat->fromKnight->avatars_id;?>.png" alt="avatar" class="ui_icon avatar"/>												
		</div>	
		<div class="event_type_combat_knights_knights_vs">
			<p>vs</p>
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>versus.png" alt="versus" class="ui_icon versus"/>
		</div>
		<div class="event_type_combat_knights_to_knight">
			<p><img src="<?php echo  Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['general']?>knight_login_status_<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$combat->toKnight->id)?'online':'offline';?>.png" class="knight_login_status " title="<?php echo Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$combat->toKnight->id)?'¡CONECTADO!':'desconectado';?>"/><a href="/character/events/sir/<?php echo $combat->toKnight->name;?>">Sir <?php echo $combat->toKnight->name;?></a></p>
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$combat->toKnight->avatars_id;?>.png" alt="avatar" class="ui_icon avatar left"/>												
		</div>
	</div>
	<div class="event_type_combat_status">
		<?php echo $combatStatusHtml;?>
		<?php 
		/*switch( $combat->status ){
			 	case Combats::STATUS_PENDING:
				if( !Yii::app()->user->isGuest && $combat->toKnight->id == $this->knight->id && $combat->toKnight->id == Yii::app()->user->knights_id ){
					//User has received combat. He must to choose accept or reject.
					echo '<a href="#" class="button_red button_reponse_event_combat_type" name="'.$combat->id.'">rechazar</a> <a href="#" class="button_green button_reponse_event_combat_type" name="'.$combat->id.'">aceptar</a>';						
				}else{
					//User is waiting for action
					echo '<img src="'.Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'waiting_rival.png" class="ui_icon waiting_rival"/><p>Esperando reacción de Sir '.$combat->toKnight->name.'</p>';
				}				
				break;
			case Combats::STATUS_ENABLE:
				break;
			case Combats::STATUS_FINISHED:
				//Check result
				break;
						
		}*/?>
	</div>
</div>