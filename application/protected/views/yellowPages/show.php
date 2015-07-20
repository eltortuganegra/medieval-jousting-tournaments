<div id="yellow_pages_show">
	<h1>PÁGINAS AMARILLAS MEDIEVALES</h1>
	<ul class="yellow_pages_menu">
	<?php //Make ul   
	foreach( $yellow_pages_total as $letter_total){	
		$classLi = '';
		if($letter_total->letter0->name == $letter ) $classLi = 'class="selected"';	
		if( $letter_total->total ){
			echo '<li '.$classLi.'/><a href="/yellowPages/show/letter/'.$letter_total->letter0->name.'">'.$letter_total->letter0->name.'</a>';
		}else{
			echo '<li '.$classLi.'/>'.$letter_total->letter0->name.'';
		}		
	}?>
	</ul>	
	<?php if($errno):?>
		<p><?php echo $error?></p>
	<?php else:?>
		<h4>Caballeros que comienzan con la letra <?php echo $letter?></h4>		
		<div id="knight_list">
			<?php if( count($knights_list) ):?>			
				<?php foreach( $knights_list as $knight):?>
					<?php $this->renderPartial('/knights/_miniview', array('model'=>$knight->knights));?>	
				<?php endforeach;?>
			<?php else:?>
				<p>No hay ningún caballero registrado.</p>
			<?php endif;?>
		</div>
		<ul class="paginator">
			<?php for($i=1;$i<=$totalPages;$i++){
				if( $i == $page){
					echo '<li class="selected"/>'.$i;
				}else{
					echo '<li/>'.$i; 
				}
			}?>
		</ul>
	<?php endif;?>
</div>