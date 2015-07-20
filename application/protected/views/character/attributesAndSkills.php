<div id="knight_overview">
<script language="javascript">
	<?php $maxValueAttribute = 1;?>
	<?php foreach( $app_rules_level as $level ):?>
	attribute_cost.level_<?php echo $level->level;?> =  <?php echo $level->attribute_cost;?> ;
	skills_cost.level_<?php echo $level->level;?> = <?php echo $level->skill_cost?>;
	<?php endforeach;?>	
</script>
	<?php //echo $knights_status_template;?>
	<div id="knight_card">
		<h1>Sir <?php echo $this->knight->name;?>: atributos y habilidades</h1>
		<table class="HeadWhiteBodyBlue30Percent">
			<thead>
				<tr>
					<td colspan="3">ATRIBUTOS</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $knight_attributes as $attribute):?>
				<?php if($knight_card->{$attribute->name} > $maxValueAttribute) $maxValueAttribute = $knight_card->{$attribute->name};//Update max value?>	
				<script language="javascript">
					level_cost.<?php echo $attribute->name;?> = attribute_cost.level_<?php echo ($knight_card->{$attribute->name})+1;?>;
				</script>				
					<tr>
						<td><?php echo $knight_card_labels[$attribute->name]?></td>
						<td><span id="knight_card_<?php echo $attribute->name?>_value"><?php echo $knight_card->{$attribute->name};?></span></td>
						<?php if( !Yii::app()->user->isGuest && Yii::app()->user->knights_name == $knight->name):?>
						<td>
							<?php //Comprobamos si tiene suficientes puntos de experiencia para poder subir el atributo ?>					
							<?php if( $app_rules_level[ $knight_card->{$attribute->name}+1]->attribute_cost <= ($knight->experiencie_earned-$knight->experiencie_used  ) ):?>					
								<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'Crystal_Clear_action_edit_add.png'?>" class="ui_levelup ui_levelup_enabled" alt="Subir a nivel <?php echo $knight_card->{$attribute->name}+1;?>" id="<?php echo $attribute->name?>" title="Subir a nivel <?php echo $knight_card->{$attribute->name}+1;?> (<?php echo $app_rules_level[(($knight_card->{$attribute->name})+1)]->attribute_cost?> PX)"/>
							<?php else:?>
								<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'Crystal_Clear_action_edit_add.png'?>" class="ui_levelup ui_levelup_disabled" alt="No hay experiencia suficiente" title="¡No tienes suficiente experiencia disponible!"/>
							<?php endif?>
							
						</td>
						<?php endif;?>
					</tr>
				<?php endforeach;?>			
			</tbody>
		</table>
		<table class="HeadWhiteBodyBlue30Percent">
			<thead>
				<tr>
					<td colspan="<?php echo ( !Yii::app()->user->isGuest && Yii::app()->user->knights_name == $knight->name)?3:2;?>">HABILIDADES</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $knight_skills as $skills):?>					
				<script language="javascript">
					level_cost.<?php echo $skills->name;?> = skills_cost.level_<?php echo ($knight_card->{$skills->name})+1;?>;
				</script>				
					<tr>
						<td><?php echo $knight_card_labels[$skills->name]?></td>
						<td><span id="knight_card_<?php echo $skills->name?>_value"><?php echo $knight_card->{$skills->name};?></span></td>
						<?php if( !Yii::app()->user->isGuest && Yii::app()->user->knights_name == $knight->name):?>
							<td>
								<?php //Comprobamos si tiene suficientes puntos de experiencia para poder subir el atributo ?>					
								<?php if( $app_rules_level[ $knight_card->{$skills->name}+1]->skill_cost <= ($knight->experiencie_earned-$knight->experiencie_used && $knight_card->{$skills->name} < $maxValueAttribute  ) ):?>					
									<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'Crystal_Clear_action_edit_add.png'?>" class="ui_levelup ui_levelup_enabled" alt="Subir a nivel <?php echo $knight_card->{$skills->name}+1;?>" id="<?php echo $skills->name?>" title="Subir a nivel <?php echo $knight_card->{$attribute->name}+1;?> (<?php echo $app_rules_level[(($knight_card->{$skills->name})+1)]->skill_cost?> PX)"/>
								<?php else:?>
									<img src="<?php echo Yii::app()->params['statics_cdn'].Yii::app()->params['paths']['icons'].'Crystal_Clear_action_edit_add.png'?>" class="ui_levelup ui_levelup_disabled" alt="No hay experiencia suficiente" />
								<?php endif?>
								
							</td>
						<?php endif;?>
					</tr>
				<?php endforeach;?>			
			</tbody>
		</table>
		<table class="HeadWhiteBodyBlue30Percent">
			<thead>
				<tr>
					<td colspan="3">SECUNDARIAS</td>
				</td>
			</thead>
			<tbody>
				<tr>
					<td>Aguante</td>
					<td><span id="endurance"><?php echo ($knight_card->constitution+$knight_card->will)*3;?></td>				
				</tr>
				<tr>
					<td>Vitalidad</td>
					<td><span id="life"><?php echo $knight_card->constitution*2;?></span></td>				
				</tr>
				<tr>
					<td>Def.Contundente</td>
					<td><span id="defense"><?php echo floor($knight_card->constitution/2);?></span></td>
				</tr>
				<tr>
					<td>Fama</td>
					<td><span id="fame"><?php echo floor( ($knight_card->charisma + $knight_card->act )/2 );?></span></td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="description">	
		<h4>ATRIBUTOS</h4>
		<p><strong>FUERZA</strong>: determina la fuerza muscular del personaje. El equipo puede requerir una fuerza mínima para poder utilizarlo en combate.</p>
		<p><strong>DESTREZA</strong>: determina la capacidad del caballero a la hora de controlar el cuerpo. A más destreza mejores reflejos, velocidad y coordinación. Se utiliza en la defensa de los golpes de otros caballeros.</p>
		<p><strong>CONSTITUCIÓN</strong>: determina la vitalidad y la resistencia física del caballero. La constitución influye en el calculo del aguante, la vitalidad, la defensa contundente y la capacidad de recuperación del dolor.</p>
		<p><strong>PERCEPCIÓN</strong>: determina la capacidad de percibir el caballero a través de los sentidos. Se utiliza para descubrir trampas utilizadas por adversarios.</p>
		<p><strong>INTELIGENCIA</strong>: determina la capacidad de entender y resolver problemas. Utilizada para encontrar equipo en el mercado medieval.</p>
		<p><strong>HABILIDAD</strong>: determina la capacidad del caballero a la hora de usar objetos. A más habilidad mejor control de la lanza y mayor daño. Interviene en la cantidad de daño que produce el caballero.</p>
		<p><strong>CARISMA</strong>: determina la capacidad de atraer o facinar del caballero. Es muy útil para atraer a la gente a los combates. Influye en la cantidad de personas, y por tanto dinero, que vienen a ver el combate.</p>
		<p><strong>VOLUNTAD</strong>: determina la capacidad del personaje para superar obstáculos. Cuando un caballero tiene dolor, ya sea por una lesión o que ha sufrido algún tipo de trampa, este puede ignorarlo si tiene la suficiente voluntad.</p>
		<h4>HABILIDADES</h4>
		<p><strong>LANZA</strong>: determina la capacidad de uso de este arma. Utilizado para calcular el daño que produce un caballero.</p>
		<p><strong>ESCUDO</strong>: determina la capacidad de uso de esta defensa. Utilizado para calcular la cantidad de daño que es capaz de absover el caballero.</p>
		<p><strong>ACTUAR</strong>: determina la capacidad del caballero para interactuar con el público del combate. A mayor capacidad, más fans creará y más público vendrá a sus combates.</p>
		<p><strong>MERCADEAR</strong>: determina capacidad del caballero a la hora de moverse por el mercado. A mayor habilidad podrá encontrar equipo más dificil de obtener.</p>
		<p><strong>MANIPULACIÓN</strong>: determina la capacidad de influir en otras personas. Utilizada para convencer un tercero en tus planes nobles.</p>
		<p><strong>CONCENTRACIÓN</strong>: determina la capacidad del caballero de llevar una tarea a cabo a pesar de las distracciones. Dependiendo de la concentración del caballero puede haber determinadas trampas que hagan que el caballero pierda la concetración.</p>
		<p><strong>ALERTA</strong>: determina la capacidad del caballero de darse cuenta de ciertras trampas. Si el caballero está lo suficientemente alerta las trampas no tendrán efecto.</p>
		<p><strong>SIGILO</strong>: determina la capacidad dle caballero para pasar desapercibido. Utilizado para hacer trampas.</p>
		<h4>HABILIDADES SECUNDARIAS</h4>
		<p><strong>AGUANTE</strong>: determina la cantidad de daño que aguanta el caballero antes de caer inconsciente. Un caballero queda inconsciente cuando sus puntos de aguante llegan a 0. Si la cantidad de daño que recibe es mayor que los puntos de aguante el daño se resta de la vitalidad y se produce una lesión. Su valor depende de "(voluntad+constitución)*2"</p>
		<p><strong>VITALIDAD</strong>: determina la cantidad de vida de un personaje. El valor es "constitución * 2".</p>
		<p><strong>DEFENSA CONTUNDENTE</strong>: determina la capacidad de absorver impactos. Su valor es "costitución / 2".</p>
		<p><strong>FAMA</strong>: determina la cantidad de personas que conocen al caballero. Cuanto más famoso sea un caballero más público tendrá en sus combates y más caché podrá cobrar por esos combates. Su valor es la media (redondeada hacia abajo) de "carisma + actuar".</p>
	</div>
</div>
