<div class="combat_status_pending">
	<p class="title">Estado</p>
	<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>Crystal_Clear_app_clock.png" class="ui_icon"/>
	<?php if( !Yii::app()->user->isGuest && $combat->toKnight->id == Yii::app()->user->knights_id && $combat->toKnight->id == $this->knight->id ):?>
	<p class="text "><?php echo '<a href="/character/confirmRejectChallenge/combat/'.$combat->id.'" class="button_red  reject_button" name="'.$combat->id.'">rechazar</a> <a href="/character/confirmAcceptChallenge/combat/'.$combat->id.'" class="button_green accept_button" name="'.$combat->id.'">aceptar</a>';?></p>
	<?php else:?>
	<p class="text">A la espera de la reacción...</p>
	<?php endif;?>	
</div>