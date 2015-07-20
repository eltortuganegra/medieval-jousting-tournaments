<?php //echo $knights_status_template;?>
<div di="knights_stats">
	<h1>Sir <?php echo $knights->name;?>: estadísticas</h1>
	<table class="headWhiteBodyBlue">
		<thead>
			<tr>
				<td>Combates</td>
				<td>total</td>				
			</tr>
			
		</thead>
		<tbody>
		<tr>
				<td>ganados</td>
				<td><?php echo $knights->knightsStats->combats_wins;?></td>				
			</tr>
			<tr>
				<td>ganados con herida</td>
				<td><?php echo $knights->knightsStats->combats_wins_injury;?></td>				
			</tr>
			<tr>
				<td>empatados</td>
				<td><?php echo $knights->knightsStats->combats_draw;?></td>				
			</tr>
			<tr>
				<td>empatados con herida</td>
				<td><?php echo $knights->knightsStats->combats_draw_injury;?></td>				
			</tr>
			<tr>
				<td>perdidos</td>
				<td><?php echo $knights->knightsStats->combats_loose;?></td>				
			</tr>
			<tr>
				<td>perdidos con herida</td>
				<td><?php echo $knights->knightsStats->combats_loose_injury;?></td>				
			</tr>
		</tbody>
	</table>
	
	<table class="headWhiteBodyBlue">
		<thead>
			<tr>
				<td>Otros</td>
				<td>Producido</td>
				<td>Recibido</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Total impactos</td>
				<td><?php echo $knights->knightsStats->hits_total_produced;?></td>
				<td><?php echo $knights->knightsStats->hits_total_received;?></td>
			</tr>
			<tr>
				<td>Total impactos bloqueados</td>
				<td><?php echo $knights->knightsStats->hits_total_blocked;?></td>
				<td><?php echo $knights->knightsStats->hits_total_received_blocked;?></td>
			</tr>
			<tr>
				<td>Total de daño</td>
				<td><?php echo $knights->knightsStats->damage_total_produced;?></td>
				<td><?php echo $knights->knightsStats->damage_total_received;?></td>
			</tr>
			<tr>
				<td>Daño máximo</td>
				<td><?php echo $knights->knightsStats->damage_maximum_produced;?></td>
				<td><?php echo $knights->knightsStats->damage_maximum_received;?></td>
			</tr>
			<tr>
				<td>Total lesiones leves</td>
				<td><?php echo $knights->knightsStats->injury_total_light_produced;?></td>
				<td><?php echo $knights->knightsStats->injury_total_light_received;?></td>
			</tr>
			<tr>
				<td>Total lesiones graves</td>
				<td><?php echo $knights->knightsStats->injury_total_serious_produced;?></td>
				<td><?php echo $knights->knightsStats->injury_total_serious_received;?></td>
			</tr>
			<tr>
				<td>Total lesiones fatales</td>
				<td><?php echo $knights->knightsStats->injury_total_fatality_produced;?></td>
				<td><?php echo $knights->knightsStats->injury_total_fatality_received;?></td>
			</tr>
			<tr>
				<td>Total trampas</td>
				<td><?php echo $knights->knightsStats->tricks_total_used;?></td>
				<td><?php echo $knights->knightsStats->tricks_total_received;?></td>
			</tr>
			<tr>
				<td>Total trampas que han funcionado</td>
				<td><?php echo $knights->knightsStats->tricks_total_used_successful;?></td>
				<td><?php echo $knights->knightsStats->tricks_total_received_successful;?></td>
			</tr>
		</tbody>
	</table>
</div>