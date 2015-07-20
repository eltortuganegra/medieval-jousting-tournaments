<div class="event event_type_knights_evolution">	
	<h4>EVOLUCIÓN <span class="right"><?php echo $evolution->date?></span></h4>	
	<?php if( $evolution->type == KnightsEvolution::TYPE_UPGRADE):?>			
		<p>Sir <?php echo $this->knight->name;?> ha <span class="colorBlue">subido</span> el nivel de <strong class="colorBlue"><?php echo KnightsCard::getNameAttributeLabel( $evolution->characteristic0->name );?></strong>  a <strong class="colorBlue"><?php echo $evolution->value;?></strong></p>
	<?php else:?>			
		<p>Sir <?php echo $this->knight->name;?> ha <span class="colorRed">bajado</span> el nivel de <strong><?php echo KnightsCard::getNameAttributeLabel( $evolution->characteristic0->name );?></strong>  a <strong><?php echo $evolution->value;?></strong> debido a su último combate.</p>
	<?php endif;?>
</div>