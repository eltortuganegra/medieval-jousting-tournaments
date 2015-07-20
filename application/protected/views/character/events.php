<?php //echo $knights_status_template;?>
<div id="events">
	<h1>Sir <?php echo $this->knight->name;?>: eventos</h1>
	<?php 
	//Check total friends
	if( count( $events) == 0 ):?>
		<p>El caballero está a estrenar. No ha realizado ninguna acción.</p>		
	<?php else:?>
		<?php 
		foreach( $events as $key => $value ){
			echo $value;
		}?>
	<?php endif;?>	
</div>