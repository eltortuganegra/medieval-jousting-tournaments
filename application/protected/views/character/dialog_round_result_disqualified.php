<div id="post_combat">	
	<div id="post_combat_result" class="<?php if($combat->result == Combats::RESULT_FROM_KNIGHT_WIN){echo 'blueKnight';}elseif($combat->result == Combats::RESULT_TO_KNIGHT_WIN){echo 'redKnight';}else{echo 'draw';}?>" >
		<h2>DESCALIFICACIÓN</h2>
		<div class="body">
			<div class="description">				
			<?php if( $combat->result == Combats::RESULT_FROM_KNIGHT_WIN):?>
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$combat->fromKnight->avatars_id;?>.png" title="Sir <?php echo $combat->fromKnight->name;?>" alt="avatar"/>
					</div>
					<p><strong>GANADOR</strong></p>
					<p>Sir <?php echo $combat->fromKnight->name;?></p>						
			<?php elseif ($combat->result == Combats::RESULT_TO_KNIGHT_WIN):?>
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$combat->toKnight->avatars_id;?>.png" title="Sir <?php echo $combat->toKnight->name;?>" alt="avatar"/>
					</div>
					<p><strong>GANADOR</strong></p>
					<p>Sir <?php echo $combat->toKnight->name;?></p>
			<?php else:?>
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>combats_result_124.png" title="Empate" alt="avatar"/>
					</div>
					<p><strong>EMPATE</strong></p>
					<p>Sin vencedor.</p>
			<?php endif;?>
			<?php switch( $combat->result_by ){
					case Combats::RESULT_BY_THREE_FALL:
						echo '<p>gana por 3 caidas del adversario.</p>';
						break;
					case Combats::RESULT_BY_KO:
						echo '<p>gana por ¡KO!.</p>';
						break;
					case Combats::RESULT_BY_NOT_EQUIPMENT_REPLACE:
						echo '<p>el adversario no tenía equipo suficiente.</p>';
						break;
					case Combats::RESULT_BY_INJURY:
						echo '<p>gana por ¡lesión!.</p>';
						break;
					case Combats::RESULT_BY_DESQUALIFY:
						echo 'por descalificación rival';
						break;
					default:	
						echo '<p>no debería salir.</p>';
						
				}
			?>		
			</div>
		</div>
	</div>
</div>