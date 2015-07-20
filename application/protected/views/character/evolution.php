<div id="knights_evolution">
	<h1>Sir <?php echo $this->knight->name;?>: evolución</h1>
	<form action="/character/evolution/sir/<?php echo $this->knight->name?>" method="post">
		<p>
			Año <?php echo CHtml::dropDownList( 'filter[year]',$filter['year_selected'], $filter['years']  );?>  
			Mes <?php echo CHtml::dropDownList( 'filter[month]',$filter['month_selected'], $filter['months']  );?>
			<input type="submit" value="aceptar" />
		</p>
	</form>
	<?php if( $is_future_day):?>
		<p>Los oráculos te auguran un futuro prometedor...</p>
	<?php else:?>		
		
		
		<?php $evolution_list = array();?>
		<div id="evolution_chart"></div>
		<div id="evolution_table">
			<?php if( count( $monthlyEvolution)):?>
				<table class="headWhiteBodyBlue">
					<thead>
						<tr>
							<td>Tipo</td>
							<td>Característica</td>
							<td>Valor final</td>
							<td>Experiencia usada</td>
							<td>Fecha</td>
						</tr>
					</thead>				
					<tbody>
						<?php foreach( $monthlyEvolution as $knights_evolution):?>
							<tr <?php echo ($knights_evolution->type0->id == KnightsEvolution::TYPE_UPGRADE)?'':'class="backgroundColorRed"';?>>
								<td><?php echo $knights_evolution->type0->name;?></td>
								<td><?php echo $knightsCard_labels[$knights_evolution->characteristic0->name];?></td>
								<td><?php echo $knights_evolution->value;?></td>
								<td><?php echo $knights_evolution->experiencie_used?></td>
								<td><?php echo $knights_evolution->date?></td>
							</tr>
							<?php //Formateamos los datos
							//Si existe el día sumamos la experiencia usada ese mismo día sino, creamos el día 
							if( isset( $evolution_list[substr($knights_evolution->date, 0, 10) ]) ){
								$evolution_list[substr($knights_evolution->date, 0, 10) ] += $knights_evolution->experiencie_used;
							}else{
								$evolution_list[substr($knights_evolution->date, 0, 10) ] = $knights_evolution->experiencie_used;
							}
							?>						
						<?php endforeach;?>
					</tbody>
				</table>
			<?php else:?>
				<p>No hay evoluciones en el mes.</p>
			<?php endif;?>
			<script language="javascript">
				//app.user.knights_evolution = [
				app.knight.knights_evolution = [
			<?php 
				if( count( $knights_evolution_chart ) > 0 ){
					foreach( $knights_evolution_chart as $key => $value ){						
						echo '["'.$key.'", '.$value.'],' ;
					}
				}					 
			?>
			];
			</script>
			
		</div>
	<?php endif;?>
</div>