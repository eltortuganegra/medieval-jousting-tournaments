<div id="post_combat">	
	<div id="post_combat_result" class="<?php if($combat->result == Combats::RESULT_FROM_KNIGHT_WIN){echo 'blueKnight';}elseif($combat->result == Combats::RESULT_TO_KNIGHT_WIN){echo 'redKnight';}else{echo 'draw';}?>" >
		<h2>RESULTADO DEL COMBATE</h2>
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
	<div class="blueKnight">
		<h2>EXPERIENCIA</h2>
		<div class="blueKnight_body">			
			<p>Nivel caballero <?php echo $to_knight_postcombat->knight_rival_level;?> - nivel adversario <?php echo $from_knight_postcombat->knight_rival_level;?> experiencia generada <?php echo $from_knight_postcombat->experience_generate;?> PX</p>			
			<?php if($combat->result == Combats::RESULT_FROM_KNIGHT_WIN):?>
				<p>Ganar combate (<?php echo $from_knight_postcombat->percent_by_result;?>%) <span class="right"><?php echo $from_knight_postcombat->experience_generate*$from_knight_postcombat->percent_by_result/100;?> PX</span></p>
			<?php elseif ($combat->result == Combats::RESULT_TO_KNIGHT_WIN):?>
				<p>Perder combate (<?php echo $from_knight_postcombat->percent_by_result;?>%) <span class="right"><?php echo $from_knight_postcombat->experience_generate*$from_knight_postcombat->percent_by_result/100;?> PX</span></p>
			<?php else:?>
				<p>Empatar combate (<?php echo $from_knight_postcombat->percent_by_result;?>%) <span class="right"><?php echo $from_knight_postcombat->experience_generate*$from_knight_postcombat->percent_by_result/100;?> PX</span></p>
			<?php endif;?>
			<?php if( $from_knight_postcombat->injury_type == null):?>			
				<p>Sin lesión <span class="right">0 PX</span></p>
			<?php else:?>
				<p><?php echo $injuryLabels[$from_knight_postcombat->injury_type];?><span class="right"><?php echo CombatsPostcombat::EXPERIENCE_SAME_LEVEL*$from_knight_postcombat->percent_by_injury/100;?> PX</span></p>
			<?php endif;?>
			<p>TOTAL <span class="right"><?php echo $from_knight_postcombat->earned_experience;?> PX</span></p>
			<div class="description">
				<div class="ui_icon">
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>experience.png" title="experiencia" alt="experiencia"/>
				</div>
				<p>EXPERIENCIA</p>
				<p>Total <span class="right"><?php echo number_format($from_knight_postcombat->total_experience, 0, ',','.');?> PX</span></p>
			</div>			
		</div>
		<?php if( count( $from_knight_automatic_object_repairs ) > 0):?>
			<h2>REPARACIONES</h2>
			<div class="blueKnight_body">
				<?php foreach( $from_knight_automatic_object_repairs as $repair ):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$repair->inventory_type.'_'.$repair->class_identificator;?>.png" title="item" alt="item"/>
						</div>
						<p>REPARACIÓN</p>
						<p>PDE <span class="right"><?php echo number_format( $repair->current_pde, 0, ',','.').'/'.number_format( $repair->maximum_pde, 0, ',','.');?></span></p>
						<p>Coste<span class="right"><?php echo number_format( $repair->repair_cost, 0, ',','.');?> M.O.</span></p>
					</div>	
				<?php endforeach;?>
			</div>
		<?php endif;?>
		<?php if( count( $from_knight_downgrades ) > 0):?>
			<h2>PERDIDA DE NIVEL</h2>
			<div class="blueKnight_body">
				<p>La lesión te ha provocado una perdida de experiencia. Tendras que trabajar duro para recuperarte.</p>
				<?php foreach( $from_knight_downgrades as $downgrade ):?>
					<p><strong><?php echo $knight_card_labels[$downgrade->characteristic]?></strong> baja a nivel <strong><?php echo $downgrade->value?></strong></p>
				<?php endforeach;?>
			</div>
		<?php endif;?>
	</div>
	<div class="redKnight">
		<h2>EXPERIENCIA</h2>
		<div class="redKnight_body">			
			<p>Nivel caballero <?php echo $from_knight_postcombat->knight_rival_level;?> - nivel adversario <?php echo $to_knight_postcombat->knight_rival_level;?> experiencia generada <?php echo $to_knight_postcombat->experience_generate;?> PX</p>			
			<?php if($combat->result == Combats::RESULT_TO_KNIGHT_WIN):?>
				<p>Ganar combate (<?php echo $to_knight_postcombat->percent_by_result;?>%) <span class="right"><?php echo $to_knight_postcombat->experience_generate*$to_knight_postcombat->percent_by_result/100;?> PX</span></p>
			<?php elseif ($combat->result == Combats::RESULT_FROM_KNIGHT_WIN):?>
				<p>Perder combate (<?php echo $to_knight_postcombat->percent_by_result;?>%) <span class="right"><?php echo $to_knight_postcombat->experience_generate*$to_knight_postcombat->percent_by_result/100;?> PX</span></p>
			<?php else:?>
				<p>Empatar combate (<?php echo $to_knight_postcombat->percent_by_result;?>%) <span class="right"><?php echo $to_knight_postcombat->experience_generate*$to_knight_postcombat->percent_by_result/100;?> PX</span></p>
			<?php endif;?>
			<?php if( $to_knight_postcombat->injury_type == null):?>			
				<p>Sin lesión <span class="right">0 PX</span></p>
			<?php else:?>				
				<p><?php echo $injuryLabels[$to_knight_postcombat->injury_type];?><span class="right"><?php echo CombatsPostcombat::EXPERIENCE_SAME_LEVEL*$to_knight_postcombat->percent_by_injury/100;?> PX</span></p>
			<?php endif;?>
			<p>TOTAL <span class="right"><?php echo $to_knight_postcombat->earned_experience;?> PX</span></p>
			<div class="description">
				<div class="ui_icon">
					<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>experience.png" title="experiencia" alt="experiencia"/>
				</div>
				<p>EXPERIENCIA</p>
				<p>Total <span class="right"><?php echo number_format($to_knight_postcombat->total_experience, 0, ',','.');?> PX</span></p>
			</div>
		</div>
		<?php if( count( $to_knight_automatic_object_repairs ) > 0):?>
			<h2>REPARACIONES</h2>
			<div class="blueKnight_body">
				<?php foreach( $to_knight_automatic_object_repairs as $repair ):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].$repair->inventory_type.'_'.$repair->class_identificator;?>.png" title="item" alt="item"/>
						</div>
						<p>REPARACIÓN</p>
						<p>PDE actuales <span class="right"><?php echo number_format( $repair->current_pde, 0, ',','.').'/'.number_format( $repair->maximum_pde, 0, ',','.');?></span></p>
						<p>Coste<span class="right"><?php echo number_format( $repair->repair_cost, 0, ',','.');?> M.O.</span></p>
					</div>	
				<?php endforeach;?>
			</div>
		<?php endif;?>
		<?php if( count( $to_knight_downgrades ) > 0):?>
			<h2>PERDIDA DE NIVEL</h2>
			<div class="blueKnight_body">
				<p>La lesión te ha provocado una perdida de experiencia. Tendras que trabajar duro para recuperarte.</p>
				<?php foreach( $to_knight_downgrades as $downgrade ):?>
					<p><strong><?php echo $knight_card_labels[$downgrade->characteristic]?></strong> baja a nivel <strong><?php echo $downgrade->value?></strong></p>
				<?php endforeach;?>
			</div>
		<?php endif;?>
	</div>	
	<div class="clear"></div>
</div>