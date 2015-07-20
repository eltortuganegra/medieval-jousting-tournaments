<div id="jobs">
	<h1>TRABAJOS</h1>
	<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
	?>
	<table>
		<thead>
			<tr>
				<td>Nivel</td>
				<td>Tipo trabajo</td>
				<td>Mo/H</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $app_rules_level as $level):?>			
				<tr>
					<td><?php echo $level->level?></td>
					<td><?php echo $spearsMaterial[$level->level]->name?></td>
					<td><?php echo number_format( $level->cache, 0,',','.' )?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<p class="voice-over">-"La vida de un caballero es dura y cara. Prestar los servicios como caballero te reportará un extra de monedas para reponer equipo o comprar nuevo con el que seguir machacando a tus adversarios."</p>
	<?php if( $job ):?>
		<div id="jobs_atWorking">
			<h2>CABALLERO TRABAJANDO</h2>
			<p>Actualmente estás trabajando. Puedes cancelar el trabajo pero no recibiras tu paga.</p>
			<p>Tu jornada laboral termina a las <strong class="right"><?php echo $job->date?></strong></p>			
			<p><strong class="right"><a href="/jobs/cancel/id/<?php echo $job->id?>">cancelar</a></strong></p>
			</form>
		</div>
	<?php elseif ( $knight->status == Knights::STATUS_AT_COMBAT):?>
		<div id="jobs_atCombat">
			<p>¡Estas a mitad de un combate.!</p>
			<p>No puedes trabajar hasta que termines el combate así qué machácalo rápido.<p>
			<p><span class="right"><a href="/character/events/sir/<?php echo $knight->name?>">Ir a eventos</a></span></p>
		</div>
	<?php else:?>
		<div id="jobs_start">
			<form action="/jobs" method="post">
				<p>Tu caballero tiene un nivel: <strong class="right"><?php echo $this->user_data['knights']->level?></strong></p>
				<p>El nivel <?php echo $this->user_data['knights']->level?> se cotiza a <strong class="right"><?php echo $app_rules_level[$this->user_data['knights']->level]->cache?> MO/Hora</strong></p>
				<p>Horas que quieres trabajar 
					<select name="hours" class="validate[required] right">
						<option value="">Selecciona</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
				</p>
				<p><span class="right"><input type="submit" value="trabajar"></span></p>
			</form>
		</div>
	<?php endif;?>	
	
	
</div>