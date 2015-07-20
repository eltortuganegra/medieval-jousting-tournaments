<?php //echo $knights_status_template;?>
<div id="achievements">
	<h1>Sir <?php echo $knights->name;?>: logros</h1>
	<?php 
	//Check total friends
	if( count( $knights->knightsAchievements) == 0 ):?>
		<p>Con mucho potencial pero todavía sin frutos. Resumiendo 0 logros.</p>		
	<?php else:?>
		<p>Parece que hay algún logro que mostrar...</p>
	<?php endif;?>	
</div>