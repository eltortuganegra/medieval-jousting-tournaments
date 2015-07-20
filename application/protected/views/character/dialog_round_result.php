<div id="round_result">
	<div id="round_result_header">
		<div class="blue_knight">
			<h2>Sir <?php echo $from_knight->name;?></h2>
			<div class="status_knight">
				<div class="ui_icon">
					<img src="<?php echo Yii::app()->params['paths']['avatars'].$from_knight->avatars_id;?>.png" class="avatar" alt="avatar"/>
				</div>
				<div class="header_knight_profile"> 
					<div class="ui_icon ui_icon_endurance" title="Aguante del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_laptop_battery.png" />				
						<p class="ui_icon_value"><?php echo $from_knight_round_data->knights_endurance;?></p>
					</div>		
					<div class="ui_icon ui_icon_life" title="Vida del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Nuvola_apps_package_favorite.png">		
						<p class="ui_icon_value"><?php echo $from_knight_round_data->knights_life;?></p>		
					</div>
					<div class="ui_icon ui_icon_pain" title="Dolor del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_cache.png">		
						<p class="ui_icon_value"><?php echo $from_knight_round_data->knights_pain;?></p>		
					</div>				
				</div>
			</div>
		</div>
		<div class="red_knight">
			<h2>Sir <?php echo $to_knight->name;?></h2>
			<div class="status_knight">
				<div class="ui_icon">
					<img src="<?php echo Yii::app()->params['paths']['avatars'].$to_knight->avatars_id;?>.png" class="avatar" alt="avatar"/>
				</div>
				<div class="header_knight_profile"> 
					<div class="ui_icon ui_icon_endurance" title="Aguante del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_laptop_battery.png" />				
						<p class="ui_icon_value"><?php echo $to_knight_round_data->knights_endurance;?></p>
					</div>		
					<div class="ui_icon ui_icon_life" title="Vida del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Nuvola_apps_package_favorite.png">		
						<p class="ui_icon_value"><?php echo $to_knight_round_data->knights_life;?></p>		
					</div>
					<div class="ui_icon ui_icon_pain" title="Dolor del caballero">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>Crystal_Clear_app_cache.png">		
						<p class="ui_icon_value"><?php echo $to_knight_round_data->knights_pain;?></p>		
					</div>				
				</div>
			</div>
		</div>		
	</div>	
	<div id="round_result_body">		
		<div id="round_body_modifiers">
			<?php echo $modifiers;?>
		</div>		
		<div id="round_body_impacts">
			<div class="blue_knight">
				<h2>IMPACTO</h2>
				<?php if( $from_knight_round_data->is_received_impact_defended ):?>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$from_knight_round_data->shield_id?>.png" />
					</div>
					<h4>DAÑO RECIBIDO<span class="right">+<?php echo $from_knight_round_data->received_damage;?></span></h4>
					<p>Golpe BLOQUEADO de Sir <?php echo $to_knight->name?></p>
					<p>Habilidad(<?php echo $to_knight_round_data->knights_skill?>)+Lanza(<?php echo $to_knight_round_data->knights_spear?>)<span class="right">+<?php echo $to_knight_round_data->knights_skill+$to_knight_round_data->knights_spear?></span></p>						
					<p>Daño lanza(<?php echo $to_knight_equipment['spear']->damage+$to_knight_round_data->attack_throw?>)-Dolor(<?php echo $to_knight_pain_value?>)<span class="right"><?php $from_knight_spear_less_pain = $to_knight_equipment['spear']->damage+$to_knight_round_data->attack_throw-$to_knight_pain_value; echo ( ( $from_knight_spear_less_pain >= 0 ) ? '+' : '' ).$from_knight_spear_less_pain;?></span></p>					
				</div>					
				<?php else:?>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$to_knight_round_data->spears_id?>.png" />
					</div>
					<h4>DAÑO RECIBIDO<span class="right">+<?php echo $from_knight_round_data->received_damage;?></span></h4>					
					<p>Golpe DIRECTO de Sir <?php echo $to_knight->name?></p>
					<p>Habilidad(<?php echo $to_knight_round_data->knights_skill?>)+Lanza(<?php echo $to_knight_round_data->knights_spear?>)<span class="right">+<?php echo $to_knight_round_data->knights_skill+$to_knight_round_data->knights_spear?></span></p>
					<p>Daño lanza(<?php echo $to_knight_equipment['spear']->damage+$to_knight_round_data->attack_throw?>)-Dolor(<?php echo $to_knight_pain_value = ($to_knight_round_data->is_pain_throw_pass)?0:$to_knight_round_data->knights_pain?>)<span class="right"><?php $from_knight_spear_less_pain = $to_knight_equipment['spear']->damage+$to_knight_round_data->attack_throw-$to_knight_pain_value; echo ( ( $from_knight_spear_less_pain >= 0 ) ? '+' : '' ).$from_knight_spear_less_pain;?></span></p>					
				</div>				
				<?php endif;?>				
				
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$from_knight_round_data->armour_id?>.png" />
					</div>
					<h4>DAÑO DEFENDIDO<span class="right">+<?php echo $from_knight_round_data->defended_damage;?></h4>
					<p>Defensa de Sir <?php echo $from_knight->name?></span></p>
					<p>Destreza(<?php echo $from_knight_round_data->knights_dexterity?>)+escudo(<?php echo $from_knight_round_data->knights_shield?>)<span class="right">+<?php echo $from_knight_round_data->knights_dexterity+$from_knight_round_data->knights_shield?></span></p>
					<p>Armadura(<?php echo $from_knight_equipment['armour']->endurance+$from_knight_round_data->defense_throw?>)+Def. contundente(<?php echo floor($from_knight_round_data->knights_constitution/2)?>)<span class="right">+<?php echo $from_knight_equipment['armour']->endurance+$from_knight_round_data->defense_throw+floor($from_knight_round_data->knights_constitution/2)?></span></p>					
					<p>Resistencia escudo(<?php echo ( $from_knight_round_data->is_received_impact_defended )?$from_knight_equipment['shield']->endurance:0?>)-dolor(<?php echo $from_knight_pain_value?>)
						<?php if ($from_knight_round_data->is_received_impact_defended):?>
							<?php if ($from_knight_equipment['shield']->endurance - $from_knight_pain_value >=0 ):?>							
								<span class="right">+<?php echo $from_knight_equipment['shield']->endurance - $from_knight_pain_value?></span></p>
							<?php else:?>
								<span class="right"><?php echo $from_knight_equipment['shield']->endurance - $from_knight_pain_value?></span></p>
							<?php endif;?>
						<?php else:?>
							<span class="right"><?php echo 0 - $from_knight_pain_value?></span></p>
						<?php endif;?>
					</p>
				</div>				
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$from_knight->avatars_id?>.png" />
					</div>
					<h4>DAÑO TOTAL<span class="right"><?php echo ($from_knight_total_damage+$from_knight_round_data->extra_damage<0)?'< 0':'+'.($from_knight_total_damage+$from_knight_round_data->extra_damage);?></span></h4>						
					<p>Daño recibido <span class="right">+<?php echo $from_knight_round_data->received_damage?></span></p>
					<p>Daño defendido <span class="right">-<?php echo $from_knight_round_data->defended_damage?></span></p>											
					<p>Daño extra<span class="right">+<?php echo $from_knight_round_data->extra_damage;?></span></p>
				</div>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>round_result_<?php echo $from_knight_round_data->status?>.png" />
					</div>					
						<?php
						switch( $from_knight_round_data->status ){
							case RoundsData::STATUS_RESISTED:
						?>
								<h4>¡AGUANTADO!</h4>								
								<p>Aguante inicial<span class="right"><?php echo $from_knight_round_data->knights_endurance;?></span></p>
								<p>Daño total <span class="right">- <?php echo $from_knight_total_damage+$from_knight_round_data->extra_damage;?></span></p>
								<p>Aguante final <span class="right"><?php echo $from_knight_round_data->knights_endurance-$from_knight_total_damage-$from_knight_round_data->extra_damage;?></span></p>
						<?php 
								break;
							case RoundsData::STATUS_KNOCK_DOWN:
						?> 
								<h4>¡DERRIBADO!</h4>
								<p>Aguante incial<span class="right"><?php echo $from_knight_round_data->knights_endurance;?></span></p>
								<p>Daño total <span class="right">- <?php echo $from_knight_total_damage+$from_knight_round_data->extra_damage;?></span></p>
								<p>Aguante final <span class="right"><?php echo $from_knight_round_data->knights_endurance-$from_knight_total_damage-$from_knight_round_data->extra_damage;?></span></p>
						<?php
								break;
							case RoundsData::STATUS_INJURIED:																 						
						?>
							<h4>¡LESIONADO!<span class="right"><?php echo $injuryType[$from_knight_round_data->injury_type];?></span></h4>
							<p>Aguante inicial<span class="right">+<?php echo $from_knight_round_data->knights_endurance;?></span></p>
							<p>Vida <span class="right">+<?php echo $from_knight_round_data->knights_life?></span></p>							
							<p>Daño total <span class="right">-<?php echo $from_knight_total_damage+$from_knight_round_data->extra_damage;?></span></p>						
							
						<?php 
								break;
							case RoundsData::STATUS_KNOCK_OUT:
						?>
							<h4>¡KO!</h4>							
							<p>Aguante inicial<span class="right"><?php echo $from_knight_round_data->knights_endurance;?></span></p>
							<p>Daño total <span class="right">- <?php echo $from_knight_total_damage+$from_knight_round_data->extra_damage;?></span></p>
							<p>Aguante actual <span class="right"><?php echo $from_knight_round_data->knights_endurance-$from_knight_total_damage-$from_knight_round_data->extra_damage;?></span></p>
						<?php break;							
							default:
						}//
						?>									
				</div>
				<h2>ESTADO DEL EQUIPO</h2>				
				<?php if( $from_knight_round_data->is_spear_destroyed):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$from_knight_round_data->spears_id?>.png" />
						</div>
						<h4>¡LANZA DESTRUIDA!</h4>					
						<p>PDE <span class="right"><?php echo $from_knight_round_data->spears_object_pde_initial;?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $from_knight_round_data->pde_spear_loosed;?></span></p>
						<p>PDE actuales<span class="right">DESTRUIDA</span></p>
					</div>						
				<?php else:?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$from_knight_round_data->spears_id?>.png" />
						</div>
						<h4>ESTADO LANZA</h4>					
						<p>PDE <span class="right"><?php echo $from_knight_round_data->spears_object_pde_initial;?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $from_knight_round_data->pde_spear_loosed;?></span></p>
						<p>PDE actuales<span class="right"><?php echo $from_knight_round_data->spears_object_pde_initial-$from_knight_round_data->pde_spear_loosed;?></span></p>
					</div>
				<?php endif;?>
				<?php if( $from_knight_round_data->is_shield_destroyed ):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$from_knight_round_data->shield_id?>.png" />
						</div>
						<h4>¡DESTRUIDO!</h4>							
						<p>PDE<span class="right"><?php echo $from_knight_round_data->shield_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $from_knight_round_data->pde_shield_loosed?></span></p>
						<p>PDE actuales<span class="right">DESTRUIDO</span></p>
					</div>
				<?php else:?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$from_knight_round_data->shield_id?>.png" />
						</div>
						<h4>ESTADO DEL ESCUDO</h4>							
						<p>PDE<span class="right"><?php echo $from_knight_round_data->shield_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $from_knight_round_data->pde_shield_loosed?></span></p>
						<p>PDE actuales<span class="right"><?php echo $from_knight_round_data->shield_object_pde_initial-$from_knight_round_data->pde_shield_loosed?></span></p>						
					</div>
				<?php endif;?>
				<?php if( $from_knight_round_data->is_armour_destroyed):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$from_knight_round_data->armour_id?>.png" />
						</div>
						<h4>¡ARMADURA DESTRUIDA!</h4>
						<p>PDE <span class="right"><?php echo $from_knight_round_data->armour_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $from_knight_round_data->pde_armour_loosed?></span></p>
						<p>PDE actuales<span class="right">DESTRUIDA</span></p>
					</div>
				<?php else:?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$from_knight_round_data->armour_id?>.png" />
						</div>
						<h4>ESTADO DE LA ARMADURA</h4>
						<p>PDE <span class="right"><?php echo $from_knight_round_data->armour_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $from_knight_round_data->pde_armour_loosed?></span></p>
						<p>PDE actuales<span class="right"><?php echo $from_knight_round_data->armour_object_pde_initial-$from_knight_round_data->pde_armour_loosed?></span></p>						
					</div>
				<?php endif;?>
			</div>
			<div class="red_knight">
				<h2>IMPACTO</h2>
				<?php if( $to_knight_round_data->is_received_impact_defended ):?>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$to_knight_round_data->shield_id?>.png" />
					</div>
					<h4>DAÑO RECIBIDO<span class="right">+<?php echo $to_knight_round_data->received_damage;?></span></h4>
					<p>Golpe BLOQUEADO de Sir <?php echo $from_knight->name?></p>	
					<p>Habilidad(<?php echo $from_knight_round_data->knights_skill?>)+Lanza(<?php echo $from_knight_round_data->knights_spear?>)<span class="right">+<?php echo $from_knight_round_data->knights_skill+$from_knight_round_data->knights_spear?></span></p>						
					<p>Daño lanza(<?php echo $from_knight_equipment['spear']->damage+$from_knight_round_data->attack_throw?>)-Dolor(<?php echo $from_knight_pain = ($from_knight_round_data->is_pain_throw_pass)?0:$from_knight_round_data->knights_pain?>)<span class="right"><?php $to_knight_spear_less_pain = $from_knight_equipment['spear']->damage+$from_knight_round_data->attack_throw-$from_knight_pain;echo (( $to_knight_spear_less_pain>=0)  ? '+' : '' ).$to_knight_spear_less_pain?></span></p>					
				</div>					
				<?php else:?>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$from_knight_round_data->spears_id?>.png" />
					</div>
					<h4>DAÑO RECIBIDO<span class="right">+<?php echo $to_knight_round_data->received_damage;?></h4>					
					<p>Golpe DIRECTO de Sir <?php echo $from_knight->name?></p>	
					<p>Habilidad(<?php echo $from_knight_round_data->knights_skill?>)+Lanza(<?php echo $from_knight_round_data->knights_spear?>)<span class="right">+<?php echo $from_knight_round_data->knights_skill+$from_knight_round_data->knights_spear?></span></p>						
					<p>Daño lanza(<?php echo $from_knight_equipment['spear']->damage+$from_knight_round_data->attack_throw?>)-Dolor(<?php echo $from_knight_pain = ($from_knight_round_data->is_pain_throw_pass)?0:$from_knight_round_data->knights_pain?>)<span class="right"><?php $to_knight_spear_less_pain = $from_knight_equipment['spear']->damage+$from_knight_round_data->attack_throw-$from_knight_pain;echo (( $to_knight_spear_less_pain>=0)  ? '+' : '' ).$to_knight_spear_less_pain?></span></p>
				</div>				
				<?php endif;?>				
				
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$to_knight_round_data->armour_id?>.png" />
					</div>
					<h4>DAÑO DEFENDIDO<span class="right">+<?php echo $to_knight_round_data->defended_damage;?></h4>
					<p>Defensa de Sir <?php echo $to_knight->name?></span></p>
					<p>Destreza(<?php echo $to_knight_round_data->knights_dexterity?>)+escudo(<?php echo $to_knight_round_data->knights_shield?>)<span class="right">+<?php echo $to_knight_round_data->knights_dexterity+$to_knight_round_data->knights_shield?></span></p>
					<p>Armadura(<?php echo $to_knight_equipment['armour']->endurance+$to_knight_round_data->defense_throw?>)+Def. contundente(<?php echo floor($to_knight_round_data->knights_constitution/2)?>)<span class="right">+<?php echo $to_knight_equipment['armour']->endurance+$to_knight_round_data->defense_throw+floor($to_knight_round_data->knights_constitution/2)?></span></p>
					<p>Resistencia escudo(<?php echo ( $to_knight_round_data->is_received_impact_defended )?$to_knight_equipment['shield']->endurance:0?>)-dolor(<?php echo $to_knight_pain_value?>)
						<?php if($to_knight_round_data->is_received_impact_defended):?>
							<?php if ( $to_knight_equipment['shield']->endurance - $to_knight_pain_value >=0 ):?>							
								<span class="right">+<?php echo $to_knight_equipment['shield']->endurance - $to_knight_pain_value?></span></p>
							<?php else:?>
								<span class="right"><?php echo $to_knight_equipment['shield']->endurance - $to_knight_pain_value?></span></p>
							<?php endif;?>
						<?php else:?>
							<span class="right"> <?php echo 0 - $to_knight_pain_value?></span></p>
						<?php endif;?>
					</p>
				</div>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['avatars'].$to_knight->avatars_id?>.png" />
					</div>
					<h4>DAÑO TOTAL<span class="right"><?php echo ($to_knight_total_damage+$to_knight_round_data->extra_damage<0)?'< 0':'+'.($to_knight_total_damage+$to_knight_round_data->extra_damage);?></span></h4>						
					<p>Daño recibido <span class="right">+<?php echo $to_knight_round_data->received_damage?></span></p>
					<p>Daño defendido <span class="right">-<?php echo $to_knight_round_data->defended_damage?></span></p>											
					<p>Daño extra<span class="right">+<?php echo $to_knight_round_data->extra_damage;?></span></p>
				</div>
				<div class="description">
					<div class="ui_icon">
						<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons']?>round_result_<?php echo $to_knight_round_data->status?>.png" />
					</div>					
						<?php
						switch( $to_knight_round_data->status ){
							case RoundsData::STATUS_RESISTED:
						?>
								<h4>¡AGUANTADO!</h4>
								<p>Aguante inicial <span class="right"><?php echo $to_knight_round_data->knights_endurance;?></span></p>
								<p>Daño total <span class="right">- <?php echo $to_knight_total_damage+$to_knight_round_data->extra_damage;?></span></p>
								<p>Aguante final <span class="right"><?php echo $to_knight_round_data->knights_endurance-$to_knight_total_damage-$to_knight_round_data->extra_damage;?></span></p>
						<?php 
								break;
							case RoundsData::STATUS_KNOCK_DOWN:
						?> 
								<h4>¡DERRIBADO!</h4>
								<p>Aguante inicial<span class="right"><?php echo $to_knight_round_data->knights_endurance;?></span></p>
								<p>Daño total <span class="right">- <?php echo $to_knight_total_damage+$to_knight_round_data->extra_damage;?></span></p>
								<p>Aguante final <span class="right"><?php echo $to_knight_round_data->knights_endurance-$to_knight_total_damage-$to_knight_round_data->extra_damage;?></span></p>
						<?php
								break;
							case RoundsData::STATUS_INJURIED:																 						
						?>
							<h4>¡LESIONADO!<span class="right"><?php echo $injuryType[$to_knight_round_data->injury_type];?></span></h4>
							<p>Aguante <span class="right">+<?php echo $to_knight_round_data->knights_endurance;?></span></p>
							<p>Vida <span class="right">+<?php echo $to_knight_round_data->knights_life?></span></p>							
							<p>Daño total <span class="right">-<?php echo $to_knight_total_damage+$from_knight_round_data->extra_damage;?></span></p>	
						<?php
								break; 
							case RoundsData::STATUS_KNOCK_OUT:
						?>
								<h4>¡KO!</h4>
								<p>Aguante inicial<span class="right"><?php echo $to_knight_round_data->knights_endurance;?></span></p>
								<p>Daño total <span class="right">- <?php echo $to_knight_total_damage+$to_knight_round_data->extra_damage;?></span></p>
								<p>Aguante final <span class="right"><?php echo $to_knight_round_data->knights_endurance-$to_knight_total_damage-$to_knight_round_data->extra_damage;?></span></p>
							
						<?php 	break; 	
							default:
						}//
						?>									
				</div>
				<h2>ESTADO DEL EQUIPO</h2>				
				<?php if( $to_knight_round_data->is_spear_destroyed):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$to_knight_round_data->spears_id?>.png" />
						</div>
						<h4>¡LANZA DESTRUIDA!</h4>					
						<p>PDE <span class="right"><?php echo $to_knight_round_data->spears_object_pde_initial;?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $to_knight_round_data->pde_spear_loosed;?></span></p>
						<p>PDE actuales<span class="right">DESTRUIDA</span></p>
					</div>						
				<?php else:?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_SPEAR.'_'.$to_knight_round_data->spears_id?>.png" />
						</div>
						<h4>ESTADO LANZA</h4>					
						<p>PDE <span class="right"><?php echo $to_knight_round_data->spears_object_pde_initial;?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $to_knight_round_data->pde_spear_loosed;?></span></p>
						<p>PDE actuales<span class="right"><?php echo $to_knight_round_data->spears_object_pde_initial-$to_knight_round_data->pde_spear_loosed;?></span></p>
					</div>
				<?php endif;?>
				<?php if( $to_knight_round_data->is_shield_destroyed ):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$to_knight_round_data->shield_id?>.png" />
						</div>
						<h4>¡DESTRUIDO!</h4>							
						<p>PDE<span class="right"><?php echo $to_knight_round_data->shield_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $to_knight_round_data->pde_shield_loosed?></span></p>
						<p>PDE actuales<span class="right">DESTRUIDO</span></p>
					</div>
				<?php else:?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$to_knight_round_data->shield_id?>.png" />
						</div>
						<h4>ESTADO DEL ESCUDO</h4>							
						<p>PDE<span class="right"><?php echo $to_knight_round_data->shield_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $to_knight_round_data->pde_shield_loosed?></span></p>
						<p>PDE actuales<span class="right"><?php echo $to_knight_round_data->shield_object_pde_initial-$to_knight_round_data->pde_shield_loosed?></span></p>						
					</div>
				<?php endif;?>
				<?php if( $to_knight_round_data->is_armour_destroyed):?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$to_knight_round_data->armour_id?>.png" />
						</div>
						<h4>¡ARMADURA DESTRUIDA!</h4>
						<p>PDE <span class="right"><?php echo $to_knight_round_data->armour_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $to_knight_round_data->pde_armour_loosed?></span></p>
						<p>PDE actuales<span class="right">DESTRUIDA</span></p>
					</div>
				<?php else:?>
					<div class="description">
						<div class="ui_icon">
							<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['items'].Inventory::EQUIPMENT_TYPE_ARMOUR.'_'.$to_knight_round_data->armour_id?>.png" />
						</div>
						<h4>ESTADO DE LA ARMADURA</h4>
						<p>PDE <span class="right"><?php echo $to_knight_round_data->armour_object_pde_initial?></span></p>
						<p>PDE perdidos<span class="right">- <?php echo $to_knight_round_data->pde_armour_loosed?></span></p>
						<p>PDE actuales<span class="right"><?php echo $to_knight_round_data->armour_object_pde_initial-$to_knight_round_data->pde_armour_loosed?></span></p>														
					</div>
				<?php endif;?>
				</div>
			</div>			
		</div>
	</div>
</div>