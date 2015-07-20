<div id="pre_combat">	
	<table id="combatPoster">
		<thead>
			<tr>
				<td colspan="3">CARTEL</td>
			</tr>
		</thead>
		<tbody>		
			<tr>
				<td class="leftCorner"><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$combat->fromKnight->avatars_id;?>.png" class="avatar" alt="avatar"/></td>
				<td class="textAlignCenter">VS</td>
				<td class="rightCorner"><img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$combat->toKnight->avatars_id;?>.png" class="avatar" alt="avatar"/></td>
			</tr>
			<tr>
				<td class="leftCorner">Sir <?php echo $combat->fromKnight->name?></td>
				<td class="textAlignCenter"><strong>NOMBRE</strong></td>
				<td class="rightCorner">Sir <?php echo $combat->toKnight->name?> </td>
			</tr>
			<tr>
				<td class="leftCorner"><?php echo $combat->combatsPrecombat->from_knight_cache;?></td>
				<td class="textAlignCenter"><abbre title="M.O. media por combate"><strong>CACHÉ</strong></abbre></td>
				<td class="rightCorner"><?php echo $combat->combatsPrecombat->to_knight_cache;?></td>
			</tr>
			<tr>
				<td class="leftCorner"><?php echo $combat->combatsPrecombat->from_knight_fame;?></td>
				<td class="textAlignCenter"><strong>FAMA</strong></td>
				<td class="rightCorner"><?php echo $combat->combatsPrecombat->to_knight_fame;?></td>
			</tr>
			<tr>
				<td class="leftCorner"><?php echo number_format( ($combat->combatsPrecombat->from_knight_fans_throw + $combat->combatsPrecombat->from_knight_fame)*100,0,',','.');?></td>
				<td class="textAlignCenter"><strong>FANS</strong></td>
				<td class="rightCorner"><?php echo number_format( ($combat->combatsPrecombat->to_knight_fans_throw + $combat->combatsPrecombat->to_knight_fame)*100,0,',','.');?></td>
			</tr>
			<tr>
				<td class="leftCorner"><?php echo number_format( $combat->combatsPrecombat->from_knight_gate,0 ,',', '.');?></td>
				<td class="textAlignCenter"><strong>GANANCIAS (M.O.)</strong></td>
				<td class="rightCorner"><?php echo number_format( $combat->combatsPrecombat->to_knight_gate, 0, ',', '.');?></td>
			</tr>
		</tbody>
	</table>	
	<div id="financial">
		<h4>PÚBLICO Y RECAUDACIÓN</h4>
		<div class="ui_icon">
			<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'];?>precombat.png" alt="dinero" />
		</div>		
		<p><strong>PÚBLICO</strong>:<span><?php echo number_format( (($combat->combatsPrecombat->from_knight_fans_throw + $combat->combatsPrecombat->from_knight_fame)*100)+(($combat->combatsPrecombat->to_knight_fans_throw + $combat->combatsPrecombat->to_knight_fame)*100),0,',','.')?> FANS</span></p>
		<p><strong>RECAUDACIÓN</strong>:<span><?php echo number_format( $combat->combatsPrecombat->from_knight_gate+$combat->combatsPrecombat->to_knight_gate, 0,',','.');?> M.O.</span>
		</p>
		<p class="note">La caché del jugador y el número de fans determinan el dinero que gana en el combate. Este dinero puede variar dependiendo del resultado final del combate.</p>
	</div>	
	<!-- tricks -->
	<div class="clear"></div>
</div>